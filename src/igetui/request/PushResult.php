<?php
/**
 * Created by PhpStorm.
 * User: snail
 * Date: 2018/10/12
 * Time: 下午4:12
 */

namespace GeTui\igetui\request;


use GeTui\protobuf\PBMessage;

class PushResult extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PushResult_EPushResult";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
        $this->fields["4"] = "PBString";
        $this->values["4"] = "";
        $this->fields["5"] = "PBString";
        $this->values["5"] = "";
        $this->fields["6"] = "PBString";
        $this->values["6"] = "";
        $this->fields["7"] = "PBString";
        $this->values["7"] = "";
        $this->fields["8"] = "PBString";
        $this->values["8"] = "";
    }
    function result()
    {
        return $this->_get_value("1");
    }
    function set_result($value)
    {
        return $this->_set_value("1", $value);
    }
    function taskId()
    {
        return $this->_get_value("2");
    }
    function set_taskId($value)
    {
        return $this->_set_value("2", $value);
    }
    function messageId()
    {
        return $this->_get_value("3");
    }
    function set_messageId($value)
    {
        return $this->_set_value("3", $value);
    }
    function seqId()
    {
        return $this->_get_value("4");
    }
    function set_seqId($value)
    {
        return $this->_set_value("4", $value);
    }
    function target()
    {
        return $this->_get_value("5");
    }
    function set_target($value)
    {
        return $this->_set_value("5", $value);
    }
    function info()
    {
        return $this->_get_value("6");
    }
    function set_info($value)
    {
        return $this->_set_value("6", $value);
    }
    function traceId()
    {
        return $this->_get_value("7");
    }
    function set_traceId($value)
    {
        return $this->_set_value("7", $value);
    }
    function batchId()
    {
        return $this->_get_value("8");
    }
    function set_batchId($value)
    {
        return $this->_set_value("8", $value);
    }
}
