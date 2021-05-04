<?php
namespace appsc\helpers;

class UnitHelper{

   /** 
    * TeamLiquid 网站上关于该单位的介绍链接
    * 
    * @return string 
    */ 
    public static function liquidUrl($name){ 
        return 'https://liquipedia.net/starcraft/' . $name; 
    } 
}

?>