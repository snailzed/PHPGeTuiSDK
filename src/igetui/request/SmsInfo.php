<?php
/**
 * Created by PhpStorm.
 * User: snail
 * Date: 2018/10/12
 * Time: 下午4:23
 */

namespace GeTui\igetui\request;

use GeTui\protobuf\PBMessage;

class SmsInfo extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "SmsContentEntry";
        $this->values["2"] = array();
        $this->fields["3"] = "PBInt";
        $this->values["3"] = "";
        $this->fields["4"] = "PBInt";
        $this->values["4"] = "";
        $this->fields["5"] = "PBBool";
        $this->values["5"] = "";
        $this->values["5"] = new PBBool();
        $this->values["5"]->value = false;
        $this->fields["6"] = "PBString";
        $this->values["6"] = "";
    }
    function smsTemplateId()
    {
        return $this->_get_value("1");
    }
    function set_smsTemplateId($value)
    {
        return $this->_set_value("1", $value);
    }
    function smsContent($offset)
    {
        return $this->_get_arr_value("2", $offset);
    }
    function add_smsContent()
    {
        return $this->_add_arr_value("2");
    }
    function set_smsContent($index, $value)
    {
        $this->_set_arr_value("2", $index, $value);
    }
    function remove_last_smsContent()
    {
        $this->_remove_last_arr_value("2");
    }
    function smsContent_size()
    {
        return $this->_get_arr_size("2");
    }
    function offlineSendtime()
    {
        return $this->_get_value("3");
    }
    function set_offlineSendtime($value)
    {
        return $this->_set_value("3", $value);
    }
    function smsSendDuration()
    {
        return $this->_get_value("4");
    }
    function set_smsSendDuration($value)
    {
        return $this->_set_value("4", $value);
    }
    function smsChecked()
    {
        return $this->_get_value("5");
    }
    function set_smsChecked($value)
    {
        return $this->_set_value("5", $value);
    }
    function smsCheckedErrorMsg()
    {
        return $this->_get_value("6");
    }
    function set_smsCheckedErrorMsg($value)
    {
        return $this->_set_value("6", $value);
    }
}
