<?php
/**
 * Created by PhpStorm.
 * User: snail
 * Date: 2018/10/12
 * Time: 下午4:16
 */

namespace GeTui\igetui\request;


use GeTui\protobuf\PBMessage;
use GeTui\protobuf\type\PBString;

class StopBatchTask extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = PBString::class;
        $this->values["1"] = "";
        $this->fields["2"] = PBString::class;
        $this->values["2"] = "";
        $this->fields["3"] = PBString::class;
        $this->values["3"] = "";
        $this->fields["4"] = PBString::class;
        $this->values["4"] = "";
    }
    function taskId()
    {
        return $this->_get_value("1");
    }
    function set_taskId($value)
    {
        return $this->_set_value("1", $value);
    }
    function appkey()
    {
        return $this->_get_value("2");
    }
    function set_appkey($value)
    {
        return $this->_set_value("2", $value);
    }
    function appId()
    {
        return $this->_get_value("3");
    }
    function set_appId($value)
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
}
