<?php
/**
 * Created by PhpStorm.
 * User: snail
 * Date: 2018/10/12
 * Time: 下午4:24
 */

namespace GeTui\igetui\request;


use GeTui\protobuf\PBMessage;
use GeTui\protobuf\type\PBInt;
use GeTui\protobuf\type\PBString;

class Button extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = PBString::class;
        $this->values["1"] = "";
        $this->fields["2"] = PBInt::class;
        $this->values["2"] = "";
    }
    function text()
    {
        return $this->_get_value("1");
    }
    function set_text($value)
    {
        return $this->_set_value("1", $value);
    }
    function next()
    {
        return $this->_get_value("2");
    }
    function set_next($value)
    {
        return $this->_set_value("2", $value);
    }
}
