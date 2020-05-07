<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Exception\SecurityException;
use Cake\Http\Exception\NotFoundException;
use Cake\Log\Log;
use Cake\Core\Configure;

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
    public function webhook(){
        $jsonString = file_get_contents('php://input');
        if(empty($jsonString)){
            throw new NotFoundException();
        }
        $request = json_decode($jsonString, true);
        $config = Configure::read("line_settings");
        //リクエストのシグネチャを確認
        if( base64_encode(hash_hmac('sha256', $jsonString, $config['bot']['channelSecret'], true))
            == $_SERVER["HTTP_X_LINE_SIGNATURE"]
        ){
            // {
            //     "events": [
            //         {
            //             "type": "message",
            //             "replyToken": "7cae33aed8f14ac4ada5a477c4b8e419",
            //             "source": {
            //                 "userId": "U00c4a2b7f6578ff5a99d96a2d4e6122b",
            //                 "type": "user"
            //             },
            //             "timestamp": 1588703556987,
            //             "mode": "active",
            //             "message": {
            //                 "type": "text",
            //                 "id": "11912046892247",
            //                 "text": "家計簿を確認する"
            //             }
            //         }
            //     ],
            //     "destination": "U69af90a5dda0a544da6e83851e5ab9e9"
            // }
            // {
            //     "userId": "U00c4a2b7f6578ff5a99d96a2d4e6122b",
            //     "displayName": "岩本大樹",
            //     "pictureUrl": "https://profile.line-scdn.net/0hfYw6qUxSOXZKTxPYDYtGIXYKNxs9YT8-MnsjQGlJZ0JhfS4mJil1Em9IYRVgeXp1cS8kEGodZkRn",
            //     "statusMessage": "日本語がダメならソースコードで語れ",
            //     "language": "ja"
            // }
            $message = $request["events"][0]["message"]["text"];
            $httpClient = new CurlHTTPClient($config['bot']['channelToken']);
            $Bot = new LINEBot($httpClient, ['channelSecret' => $config['bot']['channelSecret']]);
            $signature = $_SERVER["HTTP_".HTTPHeader::LINE_SIGNATURE]; 
            $Events = $Bot->parseEventRequest($jsonString, $signature);
            foreach($Events as $event){
                //$response = $bot->getRoomMemberProfile(<roomId>, <userId>);
                $profile = $Bot->getProfile($request["events"][0]["source"]["userId"]);
                $SendMessage = new MultiMessageBuilder();
                $TextMessageBuilder = new TextMessageBuilder("よろぽん！");
                $SendMessage->add($TextMessageBuilder);
                $Bot->replyMessage($event->getReplyToken(), $SendMessage);
            }
            // switch($message){
            //     case "家計簿を確認する":
            //     break;
            // }
        }else{
            throw new SecurityException();
        }
        return true;

    }
}
