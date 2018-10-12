<?php
/**
 * Created by PhpStorm.
 * User: snail
 * Date: 2018/10/12
 * Time: 下午4:06
 */

namespace GeTui\igetui;


class SimpleAlertMsg implements ApnMsg
{
    var $alertMsg;

    public function get_alertMsg()
    {
        return $this->alertMsg;
    }
}