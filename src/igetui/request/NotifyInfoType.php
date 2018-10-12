<?php
/**
 * Created by PhpStorm.
 * User: snail
 * Date: 2018/10/12
 * Time: 下午4:13
 */

namespace GeTui\igetui\request;


use GeTui\protobuf\type\PBEnum;

class NotifyInfoType extends PBEnum
{
    const _payload  = 0;
    const _intent  = 1;
    const _url  = 2;
}
