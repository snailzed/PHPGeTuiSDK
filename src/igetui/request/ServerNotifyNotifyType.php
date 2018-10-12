<?php
/**
 * Created by PhpStorm.
 * User: snail
 * Date: 2018/10/12
 * Time: 下午4:15
 */

namespace GeTui\igetui\request;


use GeTui\protobuf\type\PBEnum;

class ServerNotifyNotifyType extends PBEnum
{
    const normal  = 0;
    const serverListChanged  = 1;
    const exception  = 2;
}
