<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Exception\SecurityException;
use Cake\Http\Exception\NotFoundException;
use Cake\Log\Log;
use Cake\Core\Configure;
use Cake\I18n\FrozenTime;
use Cake\Utility\Security;

use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use \LINE\LINEBot\Constant\HTTPHeader;

/**
 * KakeiboApi Controller
 *
 *
 * @method \App\Model\Entity\KakeiboApi[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class KakeiboApiController extends AppController
{

    public function initialize():void
    {
        parent::initialize();
        $this->loadComponent('Kakeibo');
        $this->Authentication->addUnauthenticatedActions(['webhook']);
    }

    public function webhook(){
        $this->loadModel('Users');
        $this->loadModel('LogTmps');
        $this->loadModel('UserTokens');
        
        $jsonString = file_get_contents('php://input');
        if(empty($jsonString)){
            throw new NotFoundException();
        }
        $request = json_decode($jsonString, true);
        $lineConfig = Configure::read("line_settings");
        $LogType = Configure::read("log_types");
        //リクエストのシグネチャを確認
        if( base64_encode(hash_hmac('sha256', $jsonString, $lineConfig['bot']['channelSecret'], true))
            == $_SERVER["HTTP_X_LINE_SIGNATURE"]
        ){
            $message = $request["events"][0]["message"]["text"];
            $httpClient = new CurlHTTPClient($lineConfig['bot']['channelToken']);
            $Bot = new LINEBot($httpClient, ['channelSecret' => $lineConfig['bot']['channelSecret']]);
            
            $Events = $Bot->parseEventRequest($jsonString, $_SERVER["HTTP_".HTTPHeader::LINE_SIGNATURE]);
            foreach($Events as $event){
                $user = $this->Users->find('all')->where(['Users.line_user_id' => $request["events"][0]["source"]["userId"]])->first();
                //登録外のユーザは終了
                if(!$user){
                    $SendMessage = new MultiMessageBuilder();
                    $SendMessage->add(new TextMessageBuilder("まだ利用登録が済んでいません。"));
                    $Bot->replyMessage($event->getReplyToken(), $SendMessage);
                    return;
                }
                $tmpData = $this->LogTmps->find('all')
                    ->where([
                        'LogTmps.user_id' => $user->id,
                        'LogTmps.expire_date > ' => FrozenTime::now()
                    ])
                    ->first();
                //sessionの有無を確認
                if($tmpData){
                    switch($tmpData->type){
                        case $LogType['withdraw']['id']:
                            $this->Kakeibo->buildWithdraw($tmpData, $message, $event, $Bot);
                            break;
                        case $LogType['deposit']['id']:
                            $this->Kakeibo->buildDeposit($tmpData, $message, $event, $Bot);
                            break;
                        case $LogType['transfer']['id']:
                            $this->Kakeibo->buildTransfer($tmpData, $message, $event, $Bot);
                            break;
                        case $LogType['check_accounts']['id']:
                            $this->Kakeibo->checkAccount($tmpData, $message, $event, $Bot);
                            break;
                        case $LogType['delete_log']['id']:
                            $this->Kakeibo->deleteLog($tmpData, $message, $event, $Bot);
                            break;
                    }
                }else{
                    switch($message){
                        case "家計簿を確認する":
                            $token = Security::randomString(32);
                            $entity = $this->UserTokens->newEntity([
                                'user_id' => $user->id,
                                'token' => $token,
                                'token_limit' => date("Y-m-d H:i:s",strtotime("+1 day"))
                            ]);
                            $this->UserTokens->save($entity);
                            $SendMessage = new MultiMessageBuilder();
                            $SendMessage->add(new TextMessageBuilder("こちらにアクセスしてください。"));
                            $SendMessage->add(new TextMessageBuilder("https://kakeibo.tokyo/kakeibo/?token=" . $token));
                            $Bot->replyMessage($event->getReplyToken(), $SendMessage);
                            break;
                        case "あ":
                        case "支出":
                        case "支出を記録する":
                            $SendMessage = new MultiMessageBuilder();
                            $SendMessage->add(new TextMessageBuilder("どこでつかった？"));
                            $Bot->replyMessage($event->getReplyToken(), $SendMessage);
                            $entity = $this->LogTmps->newEntity([
                                'user_id' => $user->id,
                                'value' => json_encode([
                                    'user_id' => $user->id,
                                    'place' => null,
                                    'withdraw_id' => null,
                                    'account_id' => null,
                                    'amount' => null,
                                    'payment_method_id' => null,
                                    'fix_flg' => null,
                                    'comment' => ""
                                ], JSON_UNESCAPED_UNICODE),
                                'type' => $LogType['withdraw']['id'],
                                'expire_date' => date("Y-m-d H:i:s",strtotime("+3 minute")),
                            ]);
                            $this->LogTmps->save($entity);
                            break;
                        case "ら":
                        case "収入":
                        case "収入を記録する":
                            $SendMessage = new MultiMessageBuilder();
                            $SendMessage->add(new TextMessageBuilder("いくら貰った？"));
                            $Bot->replyMessage($event->getReplyToken(), $SendMessage);
                            $entity = $this->LogTmps->newEntity([
                                'user_id' => $user->id,
                                'value' => json_encode([
                                    'user_id' => $user->id,
                                    'amount' => null,
                                    'account_id' => null,
                                    'deposit_id' => null,
                                    'fix_flg' => null,
                                    'comment' => ""
                                ], JSON_UNESCAPED_UNICODE),
                                'type' => $LogType['deposit']['id'],
                                'expire_date' => date("Y-m-d H:i:s",strtotime("+3 minute")),
                            ]);
                            $this->LogTmps->save($entity);
                            break;
                        case 'で':
                        case '削除':
                        case 'データの削除':
                            $recentDatas = $this->Kakeibo->getRecentRegistedData($user->id);
                            if(!empty($recentDatas)){
                                $SendMessage = new MultiMessageBuilder();
                                $message = "";
                                $id = 1;
                                foreach($recentDatas as $typeName => $datas){
                                    foreach($datas as $data){
                                        $SendMessage->add(new TextMessageBuilder(
                                            "id:" . $id . 
                                            "\nタイプ:" . $LogType[$typeName]['id'] . 
                                            "\n金額:" . $data->amount));
                                        $id++;
                                    }
                                }
                                $entity = $this->LogTmps->newEntity([
                                    'user_id' => $user->id,
                                    'value' => json_encode([
                                        'id' => null
                                    ], JSON_UNESCAPED_UNICODE),
                                    'type' => $LogType['delete_log']['id'],
                                    'expire_date' => date("Y-m-d H:i:s",strtotime("+3 minute")),
                                ]);
                                $this->LogTmps->save($entity);
                                $SendMessage->add(new TextMessageBuilder("どちらのデータを削除しますか？"));
                                $Bot->replyMessage($event->getReplyToken(), $SendMessage);
                            }else{
                                $SendMessage = new MultiMessageBuilder();
                                $SendMessage->add(new TextMessageBuilder("削除できるデータが存在しません。"));
                                $Bot->replyMessage($event->getReplyToken(), $SendMessage);
                            }
                            break;
                        case 'お金を移す':
                            $SendMessage = new MultiMessageBuilder();
                            $SendMessage->add(new TextMessageBuilder("いくら移した？"));
                            $Bot->replyMessage($event->getReplyToken(), $SendMessage);
                            $entity = $this->LogTmps->newEntity([
                                'user_id' => $user->id,
                                'value' => json_encode([]),
                                'type' => $LogType['transfer']['id'],
                                'expire_date' => date("Y-m-d H:i:s",strtotime("+3 minute")),
                            ]);
                            $this->LogTmps->save($entity);
                            break;
                        case "残高":
                        case "残高を確認する":
                            $this->loadModel('Accounts');
                            $accountModel = $this->Accounts->find('all');
                            $datas = $accountModel->where([
                                'OR' => [
                                    ['Accounts.user_id' => 0],
                                    ['Accounts.user_id' => $user->id]
                                ]
                            ])->toArray();
                            $accounts = [];
                            if(!empty($datas)){
                                foreach($datas as $data){
                                    $accounts[] = $data->name;
                                }
                                $entity = $this->LogTmps->newEntity([
                                    'user_id' => $user->id,
                                    'type' => $LogType['check_accounts']['id'],
                                    'expire_date' => date("Y-m-d H:i:s",strtotime("+3 minute")),
                                ]);
                                $this->LogTmps->save($entity);
                                $SendMessage = new MultiMessageBuilder();
                                $SendMessage->add(new TextMessageBuilder("どの口座の残高を確認しますか？(" . implode(',', $accounts) . ")"));
                                $Bot->replyMessage($event->getReplyToken(), $SendMessage);
                            }else{
                                $SendMessage = new MultiMessageBuilder();
                                $SendMessage->add(new TextMessageBuilder("口座情報が存在しません。"));
                                $Bot->replyMessage($event->getReplyToken(), $SendMessage);
                            }
                            break;
                        case "コマンド一覧":
                        case "help":
                        case "コマンドを確認する":
                        case "コマンド一覧を表示":
                            $SendMessage = new MultiMessageBuilder();
                            $SendMessage->add(new TextMessageBuilder(
                               "「支出を記録する」...支出を記録します。\n「収入を記録する」...収入を記録します。\n「データの削除」...三分前までに登録したデータを選択して削除できます。\n「コマンドを確認する」...この画面を表示します。\n「残高を確認する」...指定した口座の残高を確認します。"));
                            $Bot->replyMessage($event->getReplyToken(), $SendMessage);
                        default:
                            $SendMessage = new MultiMessageBuilder();
                            $SendMessage->add(new TextMessageBuilder("不明なコマンドです。コマンド一覧を確認したい場合は「コマンドを確認する」と話しかけてください。"));
                            $Bot->replyMessage($event->getReplyToken(), $SendMessage);
                    }
                }
            }

        }else{
            throw new SecurityException();
        }

    }
}
