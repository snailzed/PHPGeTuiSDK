<?php
/**
 * Created by PhpStorm.
 * User: snail
 * Date: 2018/10/12
 * Time: 下午4:06
 */

namespace GeTui\igetui;


class DictionaryAlertMsg implements ApnMsg
{

    var $title;
    var $body;
    var $titleLocKey;
    var $titleLocArgs = array();
    var $actionLocKey;
    var $locKey;
    var $locArgs = array();
    var $launchImage;
    var $subtitle;
    var $subtitleLocKey;
    var $subtitleLocArgs;

    public function get_alertMsg()
    {

        $alertMap = array();

        if ($this->title != null && $this->title != "")
        {
            $alertMap["title"] = $this->title;
        }
        if ($this->body != null && $this->body != "")
        {
            $alertMap["body"] = $this->body;
        }
        if ($this->titleLocKey != null && $this->titleLocKey != "")
        {
            $alertMap["title-loc-key"] = $this->titleLocKey;
        }
        if (sizeof($this->titleLocArgs) > 0)
        {
            $alertMap["title-loc-args"] = $this->titleLocArgs;
        }
        if ($this->actionLocKey != null && $this->actionLocKey)
        {
            $alertMap["action-loc-key"] = $this->actionLocKey;
        }
        if ($this->locKey != null && $this->locKey != "")
        {
            $alertMap["loc-key"] = $this->locKey;
        }
        if (sizeof($this->locArgs) > 0)
        {
            $alertMap["loc-args"] = $this->locArgs;
        }
        if ($this->launchImage != null && $this->launchImage != "")
        {
            $alertMap["launch-image"] = $this->launchImage;
        }

        if (count($alertMap) == 0)
        {
            return null;
        }

        if ($this->subtitle != null && $this->subtitle != "")
        {
            $alertMap["subtitle"] = $this->subtitle;
        }
        if (is_array($this->subtitleLocArgs) && sizeof($this->subtitleLocArgs) > 0)
        {
            $alertMap["subtitle-loc-args"] = $this->subtitleLocArgs;
        }
        if ($this->subtitleLocKey != null && $this->subtitleLocKey != "")
        {
            $alertMap["subtitle-loc-key"] = $this->subtitleLocKey;
        }
        return $alertMap;
    }
}