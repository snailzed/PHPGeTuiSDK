<?php
/**
 * Created by PhpStorm.
 * User: snail
 * Date: 2018/10/12
 * Time: 下午4:19
 */

namespace GeTui\igetui\request;


use GeTui\protobuf\PBMessage;

class PushMMPSingleMessage extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "MMPMessage";
        $this->values["2"] = "";
        $this->fields["3"] = "Target";
        $this->values["3"] = "";
        $this->fields["4"] = "PBString";
        $this->values["4"] = "";
    }
    function seqId()
    {
        return $this->_get_value("1");
    }
    function set_seqId($value)
    {
        return $this->_set_value("1", $value);
    }
    function message()
    {
        return $this->_get_value("2");
    }
    function set_message($value)
    {
        return $this->_set_value("2", $value);
    }
    function target()
    {
        return $this->_get_value("3");
    }
    function set_target($value)
    {
        return $this->_set_value("3", $value);
    }
    function requestId()
    {
        return $this->_get_value("4");
    }
    function set_requestId($value)
    {
        return $this->_set_value("4", $value);
    }
}
