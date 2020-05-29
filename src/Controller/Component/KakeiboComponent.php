<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\I18n\FrozenTime;
use Cake\Core\Configure;

use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use \LINE\LINEBot\Constant\HTTPHeader;

/**
 * Kakeibo component
 */
class KakeiboComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];


    public function initialize($config): void 
    {
        $this->controller = $this->_registry->getController();
        
    }
    
    public function flip($array){
        if(empty($array)){
            return $array;
        }else{
            foreach($array as $key => $val){
                $array[$val] = $key;
                unset($array[$key]);
            }
        }
        return $array;
    }

    public function buildWithdraw($tmpData, $message, $event, $bot){
        
        $this->controller->loadModel('MstWithdraws');
        $this->controller->loadModel('MstPaymentMethods');
        $this->controller->loadModel('LogTmps');

        $withdrawConfig = $this->controller->MstWithdraws->find('list')->toArray();
        $paymentMethods = $this->controller->MstPaymentMethods->find('list')->toArray();
        $SendMessage = new MultiMessageBuilder();
        $builder = json_decode($tmpData->value, true);
        //ビルド完了フラグの初期化、ビルド終了時に有効化
        $builder['confirm_flg'] = false;
        //修正するための対話シェル
        if($builder['fix_flg'] == 'true'){
            $eraser = [
                1 => 'place',
                2 => 'withdraw_id',
                3 => 'account_id',
                4 => 'amount',
                5 => 'payment_method_id'
            ];
            if($message == "0"){
                $message = "やり直す";
            }else{
                $builder[$eraser[$message]] = null;
                $builder['fix_flg'] = null;
                $message = "";
                $SendMessage->add(new TextMessageBuilder("該当箇所の入力をやり直して下さい。"));
            }
        }
        $target = array_search(null, $builder, true);
        //メッセージが「やり直す」だったらビルドデータを初期化
        if($message == 'やり直す'){
            $builder = [
                'user_id' => $builder['user_id'],
                'place' => null,
                'withdraw_id' => null,
                'account_id' => null,
                'amount' => null,
                'payment_method_id' => null,
                'fix_flg' => null,
                'comment' => "",
                'confirm_flg' => null
            ];
            $SendMessage->add(new TextMessageBuilder("初期化しました。"));
            $SendMessage->add(new TextMessageBuilder("どこで使った？"));
            $bot->replyMessage($event->getReplyToken(), $SendMessage);
        }else{
            switch($target){
                //場所の登録
                case 'place':
                    if(strlen($message) >= 1){
                        $builder[$target] = $message;
                        if($builder['build_flg']){
                            break;
                        }else{
                            $SendMessage->add(new TextMessageBuilder("何に使った？(" . implode(',', $withdrawConfig) . ")"));
                            $bot->replyMessage($event->getReplyToken(), $SendMessage);
                            
                        }
                    }else{
                        $SendMessage->add(new TextMessageBuilder("どこで使った？"));
                        $bot->replyMessage($event->getReplyToken(), $SendMessage);
                    }
                    break;
                //出金のカテゴリの登録
                case 'withdraw_id':
                    $wdConfig = $this->flip($withdrawConfig);
                    switch($message){
                        case "食費":
                        case "日用品代":
                        case "交通費":
                        case "家賃":
                        case "電気代":
                        case "水道代":
                        case "ガス代":
                        case "交友費":
                        case "その他":
                            $this->controller->loadModel('Accounts');
                            $accountModel = $this->controller->Accounts->find('all');
                            $accountModel->where([
                                'OR' => [
                                    ['Accounts.user_id' => 0],
                                    ['Accounts.user_id' => $builder['user_id']]
                                ]
                            ]);
                            $accounts = $accountModel->toArray();
                            foreach($accounts as $account){
                                $accountNames[] = $account->name;
                            }
                            $builder[$target] = $wdConfig[$message];
                            if($builder['build_flg']){
                                break;
                            }else{
                                $SendMessage->add(new TextMessageBuilder("どの口座からつかった？(" . implode(',', $accountNames) . ")"));
                                $bot->replyMessage($event->getReplyToken(), $SendMessage);
                            }
                            break;
                        default:
                            $SendMessage->add(new TextMessageBuilder("何に使った？(" . implode(',', $withdrawConfig) . ")"));
                            $bot->replyMessage($event->getReplyToken(), $SendMessage);
                            break;
                    }
                    break;
                //どの口座から使用したか登録
                case 'account_id':
                    $this->controller->loadModel('Accounts');
                    $accountModel = $this->controller->Accounts->find('all');
                    $accountModel->where([
                        'OR' => [
                            ['Accounts.user_id' => 0],
                            ['Accounts.user_id' => $builder['user_id']]
                        ],
                        'Accounts.name' => $message
                    ]);
                    $accounts = $accountModel->first();
                    if($accounts->id){
                        $builder[$target] = $accounts->id;
                        if($builder['build_flg']){
                            break;
                        }else{
                            $SendMessage->add(new TextMessageBuilder("いくら使った？"));
                            $bot->replyMessage($event->getReplyToken(), $SendMessage);
                        }
                    }else{
                        $accountModel = $this->controller->Accounts->find('all');
                        $accountModel->where([
                            'OR' => [
                                ['Accounts.user_id' => 0],
                                ['Accounts.user_id' => $builder['user_id']]
                            ]
                        ]);
                        $accounts = $accountModel->toArray();
                        foreach($accounts as $account){
                            $accountNames[] = $account->name;
                        }
                        $SendMessage->add(new TextMessageBuilder("どの口座からつかった？(" . implode(',', $accountNames) . ")"));
                        $bot->replyMessage($event->getReplyToken(), $SendMessage);
                    }
                    break;
                case 'amount':
                    $amount = (int) $message;
                    if($amount > 0){
                        $builder[$target] = $amount;
                        if($builder['build_flg']){
                            break;
                        }else{
                            $SendMessage->add(new TextMessageBuilder("何で支払った？(" . implode(',', $paymentMethods) . ")"));
                            $bot->replyMessage($event->getReplyToken(), $SendMessage);
                        }
                    }else{
                        $SendMessage->add(new TextMessageBuilder("いくら使った？"));
                        $bot->replyMessage($event->getReplyToken(), $SendMessage);
                    }
                    break;
                case 'payment_method_id':
                    $methods = $this->flip($paymentMethods);
                    $this->controller->loadModel('Accounts');
                    $accountModel = $this->controller->Accounts->find('all');
                    //支払方法を特定、その後該当する支払方法の場合口座情報を特定
                    switch($message){
                        case '現金':
                            $builder[$target] = $methods['現金'];
                            $builder['build_flg'] = true;
                            break;
                        case 'クレジットカード':
                        case 'クレカ':
                        case 'クレジット':
                            $builder[$target] = $methods['クレジットカード'];
                            $builder['build_flg'] = true;
                            break;
                        case 'デビットカード':
                        case 'デビット':
                            $builder[$target] = $methods['デビットカード'];
                            $builder['build_flg'] = true;
                            break;
                        default:
                            $build_flg = false;
                            $SendMessage->add(new TextMessageBuilder("何で支払った？(" . implode(',', $paymentMethods) . ")"));
                            $bot->replyMessage($event->getReplyToken(), $SendMessage);
                            break;
                    }
                    break;
                case 'fix_flg':
                    switch($message){
                        case "はい":
                        case "yes":
                        case "y":
                            $builder['confirm_flg'] = true;
                            $builder['fix_flg'] = 0;
                        break;
                        case "いいえ":
                        case "no":
                            //todo:対話型シェルの作成
                            $builder['fix_flg'] = 'true';
                            $SendMessage->add(new TextMessageBuilder("どちらのデータを修正しますか？\n(0:全て,1:場所,2:出金理由,3:口座,4:金額,5:出金方法)"));
                            $bot->replyMessage($event->getReplyToken(), $SendMessage);
                        break;
                        default:
                            $SendMessage->add(new TextMessageBuilder("はい か いいえ で答えて下さい。"));
                            $bot->replyMessage($event->getReplyToken(), $SendMessage);
                        break;
                    }
                    break;
                default:
                    $SendMessage->add(new TextMessageBuilder("内部エラーが発生しました。管理者に連絡してください。"));
                    $this->controller->LogTmps->delete($tmpData);
                    $SendMessage->add(new TextMessageBuilder("該当データの削除を行いました。もう一度最初からやり直してください。"));
                    $bot->replyMessage($event->getReplyToken(), $SendMessage);
                    $SendMessage = new MultiMessageBuilder();
                    $SendMessage->add(new TextMessageBuilder("なんかおかしいぞ確認しろや"));
                    $bot->pushMessage('U00c4a2b7f6578ff5a99d96a2d4e6122b', $SendMessage);
                    return;
                    break;
            }
        }
        //最後まで入力したらconfirm
        if($builder['build_flg'] && !$builder['confirm_flg']){
            $this->controller->loadModel('Accounts');
            $accountEntity = $this->controller->Accounts->get($builder['account_id']);
            $SendMessage->add(new TextMessageBuilder(
                "使った場所: " . $builder['place'] . 
                "\n出金理由: " . $withdrawConfig[$builder['withdraw_id']] . 
                "\n出金する口座: " . $accountEntity->name . 
                "\n金額: " . $builder['amount'] . 
                "\n出金方法: " . $paymentMethods[$builder['payment_method_id']]
               ));
            $SendMessage->add(new TextMessageBuilder("この内容で記録しますか？（はい、いいえ）"));
            $bot->replyMessage($event->getReplyToken(), $SendMessage);
        }
        $tmpData->expire_date = date("Y-m-d H:i:s",strtotime("+3 minute"));
        $tmpData->value = json_encode($builder, JSON_UNESCAPED_UNICODE);
        //最後まで到達していなければ一時保存
        if(!$builder['confirm_flg']){
            $this->controller->LogTmps->save($tmpData);
            return false;
        }else{
            //dbに保存するため存在しない物は削除
            unset($builder['confirm_flg'], $builder['build_flg']);
            if($this->withdraw($builder)){
                $SendMessage = new MultiMessageBuilder();
                $SendMessage->add(new TextMessageBuilder("登録しました！"));
                $bot->replyMessage($event->getReplyToken(), $SendMessage);
                $this->controller->LogTmps->delete($tmpData);
            }
            return true;
        }
    }

    public function buildDeposit($tmpData, $message, $event, $bot){
        $this->controller->loadModel('MstDeposits');
        $this->controller->loadModel('LogTmps');

        $depositConfig = $this->controller->MstDeposits->find('list')->toArray();
        $SendMessage = new MultiMessageBuilder();
        $builder = json_decode($tmpData->value, true);
        //ビルド完了フラグの初期化、ビルド終了時に有効化
        $builder['confirm_flg'] = false;
        //修正するための対話シェル
        if($builder['fix_flg'] == 'true'){
            $eraser = [
                1 => 'amount',
                2 => 'account_id',
                3 => 'deposit_id',
            ];
            if($message == "0"){
                $message = "やり直す";
            }else{
                $builder[$eraser[$message]] = null;
                $builder['fix_flg'] = null;
                $message = "";
                $SendMessage->add(new TextMessageBuilder("該当箇所の入力をやり直して下さい。"));
            }
        }
        $target = array_search(null, $builder, true);
        //メッセージが「やり直す」だったらビルドデータを初期化
        if($message == 'やり直す'){
            $builder = [
                'user_id' => $builder['user_id'],
                'amount' => null,
                'account_id' => null,
                'deposit_id' => null,
                'fix_flg' => null,
                'comment' => "",
                'confirm_flg' => null
            ];
            $SendMessage->add(new TextMessageBuilder("初期化しました。"));
            $SendMessage->add(new TextMessageBuilder("いくら貰った？"));
            $bot->replyMessage($event->getReplyToken(), $SendMessage);
        }else{
            switch($target){
                case 'amount':
                    $message = str_replace('円', '', str_replace('¥', '',$message));
                    $amount = (int) $message;
                    if($amount > 0){
                        $builder[$target] = $amount;
                        $this->controller->loadModel('Accounts');
                        $accountModel = $this->controller->Accounts->find('all');
                        $accountModel->where([
                            'OR' => [
                                ['Accounts.user_id' => 0],
                                ['Accounts.user_id' => $builder['user_id']]
                            ]

                        ]);
                        $accounts = $accountModel->toArray();
                        foreach($accounts as $account){
                            $accountNames[] = $account->name;
                        }
                        if($builder['build_flg']){
                            break;
                        }else{
                            $SendMessage->add(new TextMessageBuilder("どの口座に入れた？(" . implode(',', $accountNames) . ")"));
                            $bot->replyMessage($event->getReplyToken(), $SendMessage);
                        }
                    }else{
                        $SendMessage->add(new TextMessageBuilder("いくら貰った？"));
                        $bot->replyMessage($event->getReplyToken(), $SendMessage);
                    }
                    break;
                case 'account_id':
                    $this->controller->loadModel('Accounts');
                    $accountModel = $this->controller->Accounts->find('all');
                    $accountModel->where([
                        'OR' => [
                            ['Accounts.user_id' => 0],
                            ['Accounts.user_id' => $builder['user_id']]
                        ],
                        'Accounts.name' => $message
                    ]);
                    $accounts = $accountModel->first();
                    if($accounts->id){
                        $builder[$target] = $accounts->id;
                        if($builder['build_flg']){
                            break;
                        }else{
                            $SendMessage->add(new TextMessageBuilder("なんで入金があった？(" . implode(',', $depositConfig) . ")"));
                            $bot->replyMessage($event->getReplyToken(), $SendMessage);
                        }
                    }else{
                        $accountModel = $this->controller->Accounts->find('all');
                        $accountModel->where([
                            'OR' => [
                                ['Accounts.user_id' => 0],
                                ['Accounts.user_id' => $builder['user_id']]
                            ]

                        ]);
                        $accounts = $accountModel->toArray();
                        foreach($accounts as $account){
                            $accountNames[] = $account->name;
                        }
                        $SendMessage->add(new TextMessageBuilder("どの口座に入れた？(" . implode(',', $accountNames) . ")"));
                        $bot->replyMessage($event->getReplyToken(), $SendMessage);
                    }
                    break;
                case 'deposit_id':
                    $this->controller->loadModel('Accounts');
                    $accountEntity = $this->controller->Accounts->get($builder['account_id']);
                    $dpConfig = $this->flip($depositConfig);
                    switch($message){
                        case "給料":
                        case "特別収入":
                        case "経費等（返還）":
                            $builder[$target] = $dpConfig[$message];
                            $builder['build_flg'] = true;
                            break;
                        default:
                            $SendMessage->add(new TextMessageBuilder("なんで入金があった？(" . implode(',', $depositConfig) . ")"));
                            $bot->replyMessage($event->getReplyToken(), $SendMessage);
                            break;
                    }
                    break;
                case 'fix_flg':
                    switch($message){
                        case "はい":
                        case "yes":
                        case "y":
                            $builder['confirm_flg'] = true;
                            $builder['fix_flg'] = 0;
                        break;
                        case "いいえ":
                        case "no":
                            //todo:対話型シェルの作成
                            $builder['fix_flg'] = 'true';
                            $SendMessage->add(new TextMessageBuilder("どちらのデータを修正しますか？\n(0:全て,1:金額,2:口座,3:入金理由)"));
                            $bot->replyMessage($event->getReplyToken(), $SendMessage);
                        break;
                        default:
                            $builder = [
                                'user_id' => $builder['user_id'],
                                'amount' => null,
                                'account_id' => null,
                                'deposit_id' => null,
                                'fix_flg' => null,
                                'comment' => "",
                                'confirm_flg' => null
                            ];
                            $SendMessage->add(new TextMessageBuilder("初期化しました。"));
                            $SendMessage->add(new TextMessageBuilder("いくら貰った？"));
                            $bot->replyMessage($event->getReplyToken(), $SendMessage);
                        break;
                    }
                    
                    break;
                default:
                    $SendMessage->add(new TextMessageBuilder("内部エラーが発生しました。管理者に連絡してください。"));
                    $this->controller->LogTmps->delete($tmpData);
                    $SendMessage->add(new TextMessageBuilder("該当データの削除を行いました。もう一度最初からやり直してください。"));
                    $bot->replyMessage($event->getReplyToken(), $SendMessage);
                    $SendMessage = new MultiMessageBuilder();
                    $SendMessage->add(new TextMessageBuilder("なんかおかしいぞ確認しろや"));
                    $bot->pushMessage('U00c4a2b7f6578ff5a99d96a2d4e6122b', $SendMessage);
                    return;
                    break;
            }
        }
        if($builder['build_flg'] && !$builder['confirm_flg']){
            $SendMessage->add(new TextMessageBuilder("金額: " . $builder['amount'] . 
            "\n入金する口座: " . $accountEntity->name . 
            "\n入金理由: " . $message));
            $SendMessage->add(new TextMessageBuilder("この内容で記録しますか？（はい、いいえ）"));
            $bot->replyMessage($event->getReplyToken(), $SendMessage);
        }
        $builder['expire_date'] = date("Y-m-d H:i:s",strtotime("+3 minute"));
        $tmpData->value = json_encode($builder, JSON_UNESCAPED_UNICODE);
        //最後まで到達していなければ一時保存
        if(!$builder['confirm_flg']){
            $this->controller->LogTmps->save($tmpData);
            return false;
        }else{
            //dbに保存するため存在しない物は削除
            unset($builder['confirm_flg'], $builder['confirm_flg']);
            if($this->deposit($builder)){
                $SendMessage = new MultiMessageBuilder();
                $SendMessage->add(new TextMessageBuilder("登録しました！"));
                $bot->replyMessage($event->getReplyToken(), $SendMessage);
                $this->controller->LogTmps->delete($tmpData);
            }
            return true;
        }
    }
    
    
    public function buildTransfer($tmpData, $message, $event, $bot){
        $this->controller->loadModel('Accounts');
        $this->controller->loadModel('LogTmps');

        $SendMessage = new MultiMessageBuilder();
        $builder = json_decode($tmpData->value, true);
        //ビルド完了フラグの初期化、ビルド終了時に有効化
        $builder['build_flg'] = false;
        $target = array_search(null, $builder, true);
        //メッセージが「やり直す」だったらビルドデータを初期化
        if($message == 'やり直す'){
            $builder = [
                'user_id' => $builder['user_id'],
                'amount' => null,
                'before_id' => null,
                'after_id' => null
            ];
            
            $SendMessage->add(new TextMessageBuilder("初期化しました。"));
            $SendMessage->add(new TextMessageBuilder("いくら移した？"));
            $bot->replyMessage($event->getReplyToken(), $SendMessage);
        }else{
            switch($target){
                case 'amount':
                    $message = str_replace('円', '', str_replace('¥', '',$message));
                    $amount = (int) $message;
                    if($amount > 0){
                        $builder[$target] = $amount;
                        $this->controller->loadModel('Accounts');
                        $accountModel = $this->controller->Accounts->find('all');
                        $accountModel->where([
                            'OR' => [
                                ['Accounts.user_id' => 0],
                                ['Accounts.user_id' => $builder['user_id']]
                            ]
                        ]);
                        $accounts = $accountModel->toArray();
                        foreach($accounts as $account){
                            $accountNames[] = $account->name;
                        }
                        $SendMessage->add(new TextMessageBuilder("どの口座から移した？(" . implode(',', $accountNames) . ")"));
                    }else{
                        $SendMessage->add(new TextMessageBuilder("いくら貰った？"));
                    }
                    break;
                case 'before_id':
                    $this->controller->loadModel('Accounts');
                    $accountModel = $this->controller->Accounts->find('all');
                    $accountModel->where([
                        'OR' => [
                            ['Accounts.user_id' => 0],
                            ['Accounts.user_id' => $builder['user_id']]
                        ],
                        'Accounts.name' => $message
                    ]);
                    $accounts = $accountModel->first();
                    if($accounts->id){
                        $builder[$target] = $accounts->id;
                        $accountModel = $this->controller->Accounts->find('all');
                        $accounts = $accountModel->where([
                            'Accounts.id !=' => $builder['before_id']
                        ])->toArray();
                        foreach($accounts as $account){
                            $accountNames[] = $account->name;
                        }
                        $SendMessage->add(new TextMessageBuilder("どの口座に移した？(" . implode(',', $accountNames) . ")"));
                    }else{
                        $accountModel = $this->controller->Accounts->find('all');
                        $accountModel->where([
                            'OR' => [
                                ['Accounts.user_id' => 0],
                                ['Accounts.user_id' => $builder['user_id']]
                            ]
                            
                        ]);
                        $accounts = $accountModel->toArray();
                        foreach($accounts as $account){
                            $accountNames[] = $account->name;
                        }
                        $SendMessage->add(new TextMessageBuilder("どの口座から移した？(" . implode(',', $accountNames) . ")"));
                    }
                    break;
                case 'after_id':
                    $this->controller->loadModel('Accounts');
                    $accountModel = $this->controller->Accounts->find('all');
                    $accountModel->where([
                        'OR' => [
                            ['Accounts.user_id' => 0],
                            ['Accounts.user_id' => $builder['user_id']]
                        ],
                        'Accounts.name' => $message
                    ]);
                    $accounts = $accountModel->first();
                    if($accounts->id){
                        $builder[$target] = $accounts->id;
                        $builder['build_flg'] = true;
                    }else{
                        $accountModel = $this->controller->Accounts->find('all');
                        $accounts = $accountModel->where([
                            'Accounts.id !=' => $builder['before_id'],
                            'OR' => [
                                ['Accounts.user_id' => 0],
                                ['Accounts.user_id' => $builder['user_id']]
                            ]
                        ])->toArray();
                        foreach($accounts as $account){
                            $accountNames[] = $account->name;
                        }
                        $SendMessage->add(new TextMessageBuilder("どの口座に移した？(" . implode(',', $accountNames) . ")"));
                    }
                    break;
                default:
                    $SendMessage->add(new TextMessageBuilder("内部エラーが発生しました。管理者に連絡してください。"));
                    $this->controller->LogTmps->delete($tmpData);
                    $SendMessage->add(new TextMessageBuilder("該当データの削除を行いました。もう一度最初からやり直してください。"));
                    $bot->replyMessage($event->getReplyToken(), $SendMessage);
                    $SendMessage = new MultiMessageBuilder();
                    $SendMessage->add(new TextMessageBuilder("なんかおかしいぞ確認しろや"));
                    $bot->pushMessage('U00c4a2b7f6578ff5a99d96a2d4e6122b', $SendMessage);
                    return;
                    break;
            }
        }
        $builder['expire_date'] = date("Y-m-d H:i:s",strtotime("+3 minute"));
        $tmpData->value = json_encode($builder, JSON_UNESCAPED_UNICODE);
        //最後まで到達していなければ一時保存
        if(!$builder['build_flg']){
            $bot->replyMessage($event->getReplyToken(), $SendMessage);
            $this->controller->LogTmps->save($tmpData);
            return false;
        }else{
            //dbに保存するため存在しない物は削除
            unset($builder['confirm_flg']);
            if($this->transfer($builder)){
                $SendMessage = new MultiMessageBuilder();
                $SendMessage->add(new TextMessageBuilder("登録しました💖"));
                $bot->replyMessage($event->getReplyToken(), $SendMessage);
                $this->controller->LogTmps->delete($tmpData);
            }
            return true;
        }
    }
    
    
    public function withdraw($withdrawData)
    {
        $this->controller->loadModel('LogWithdraws');
        $this->controller->loadModel('Accounts');
        $this->controller->loadModel('MstPaymentMethods');
        $paymentMethods = $this->flip($this->controller->MstPaymentMethods->find('list')->toArray());

        //クレカ払い以外なら該当口座から額を引く
        if($withdrawData['payment_method_id'] !== $paymentMethods['クレジットカード']){
            $amount = $withdrawData['amount'];
            $accountId = $withdrawData['account_id'];
            $accountEntity = $this->controller->Accounts->get($accountId);
            $accountEntity->amount = $accountEntity->amount - $amount;
            $result['account'] = $this->controller->Accounts->save($accountEntity);
        }
        $logWithdraw = $this->controller->LogWithdraws;
        $entity = $logWithdraw->patchEntity($logWithdraw->newEmptyEntity(), $withdrawData);
        $result['log'] = $logWithdraw->save($entity);
        return $result['account'] && $result['log'];
    }

    public function deposit($depositData)
    {
        $this->controller->loadModel('LogDeposits');
        $this->controller->loadModel('Accounts');

        //該当口座に額を足す。
        $amount = $depositData['amount'];
        $accountId = $depositData['account_id'];
        $accountEntity = $this->controller->Accounts->get($accountId);
        $accountEntity->amount = $accountEntity->amount + $amount;
        $result['account'] = $this->controller->Accounts->save($accountEntity);
        $logDeposit = $this->controller->LogDeposits;
        $entity = $logDeposit->newEntity($depositData);
        $result['log'] = $logDeposit->save($entity);
        return $result['account'] && $result['log'];
    }
    
    public function transfer($transferData){
        
        $this->controller->loadModel('MstDeposits');
        $this->controller->loadModel('MstWithdraws');
        $this->controller->loadModel('MstPaymentMethods');
        
        $withdrawConfig = $this->flip($this->controller->MstWithdraws->find('list')->toArray());
        $paymentMethods = $this->flip($this->controller->MstPaymentMethods->find('list')->toArray());
        $depositConfig = $this->flip($this->controller->MstDeposits->find('list')->toArray());
        $this->withdraw([
            'user_id' => $transferData['user_id'],
            'place' => '銀行',
            'withdraw_id' => $withdrawConfig['口座振替'],
            'account_id' => $transferData['before_id'],
            'amount' => $transferData['amount'],
            'payment_method_id' => $paymentMethods['現金'],
            'fix_flg' => 0,
            'comment' => "口座振替の自動出金"
        ]);
        $this->deposit([
            'user_id' => $transferData['user_id'],
            'amount' => $transferData['amount'],
            'account_id' => $transferData['after_id'],
            'deposit_id' => $depositConfig['口座振替'],
            'fix_flg' => 0,
            'comment' => "口座振替の自動入金"
        ]);
        return true;
    }
    
    public function checkAccount($tmpData, $message, $event, $bot){
        
        $this->controller->loadModel('Accounts');
        $accountsModel = $this->controller->Accounts;
        $account = $accountsModel->find('all')->where([
            'Accounts.name' => $message
        ])->first();
        if($account){
            if($account->name == "生活"){
                $until15 = (int) (strtotime(date('Y-m-15', strtotime('+1 month'))) - time()) / 86400;
                $moneyPerDay = (int) ($account->amount / $until15);
            }
            $SendMessage = new MultiMessageBuilder();
            $SendMessage->add(new TextMessageBuilder($message . "の口座残高は" . $account->amount . "円です。"));
            $SendMessage->add(new TextMessageBuilder('給料日まで一日当たり' . $moneyPerDay . '円です。'));
            $bot->replyMessage($event->getReplyToken(), $SendMessage);
            $this->controller->LogTmps->delete($tmpData);
        }else{
            $accountModel = $this->Accounts->find('all');
            $datas = $accountModel->where([
                'OR' => [
                    ['Accounts.user_id' => 0],
                    ['Accounts.user_id' => $tmpData->user_id]
                ]
            ])->toArray();
            if(!empty($datas)){
                foreach($datas as $data){
                    $accounts[] = $data->name;
                }
            }
            $SendMessage = new MultiMessageBuilder();
            $SendMessage->add(new TextMessageBuilder("指定した口座が見つかりません。存在する口座を選択してください。"));
            $SendMessage->add(new TextMessageBuilder("(" . implode(',', $accounts) . ")"));
            $bot->replyMessage($event->getReplyToken(), $SendMessage);
        }
        
    }
    
    public function getRecentRegistedData($userId){
        
        $data = [];
        
        $this->controller->loadModel('LogWithdraws');
        $this->controller->loadModel('LogDeposits');
        
        $depositModel = $this->controller->LogDeposits;
        $withdrawModel = $this->controller->LogWithdraws;
        
        $depositData = $depositModel->find('all')->where([
            'LogDeposits.user_id' => $userId,
            'LogDeposits.created >' => date("Y-m-d H:i:s",strtotime("-3 day"))
        ])->toArray();
        
        $withdrawData = $withdrawModel->find('all')->where([
            'LogWithdraws.user_id' => $userId,
            'LogWithdraws.created >' => date("Y-m-d H:i:s",strtotime("-3 day"))
        ])->toArray();
        
        if($depositData){
            $data['deposit'] = $depositData;
        }
        
        if($withdrawData){
            $data['withdraw'] = $withdrawData;
        }
        
        return $data;
        
    }
    
    public function deleteLog($tmpData, $message, $event, $bot){
        
        $this->controller->loadModel('LogWithdraws');
        $this->controller->loadModel('LogDeposits');
        $LogType = Configure::read("log_types");
        
        $SendMessage = new MultiMessageBuilder();
        $recentLogData = $this->getRecentRegistedData($tmpData->user_id);
        $targetLogs = array_merge($recentLogData['withdraw'], $recentLogData['deposit']);
        $target = $targetLogs[(int) $message - 1];
        if($target){
            if($target->withdraw_id){
                $this->controller->LogWithdraws->delete($target);
            }else{
                $this->controller->LogDeposits->delete($target);
            }
            $this->controller->LogTmps->delete($tmpData);
            $SendMessage->add(new TextMessageBuilder("該当データを削除しました。"));
            $bot->replyMessage($event->getReplyToken(), $SendMessage);
        }else{
            $id = 1;
            foreach($recentLogData as $typeName => $datas){
                foreach($datas as $data){
                    $SendMessage->add(new TextMessageBuilder(
                        "id:" . $id . 
                        "\nタイプ:" . $LogType[$typeName]['id'] . 
                        "\n金額:" . $data->amount));
                    $id++;
                }
            }
            $SendMessage->add(new TextMessageBuilder("指定したデータが存在しません。"));
            $SendMessage->add(new TextMessageBuilder("どちらのデータを削除しますか？"));
            $bot->replyMessage($event->getReplyToken(), $SendMessage);
        }
    }
    
    
}