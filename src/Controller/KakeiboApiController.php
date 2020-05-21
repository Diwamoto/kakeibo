<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Exception\SecurityException;
use Cake\Http\Exception\NotFoundException;
use Cake\Log\Log;
use Cake\Core\Configure;
use Cake\I18n\FrozenTime;

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
        $this->loadComponent('Kakeibo');
    }

    public function webhook(){
        $this->loadModel('Users');
        $this->loadModel('LogTmps');
        
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
                $user = $this->Users->find('all')->where(['Users.line_user_id' => $request["events"][0]["source"]["userId"]])->first()->toArray();
                //登録外のユーザは終了
                if(!$user){
                    $SendMessage = new MultiMessageBuilder();
                    $SendMessage->add(new TextMessageBuilder("まだ利用登録が済んでいません。"));
                    $Bot->replyMessage($event->getReplyToken(), $SendMessage);
                    return;
                }
                $tmpData = $this->LogTmps->find('all')
                    ->where([
                        'LogTmps.user_id' => $user['id'],
                        'LogTmps.expire_date > ' => FrozenTime::now()
                    ])
                    ->first();
                //sessionの有無を確認
                if($tmpData){
                    switch($tmpData->type){
                        case $LogType['withdraw']:
                            $this->Kakeibo->buildWithdraw($tmpData, $message, $event, $Bot);
                            break;
                        case $LogType['deposit']:
                            $this->Kakeibo->buildDeposit($tmpData, $message, $event, $Bot);
                            break;
                        case $LogType['transfer'];
                            $this->Kakeibo->buildTransfer($tmpData, $message, $event, $Bot);
                            break;
                    }
                }else{
                    switch($message){
                        case "あ":
                        case "支出":
                        case "支出を記録する":
                            $SendMessage = new MultiMessageBuilder();
                            $SendMessage->add(new TextMessageBuilder("どこでつかった？"));
                            $Bot->replyMessage($event->getReplyToken(), $SendMessage);
                            $entity = $this->LogTmps->newEntity([
                                'user_id' => $user['id'],
                                'value' => json_encode([
                                    'user_id' => $user['id'],
                                    'place' => null,
                                    'withdraw_id' => null,
                                    'account_id' => null,
                                    'amount' => null,
                                    'payment_method_id' => null,
                                    'fix_flg' => null,
                                    'comment' => null
                                ], JSON_UNESCAPED_UNICODE),
                                'type' => $LogType['withdraw'],
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
                                'user_id' => $user['id'],
                                'value' => json_encode([
                                    'user_id' => $user['id'],
                                    'amount' => null,
                                    'account_id' => null,
                                    'deposit_id' => null,
                                    'fix_flg' => null,
                                    'comment' => null
                                ], JSON_UNESCAPED_UNICODE),
                                'type' => $LogType['deposit'],
                                'expire_date' => date("Y-m-d H:i:s",strtotime("+3 minute")),
                            ]);
                            $this->LogTmps->save($entity);
                            break;
                        case 'で':
                        case 'データの削除':
                            $SendMessage = new MultiMessageBuilder();
                            $SendMessage->add(new TextMessageBuilder("どちらのデータですか？（支出、収入、振替）"));
                            $Bot->replyMessage($event->getReplyToken(), $SendMessage);
                            break;
                        case 'お金を移す':
                            $SendMessage = new MultiMessageBuilder();
                            $SendMessage->add(new TextMessageBuilder("いくら移した？"));
                            $Bot->replyMessage($event->getReplyToken(), $SendMessage);
                            $entity = $this->LogTmps->newEntity([
                                'user_id' => $user['id'],
                                'value' => json_encode([
                                    'user_id' => $user['id'],
                                    'amount' => null,
                                    'before_id' => null,
                                    'after_id' => null
                                ], JSON_UNESCAPED_UNICODE),
                                'type' => $LogType['transfer'],
                                'expire_date' => date("Y-m-d H:i:s",strtotime("+3 minute")),
                            ]);
                            $this->LogTmps->save($entity);
                            break;
                        default:
                            $SendMessage = new MultiMessageBuilder();
                            $SendMessage->add(new TextMessageBuilder("不明なコマンドです。「支出を記録する」「収入を記録する」等、話しかけてください。"));
                            $Bot->replyMessage($event->getReplyToken(), $SendMessage);
                    }
                }
            }

        }else{
            throw new SecurityException();
        }

    }
}
