<?php
/**
 * Created by PhpStorm.
 * User: snail
 * Date: 2018/10/12
 * Time: 下午4:08
 */

namespace GeTui\igetui\request;


use GeTui\protobuf\type\PBEnum;

class CmdID extends PBEnum
{
    const GTHEARDBT  = 0;
    const GTAUTH  = 1;
    const GTAUTH_RESULT  = 2;
    const REQSERVHOST  = 3;
    const REQSERVHOSTRESULT  = 4;
    const PUSHRESULT  = 5;
    const PUSHOSSINGLEMESSAGE  = 6;
    const PUSHMMPSINGLEMESSAGE  = 7;
    const STARTMMPBATCHTASK  = 8;
    const STARTOSBATCHTASK  = 9;
    const PUSHLISTMESSAGE  = 10;
    const ENDBATCHTASK  = 11;
    const PUSHMMPAPPMESSAGE  = 12;
    const SERVERNOTIFY  = 13;
    const PUSHLISTRESULT  = 14;
    const SERVERNOTIFYRESULT  = 15;
    const STOPBATCHTASK  = 16;
    const STOPBATCHTASKRESULT  = 17;
    const PUSHMMPSINGLEBATCH  = 18;
}