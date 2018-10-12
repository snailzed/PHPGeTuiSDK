<?php
/**
 * Created by PhpStorm.
 * User: snail
 * Date: 2018/10/12
 * Time: 下午4:12
 */

namespace GeTui\igetui\request;


use GeTui\protobuf\type\PBEnum;

class PushResultEPushResult extends PBEnum
{
    const successed_online  = 0;
    const successed_offline  = 1;
    const successed_ignore  = 2;
    const failed  = 3;
    const busy  = 4;
    const success_startBatch  = 5;
    const success_endBatch  = 6;
    const successed_async  = 7;
}
