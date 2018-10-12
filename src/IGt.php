<?php
/**
 * Created by PhpStorm.
 * User: snail
 * Date: 2017/11/29
 * Time: 下午3:16
 *
 * mark: IOS只能用透传模板才不会有原生弹窗
 */

namespace GeTui;

use GeTui\exception\RequestException;
use GeTui\igetui\DictionaryAlertMsg;
use GeTui\igetui\IGtAPNPayload;
use GeTui\igetui\IGtAppMessage;
use GeTui\igetui\IGtSingleMessage;
use GeTui\igetui\IGtTarget;
use GeTui\igetui\template\IGtBaseTemplate;
use GeTui\igetui\template\IGtLinkTemplate;
use GeTui\igetui\template\IGtNotificationTemplate;
use GeTui\igetui\template\IGtNotyPopLoadTemplate;
use GeTui\igetui\template\IGtTransmissionTemplate;
use GeTui\igetui\utils\AppConditions;
use \Exception;

class IGt
{
    /**保存当前实例
     *
     * @var null
     */
    private static $igetui = null;

    /**点击通知打开应用模板
     *
     * @var int
     */
    public static $notification_tpl = 10;

    /**点击通知打开网页模板
     *
     * @var int
     */
    public static $link_tpl = 20;

    /**点击通知弹窗下载模板
     *
     * @var int
     */
    public static $notyPopLoad_tpl = 30;

    /**透传消息模版
     *
     * @var int
     */
    public static $transmission_tpl = 40;

    /**IOS客户端
     *
     * @var string
     */
    private static $IOS = "ios";

    /**android客户端
     *
     * @var string
     */
    private static $ANDROID = "android";


    /**
     * @var array
     */
    private static $config = array(
        'host'         => 'https://sdk.open.api.igexin.com/apiex.htm',
        'appid'        => '',
        'appsecret'    => '',
        'appkey'       => '',
        'mastersecret' => '',
    );

    /**初始化，设置个推配置参数
     * IGt constructor.
     */
    private function __construct($config = array())
    {
        self::$config = array_merge(self::$config, $config);
    }

    /**获取当前类实例
     *
     * @param array $config
     * @param bool  $new
     *
     * @return \GeTui\IGt|null
     */
    public static function getInstance($config = array(), $new = false)
    {
        if ($new)
        {
            self::$igetui = new self($config);
        }
        else
        {
            if (!(self::$igetui instanceof self))
            {
                self::$igetui = new self($config);
            }
        }
        return self::$igetui;
    }

    /** pushMessageToSingleBatch
     *  批量单推功能
     * 用于一次创建提交多个单推任务。
     * 当单推任务较多时，推荐使用该接口，可以减少与服务端的交互次数。
     *
     * @param       $tpl_type
     * @param       $clentID
     * @param array $content
     * @param int   $offlineExpireTime
     */
    public function pushMessageToSingle($tpl_type, array $clentID, array $content, $offlineExpireTime = 432000000)
    {
        $igt = new IGeTui(self::$config['host'], self::$config['appkey'], self::$config['mastersecret']);
        foreach ($clentID as $cid => $client)
        {
            //IOS客户端只使用透传模板，安卓则使用传入进来的模板
            if (strtolower($client) === self::$IOS)
            {
                $template = $this->getTemplate(self::$transmission_tpl, $content);
            }
            else
            {
                $template = $this->getTemplate($tpl_type, $content);
            }
            //个推信息体
            $message = new IGtSingleMessage();
            $message->set_isOffline(true);//是否离线
            $message->set_offlineExpireTime($offlineExpireTime);//离线时间
            $message->set_data($template);//设置推送消息类型
            $message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
            //接收方
            $target = new IGtTarget();
            $target->set_appId(self::$config['appid']);
            $target->set_clientId($cid);
//    $target->set_alias(Alias);
            try
            {
                $rep = $igt->pushMessageToSingle($message, $target);
            }
            catch (RequestException $e)
            {
                $requstId = $e->getRequestId();
                $rep = $igt->pushMessageToSingle($message, $target, $requstId);
            }
            if (strtolower($rep['result']) != 'ok')
            {
                return $rep['result'];
            }
            return true;
            break;
        }
    }

    /**推送消息某个app的全体用户
     *
     * @param  integer $tpl_type
     * @param array    $content
     * @param int      $offlineExpireTime
     * @param array    $uphoneTypeList IOS|ANDROID
     * @param array    $uprovinceList
     * @param array    $utagList
     */
    public function pushMessageToApp($tpl_type, array $content, $offlineExpireTime = 432000000, $uphoneTypeList = array(), $uprovinceList = array(), $utagList = array())
    {
        $res = true;
        if (empty($uphoneTypeList))
        {
            $res = $this->pushMessageToAndroidApp($tpl_type, $content, "ANDROID", $offlineExpireTime, $uprovinceList, $utagList) |
                $this->pushMessageToIOSApp($content, "IOS", $offlineExpireTime, $uprovinceList, $utagList);
        }
        else
        {
            if (in_array("IOS", $uphoneTypeList))
            {
                $res = $this->pushMessageToIOSApp($content, "IOS", $offlineExpireTime, $uprovinceList, $utagList);
            }
            if (in_array("ANDROID", $uphoneTypeList))
            {
                $res = $this->pushMessageToAndroidApp($tpl_type, $content, "ANDROID", $offlineExpireTime, $uprovinceList, $utagList);
            }
        }
        return $res;
    }

    /**推送消息给app ios用户
     *
     * @param array  $content
     * @param string $taskGroupName
     * @param int    $offlineExpireTime
     * @param array  $uprovinceList
     * @param array  $utagList
     *
     * @return bool
     */
    private function pushMessageToIOSApp(array $content, $taskGroupName = "IOS", $offlineExpireTime = 432000000, $uprovinceList = array(), $utagList = array())
    {
        $igt = new IGeTui(self::$config['host'], self::$config['appkey'], self::$config['mastersecret']);
        $template = $this->getTemplate(self::$transmission_tpl, $content);
        //个推信息体
        //基于应用消息体
        $message = new IGtAppMessage();
        $message->set_isOffline(true);
        $message->set_offlineExpireTime($offlineExpireTime);//离线时间单位为毫秒，例，两个小时离线为3600*1000*2
        $message->set_data($template);

        $appIdList = array(self::$config['appid']);

        //设置发送条件
        $cdt = new AppConditions();

        //只发送给IOS用户
        $phoneTypeList = array('IOS');
        $cdt->addCondition2(AppConditions::PHONE_TYPE, $phoneTypeList);
        empty($uprovinceList) ?: $cdt->addCondition2(AppConditions::REGION, $uprovinceList);
        empty($utagList) ?: $cdt->addCondition2(AppConditions::TAG, $utagList);

        $message->set_appIdList($appIdList);
        $message->set_conditions($cdt);
        try
        {
            $rep = $igt->pushMessageToApp($message, $taskGroupName);
        }
        catch (Exception $e)
        {
            //重发
            $rep = $igt->pushMessageToApp($message, $taskGroupName);
        }
        if (strtolower($rep['result']) != 'ok')
        {

            return false;
        }
        return true;
    }

    /**推送消息给安卓用户
     *
     * @param        $tpl_type
     * @param array  $content
     * @param string $taskGroupName
     * @param int    $offlineExpireTime
     * @param array  $uprovinceList
     * @param array  $utagList
     *
     * @return bool
     */
    private function pushMessageToAndroidApp($tpl_type, array $content, $taskGroupName = "ANDROID", $offlineExpireTime = 432000000, $uprovinceList = array(), $utagList = array())
    {
        $igt = new IGeTui(self::$config['host'], self::$config['appkey'], self::$config['mastersecret']);
        $template = $this->getTemplate($tpl_type, $content);
        //个推信息体
        //基于应用消息体
        $message = new IGtAppMessage();
        $message->set_isOffline(true);
        $message->set_offlineExpireTime($offlineExpireTime);//离线时间单位为毫秒，例，两个小时离线为3600*1000*2
        $message->set_data($template);

        $appIdList = array(self::$config['appid']);

        //设置发送条件
        $cdt = new AppConditions();

        //只发送给ANDROID用户
        $phoneTypeList = array('ANDROID');
        $cdt->addCondition2(AppConditions::PHONE_TYPE, $phoneTypeList);
        empty($uprovinceList) ?: $cdt->addCondition2(AppConditions::REGION, $uprovinceList);
        empty($utagList) ?: $cdt->addCondition2(AppConditions::TAG, $utagList);

        $message->set_appIdList($appIdList);
        $message->set_conditions($cdt);

        try
        {
            $rep = $igt->pushMessageToApp($message, $taskGroupName);
        }
        catch (Exception $e)
        {
            $rep = $igt->pushMessageToApp($message, $taskGroupName);
        }
        if (strtolower($rep['result']) != 'ok')
        {
            return false;
        }
        return true;
    }

    /**
     * @param   integer $tpl_type
     * @param array     $reciever_cids cid=>client  客户端id=>客户端类型ios或者android
     * @param array     $content
     * @param int       $offlineExpireTime
     *
     * @return bool
     */
    public function pushMessageToList($tpl_type, array $reciever_cids, array $content, $offlineExpireTime = 432000000)
    {
        putenv("gexin_pushSingleBatch_needAsync=false");
        $igt = new IGeTui(self::$config['host'], self::$config['appkey'], self::$config['mastersecret']);
        $batch = new IGtBatch(self::$config['appkey'], $igt);
        $batch->setApiUrl(self::$config['host']);
        foreach ($reciever_cids as $cid => $client)
        {
            //IOS客户端只使用透传模板，安卓则使用传入进来的模板
            if (strtolower($client) === self::$IOS)
            {
                $template = $this->getTemplate(self::$transmission_tpl, $content);
            }
            else
            {
                $template = $this->getTemplate($tpl_type, $content);
            }
            //创建信息体
            $message = new IGtSingleMessage();
            $message->set_isOffline(true);//是否离线
            $message->set_offlineExpireTime($offlineExpireTime);//离线时间
            $message->set_data($template);//设置推送消息类型
            $message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送

            $target = new IGtTarget();
            $target->set_appId(self::$config['appid']);
            $target->set_clientId($cid);
            $batch->add($message, $target);
        }
        try
        {
            $rep = $batch->submit();
        }
        catch (Exception $e)
        {
            $rep = $batch->retry();
        }
        if (strtolower($rep['result']) != 'ok')
        {
            return $rep['result'];
        }
        return true;
    }

    /**获取模板
     *
     * @param    integer $tpl_type
     * @param array      $content
     *
     * @return IGtLinkTemplate|IGtNotificationTemplate|IGtNotyPopLoadTemplate|IGtTransmissionTemplate
     */

    private function getTemplate($tpl_type, array $content)
    {
        $begin_time = empty($content["begin_time"]) ? "" : $content["begin_time"];
        $end_time = empty($content["end_time"]) ? "" : $content["end_time"];
        switch ($tpl_type)
        {
            case self::$link_tpl:
                $badge = empty($content["badge"]) ? 1 : $content["badge"];
                $template = $this->IGtLinkTemplate($content["title"], $content["content"], $content["payload"], $content["logo"], $content["open_url"], $badge, $begin_time, $end_time);
                break;

            case self::$notyPopLoad_tpl:
                $template = $this->IGtNotyPopLoadTemplate($content["title"], $content["content"], $content["logo"], $content["pop_title"], $content["pop_content"], $content["download_icon"], $content["download_title"], $content["download_url"], $content["pop_image"], $content["button1"], $content["button2"], $begin_time, $end_time);
                break;

            case self::$transmission_tpl:
                $badge = empty($content["badge"]) ? 1 : $content["badge"];
                $template = $this->IGtTransmissionTemplate($content["title"], $content["content"], $content["payload"], $badge, $begin_time, $end_time);
                break;

            case self::$notification_tpl:
            default :
                $badge = empty($content["badge"]) ? 1 : $content["badge"];
                $template = $this->IGtNotificationTemplate($content["title"], $content["content"], $content["payload"], $content["logo"], $badge, $begin_time, $end_time);
        }
        return $template;
    }

    /**打开链接模板
     * IOS打开会有原生弹窗提示，有通知栏显示
     * Android不会有弹窗提示，有通知栏显示
     *
     * @param   string  $title
     * @param   string  $content
     * @param   string  $logo
     * @param    string $open_url
     * @param string    $begin_time
     * @param string    $end_time
     *
     * @return IGtLinkTemplate
     */
    private function IGtLinkTemplate($title, $content, $payload, $logo, $open_url, $badge = 1, $begin_time = "", $end_time = "")
    {
        $template = new IGtLinkTemplate();
        $template->set_appId(self::$config['appid']);//应用appid
        $template->set_appkey(self::$config['appkey']);//应用appkey
        $template->set_title($title);//通知栏标题
        $template->set_text($content);//通知栏内容
        $template->set_logo($logo);//通知栏logo
        $template->set_isRing(true);//是否响铃
        $template->set_isVibrate(true);//是否震动
        $template->set_isClearable(true);//通知栏是否可清除
        $template->set_url($open_url);//打开连接地址
        if (!empty($begin_time) && !empty($end_time))
        {
            $template->set_duration($begin_time, $end_time); //设置ANDROID客户端在此时间区间内展示消息
        }
        //设置IOS通知栏
        $this->setIOSTemplate($template, $title, $content, $payload, $badge);
        return $template;
    }

    /**下载模板，IOS不支持该模板，Android支持
     *
     * @param  string  $title
     * @param  string  $content
     * @param  string  $logo
     * @param  string  $pop_title
     * @param   string $pop_content
     * @param string   $pop_image
     * @param  string  $download_icon
     * @param  string  $download_title
     * @param  string  $download_url
     * @param string   $button1
     * @param string   $button2
     * @param string   $begin_time
     * @param string   $end_time
     *
     * @return IGtNotyPopLoadTemplate
     */
    private function IGtNotyPopLoadTemplate($title, $content, $logo, $pop_title, $pop_content, $download_icon, $download_title, $download_url, $pop_image = "", $button1 = "下载", $button2 = "取消", $begin_time = "", $end_time = "")
    {
        $template = new IGtNotyPopLoadTemplate();

        $template->set_appId(self::$config['appid']);//应用appid
        $template->set_appkey(self::$config['appkey']);//应用appkey
        //通知栏设置
        $template->set_notyTitle($title);//通知栏标题
        $template->set_notyContent($content);//通知栏内容
        $template->set_notyIcon($logo);//通知栏logo
        $template->set_isBelled(true);//是否响铃
        $template->set_isVibrationed(true);//是否震动
        $template->set_isCleared(true);//通知栏是否可清除

        //点击通知打开app后的弹框设置
        $template->set_popTitle($pop_title);//弹框标题
        $template->set_popContent($pop_content);//弹框内容
        $template->set_popImage($pop_image);//弹框图片
        $template->set_popButton1($button1);//左键
        $template->set_popButton2($button2);//右键

        //点击了下载按钮时在通知栏的设置
        $template->set_loadIcon(empty($download_icon) ? $logo : $download_icon);//弹框图片
        $template->set_loadTitle($download_title);
        $template->set_loadUrl($download_url);
        $template->set_isAutoInstall(false);
        $template->set_isActived(true);
        if (!empty($begin_time) && !empty($end_time))
        {
            $template->set_duration($begin_time, $end_time); //设置ANDROID客户端在此时间区间内展示消息
        }
        return $template;
    }

    /**透传消息模板
     * IOS只能使用透传消息模板才不会有弹窗
     * Android使用透传消息模板会主动打开App
     *
     * @param    string $title
     * @param   string  $content
     * @param   string  $payload
     * @param int       $badge
     * @param string    $begin_time
     * @param string    $end_time
     *
     * @return IGtTransmissionTemplate
     */
    private function IGtTransmissionTemplate($title, $content, $payload, $badge = 1, $begin_time = "", $end_time = "")
    {
        $template = new IGtTransmissionTemplate();
        $template->set_appId(self::$config['appid']);//应用appid
        $template->set_appkey(self::$config['appkey']);//应用appkey
        $template->set_transmissionType(1);//透传消息类型
        $template->set_transmissionContent($payload);//透传内容
        if (!empty($begin_time) && !empty($end_time))
        {
            $template->set_duration($begin_time, $end_time); //设置ANDROID客户端在此时间区间内展示消息
        }

        //设置IOS通知栏
        $this->setIOSTemplate($template, $title, $content, $payload, $badge);
        return $template;
    }

    private function IGtNotificationTemplate($title, $content, $payload, $logo, $badge = 1, $begin_time = "", $end_time = "")
    {
        $template = new IGtNotificationTemplate();
        $template->set_appId(self::$config['appid']);//应用appid
        $template->set_appkey(self::$config['appkey']);//应用appkey
        $template->set_transmissionType(1);//透传消息类型
        $template->set_transmissionContent($payload);//透传内容
        $template->set_title($title);//通知栏标题
        $template->set_text($content);//通知栏内容
        $template->set_logo($logo);//通知栏logo
        $template->set_isRing(true);//是否响铃
        $template->set_isVibrate(true);//是否震动
        $template->set_isClearable(true);//通知栏是否可清除
        if (!empty($begin_time) && !empty($end_time))
        {
            $template->set_duration($begin_time, $end_time); //设置ANDROID客户端在此时间区间内展示消息
        }

        //设置IOS通知栏
        $this->setIOSTemplate($template, $title, $content, $payload, $badge);
        return $template;
    }

    /**设置IOS通知栏,因为设置IOS通知栏方法一致，故提出来
     *
     * @param \IGtBaseTemplate   $template
     * @param     string         $title
     * @param         string     $content
     * @param             string $payload
     * @param          integer   $badge
     */
    private function setIOSTemplate(IGtBaseTemplate &$template, $title, $content, $payload, $badge)
    {

        //APN简单推送
//        $template = new IGtAPNTemplate();
//        $apn = new IGtAPNPayload();
//        $alertmsg = new SimpleAlertMsg();
//        $alertmsg->alertMsg = "";
//        $apn->alertMsg = $alertmsg;
////        $apn->badge=2;
////        $apn->sound="";
//        $apn->add_customMsg("payload", "payload");
//        $apn->contentAvailable = 1;
//        $apn->category = "ACTIONABLE";
//        $template->set_apnInfo($apn);
//        $message = new IGtSingleMessage();

        //APN高级推送
        $apn = new IGtAPNPayload();
        $alertmsg = new DictionaryAlertMsg();
        $alertmsg->body = $content;
        $alertmsg->actionLocKey = "ActionLockey";
        $alertmsg->locKey = "LocKey";
        $alertmsg->locArgs = array("locargs");
        $alertmsg->launchImage = "launchimage";
//        IOS8.2 支持
        $alertmsg->title = $title;
        $alertmsg->titleLocKey = "TitleLocKey";
        $alertmsg->titleLocArgs = array("TitleLocArg");

        $apn->alertMsg = $alertmsg;
        $apn->badge = $badge;
        $apn->sound = "";
        $apn->add_customMsg("payload", $payload);
        $apn->contentAvailable = 1;
        $apn->category = "ACTIONABLE";
        $template->set_apnInfo($apn);


        //PushApn老方式传参
//    $template = new IGtAPNTemplate();
//          $template->set_pushInfo("", 10, "", "com.gexin.ios.silence", "", "", "", "");

    }
}
