<?php
/**
 * Created by PhpStorm.
 * User: snail
 * Date: 2018/10/12
 * Time: 下午4:15
 */

namespace GeTui\igetui\request;

use GeTui\protobuf\PBMessage;
use GeTui\protobuf\type\PBString;

class ServerNotify extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = ServerNotifyNotifyType::class;
        $this->values["1"] = "";
        $this->fields["2"] = PBString::class;
        $this->values["2"] = "";
        $this->fields["3"] = PBString::class;
        $this->values["3"] = "";
        $this->fields["4"] = PBString::class;
        $this->values["4"] = "";
    }
    function type()
    {
        return $this->_get_value("1");
    }
    function set_type($value)
    {
        return $this->_set_value("1", $value);
    }
    function info()
    {
        return $this->_get_value("2");
    }
    function set_info($value)
    {
        return $this->_set_value("2", $value);
    }
    function extradata()
    {
        return $this->_get_value("3");
    }
    function set_extradata($value)
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
