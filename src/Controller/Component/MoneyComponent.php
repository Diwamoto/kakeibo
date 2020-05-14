<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * Money component
 */
class MoneyComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public function toKansuuji($money){
        
        $tmp = null;

        $builder = '';

        $units = ['万', '億', '兆', '京'];

        $parts = ['十', '百', '千'];

        $kansuuji = ['〇', '一', '二', '三', '四', '五', '六', '七', '八', '九'];

        //区切り文字の削除
        $money = str_replace(',','',$money);
        //反転して4文字毎に分ける
        $moneys = str_split(strrev($money),4);
        //必要な単位の量
        $unit_num = count($moneys) - 1;
        //それぞれの要素を元に戻す
        foreach($moneys as $key => $money){
            $moneys[$key] = strrev($money);
        }
        
        foreach($moneys as $money){
            //一文字ずつ処理するために配列にする。
            $numbers = str_split($money);
            $length = count($numbers);
            for($i = $length; $i > $length - 4; $i--){
                if(){
                    
                }
            }

        }
        return $builder;

    }
    
    public function toSuuji($moneyString){

        $tmp = null;

        $builder = 0;

        $unit = ['万', '億', '兆', '京'];

        $kansuuji = ['零' => 0, '〇' => 0, '一' => 1, '二' => 2, '三' => 3, '四' => 4, '五' => 5, '六' => 6, '七' => 7, '八' => 8, '九' => 9];

        //'円'を取り除く
        if(strpos($moneyString,'円') !== false){
            $moneyString = str_replace('円', '', $moneyString);
        }
        //処理するため文字を分割
        $strings = array_slice(preg_split("//u", $moneyString), 1, -1);
        foreach($strings as $str){
            //単位は飛ばす
            if(in_array($str, $unit)){
                $builder *= 1000;
                continue;
            }else{
                switch($str){
                    case '十':
                        if($tmp){
                            $builder += $tmp * 10;
                        }
                        break;
                    case '百':
                        if($tmp){
                            $builder += $tmp * 100;
                        }
                        break;
                    case '千':
                        if($tmp){
                            $builder += $tmp * 1000;
                        }
                        break;
                    default:
                        $tmp = $kansuuji[$str];
                        break;
                }
            }
        }
        //最後の一文字
        $builder += $tmp;
        return $builder;
    }
}
