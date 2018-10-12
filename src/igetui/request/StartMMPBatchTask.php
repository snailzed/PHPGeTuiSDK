<?php
/**
 * Created by PhpStorm.
 * User: snail
 * Date: 2018/10/12
 * Time: 下午4:18
 */

namespace GeTui\igetui\request;


use GeTui\protobuf\PBMessage;
use GeTui\protobuf\type\PBInt;
use GeTui\protobuf\type\PBString;

class StartMMPBatchTask extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;

    public function __construct($reader = null)
    {
        parent::__construct($reader);
        $this->fields["1"] = MMPMessage::class;
        $this->values["1"] = "";
        $this->fields["2"] = PBInt::class;
        $this->values["2"] = "";
        $this->fields["3"] = PBString::class;
        $this->values["3"] = "";
        $this->fields["4"] = PBString::class;
        $this->values["4"] = "";
    }

    function message()
    {
        return $this->_get_value("1");
    }

    function set_message($value)
    {
        return $this->_set_value("1", $value);
    }

    function expire()
    {
        return $this->_get_value("2");
    }

    function set_expire($value)
    {
        return $this->_set_value("2", $value);
    }

    function seqId()
    {
        return $this->_get_value("3");
    }

    function set_seqId($value)
    {
        return $this->_set_value("3", $value);
    }

    function taskGroupName()
    {
        return $this->_get_value("4");
    }

    function set_taskGroupName($value)
    {
        return $this->_set_value("4", $value);
    }
}
