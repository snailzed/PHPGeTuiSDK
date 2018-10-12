<?php
/**
 * Created by PhpStorm.
 * User: snail
 * Date: 2018/10/12
 * Time: 下午4:13
 */

namespace GeTui\igetui\request;


use GeTui\protobuf\PBMessage;

class NotifyInfo extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
        $this->fields["4"] = "PBString";
        $this->values["4"] = "";
        $this->fields["5"] = "PBString";
        $this->values["5"] = "";
        $this->fields["6"] = "NotifyInfo_Type";
        $this->values["6"] = "";
        $this->values["6"] = new NotifyInfo_Type();
        $this->values["6"]->value = NotifyInfo_Type::_payload;
        $this->fields["7"] = "PBString";
        $this->values["7"] = "";
    }
    function title()
    {
        return $this->_get_value("1");
    }
    function set_title($value)
    {
        return $this->_set_value("1", $value);
    }
    function content()
    {
        return $this->_get_value("2");
    }
    function set_content($value)
    {
        return $this->_set_value("2", $value);
    }
    function payload()
    {
        return $this->_get_value("3");
    }
    function set_payload($value)
    {
        return $this->_set_value("3", $value);
    }
    function intent()
    {
        return $this->_get_value("4");
    }
    function set_intent($value)
    {
        return $this->_set_value("4", $value);
    }
    function url()
    {
        return $this->_get_value("5");
    }
    function set_url($value)
    {
        return $this->_set_value("5", $value);
    }
    function type()
    {
        return $this->_get_value("6");
    }
    function set_type($value)
    {
        return $this->_set_value("6", $value);
    }
    function notifyId()
    {
        return $this->_get_value("7");
    }
    function set_notifyId($value)
    {
        return $this->_set_value("7", $value);
    }
}
