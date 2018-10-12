<?php
/**
 * Created by PhpStorm.
 * User: snail
 * Date: 2018/10/12
 * Time: 下午4:22
 */

namespace GeTui\igetui\request;


use GeTui\protobuf\type\PBEnum;

class InnerFiledType extends PBEnum
{
    const str  = 0;
    const int32  = 1;
    const int64  = 2;
    const floa  = 3;
    const doub  = 4;
    const bool  = 5;
}
