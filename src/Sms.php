<?php
// +----------------------------------------------------------------------
// | wechat
// +----------------------------------------------------------------------
// | 日期 2020-06-14
// +----------------------------------------------------------------------
// | 开发者 Even <even@1000duo.cn>
// +----------------------------------------------------------------------
// | 版权所有 2020~2021 苏州千朵网络科技有限公司 [ https://www.1000duo.cn ]
// +----------------------------------------------------------------------

namespace aliyun\sms;


use aliyun\sms\contracts\SmsBasic;

/**
 * Class Sms
 * @package aliyun\sms
 */
class Sms extends SmsBasic
{
    /**
     * 发送短信
     * @param string $PhoneNumbers 手机号
     * @param string $SignName 短信签名
     * @param string $TemplateCode 短信模版
     * @param array $TemplateParam 短信参数
     * @param string $OutId 自定义ID
     * @param string $SmsUpExtendCode 上行短信扩展码
     * @return bool
     * @throws \Exception
     */
    public function sendSms($PhoneNumbers, string $SignName, string $TemplateCode, array $TemplateParam = [], string $OutId = '', string $SmsUpExtendCode = '')
    {
        if (empty($PhoneNumbers)) throw new \InvalidArgumentException("Missing Config -- [PhoneNumbers]");
        if (empty($SignName)) throw new \InvalidArgumentException("Missing Config -- [SignName]");
        if (empty($TemplateCode)) throw new \InvalidArgumentException("Missing Config -- [TemplateCode]");
        if ($TemplateParam) $TemplateParam = json_encode($TemplateParam, JSON_UNESCAPED_UNICODE);

        $data = [
            'PhoneNumbers' => $PhoneNumbers,
            'SignName' => $SignName,
            'TemplateCode' => $TemplateCode,
        ];

        if ($TemplateParam) $data['TemplateParam'] = $TemplateParam;
        if ($OutId) $data['OutId'] = $OutId;
        if ($SmsUpExtendCode) $data['SmsUpExtendCode'] = $SmsUpExtendCode;

        return $this->request('SendSms', $data);
    }

    /**
     * 批量发送短信
     * @param array $PhoneNumberJson
     * @param array $SignNameJson
     * @param string $TemplateCode
     * @param array $TemplateParamJson
     * @param array $SmsUpExtendCodeJson
     * @return bool
     * @throws \Exception
     */
    public function sendBatchSms(array $PhoneNumberJson, array $SignNameJson, string $TemplateCode, array $TemplateParamJson = [], array $SmsUpExtendCodeJson = [])
    {
        if (empty($PhoneNumberJson)) throw new \InvalidArgumentException("Missing Config -- [PhoneNumbers]");
        if (empty($SignName)) throw new \InvalidArgumentException("Missing Config -- [SignName]");
        if (empty($TemplateCode)) throw new \InvalidArgumentException("Missing Config -- [TemplateCode]");

        $data = [
            'PhoneNumberJson' => json_encode($PhoneNumberJson, JSON_UNESCAPED_UNICODE),
            'SignNameJson' => json_encode($SignNameJson, JSON_UNESCAPED_UNICODE),
            'TemplateCode' => $TemplateCode,
        ];

        if ($TemplateParamJson) $data['TemplateParamJson'] = json_encode($TemplateParamJson, JSON_UNESCAPED_UNICODE);
        if ($SmsUpExtendCodeJson) $data['SmsUpExtendCodeJson'] = json_encode($SmsUpExtendCodeJson, JSON_UNESCAPED_UNICODE);

        return $this->request('SendBatchSms', $data);
    }

    /**
     * 查询短信发送的状态
     */
    public function querySendDetails()
    {
        throw new \InvalidArgumentException("功能暂未开放");
    }

    /**
     * 调用短信AddSmsSign申请短信签名
     * @param string $SignName
     * @param int $SignSource
     * 0：企事业单位的全称或简称。
     * 1：工信部备案网站的全称或简称。
     * 2：APP应用的全称或简称。
     * 3：公众号或小程序的全称或简称。
     * 4：电商平台店铺名的全称或简称。
     * 5：商标名的全称或简称
     * 说明 签名来源为1时，请在申请说明中添加网站域名，加快审核速度。
     * @param array $SignFileList [['suffix' => 'png','contents' => 'base64']]
     * @param string $Remark
     * @return bool
     * @throws \Exception
     */
    public function addSmsSign(string $SignName, int $SignSource, array $SignFileList = [], string $Remark = '')
    {
        if (empty($SignName)) throw new \InvalidArgumentException("Missing Config -- [SignName]");
        if (in_array($SignSource, [0, 1, 2, 3, 4, 5])) throw new \InvalidArgumentException("Missing Config -- [SignSource]");

        $data = [
            'SignName' => $SignName,
            'SignSource' => $SignSource,
            'Remark' => $Remark,
        ];
        if (!empty($SignFileList)) {
            $index = 1;
            foreach ($SignFileList as $key => $signFile) {
                if (isset($signFile['suffix']) && isset($signFile['contents'])) {
                    $data["SignFileList.{$index}.FileSuffix"] = $signFile['suffix'];
                    $data["SignFileList.{$index}.FileContents"] = $signFile['contents'];
                    $index++;
                }
            }
        }

        return $this->request('AddSmsSign', $data);
    }

    /**
     * 调用接口DeleteSmsSign删除短信签名
     * @param string $SignName
     * @return bool
     * @throws \Exception
     */
    public function deleteSmsSign(string $SignName)
    {
        if (empty($SignName)) throw new \InvalidArgumentException("Missing Config -- [SignName]");

        $data = [
            'SignName' => $SignName,
        ];

        # 提交
        return $this->request('DeleteSmsSign', $data);
    }

    /**
     * 调用接口QuerySmsSign查询短信签名申请状态
     * @param string $SignName
     * @return bool
     * @throws \Exception
     */
    public function querySmsSign(string $SignName)
    {
        if (empty($SignName)) throw new \InvalidArgumentException("Missing Config -- [SignName]");

        $data = [
            'SignName' => $SignName,
        ];

        return $this->request('QuerySmsSign', $data);
    }

    /**
     * 调用接口ModifySmsSign修改未审核通过的短信签名，并重新提交审核
     * @param string $SignName
     * @param int $SignSource
     * 0：企事业单位的全称或简称。
     * 1：工信部备案网站的全称或简称。
     * 2：APP应用的全称或简称。
     * 3：公众号或小程序的全称或简称。
     * 4：电商平台店铺名的全称或简称。
     * 5：商标名的全称或简称
     * 说明 签名来源为1时，请在申请说明中添加网站域名，加快审核速度。
     * @param array $SignFileList [['suffix' => 'png','contents' => 'base64']]
     * @param string $Remark
     * @return bool
     * @throws \Exception
     */
    public function modifySmsSign(string $SignName, int $SignSource, array $SignFileList = [], string $Remark = '')
    {
        if (empty($SignName)) throw new \InvalidArgumentException("Missing Config -- [SignName]");
        if (in_array($SignSource, [0, 1, 2, 3, 4, 5])) throw new \InvalidArgumentException("Missing Config -- [SignSource]");

        $data = [
            'SignName' => $SignName,
            'SignSource' => $SignSource,
            'Remark' => $Remark,
        ];
        if (!empty($SignFileList)) {
            $index = 1;
            foreach ($SignFileList as $key => $signFile) {
                if (isset($signFile['suffix']) && isset($signFile['contents'])) {
                    $data["SignFileList.{$index}.FileSuffix"] = $signFile['suffix'];
                    $data["SignFileList.{$index}.FileContents"] = $signFile['contents'];
                    $index++;
                }
            }
        }

        return $this->request('ModifySmsSign', $data);
    }

    /**
     * 调用接口AddSmsTemplate申请短信模板
     * @param int $TemplateType
     * 0：验证码。
     * 1：短信通知。
     * 2：推广短信。
     * 3：国际/港澳台消息。
     * @param string $TemplateName
     * @param string $TemplateContent 长度为1~500个字符。
     * 您正在申请手机注册，验证码为：${code}，5分钟内有效！
     * @param string $Remark 长度为1~100个字符。当前的短信模板应用于双11大促推广营销
     * @return bool|mixed
     * @throws \Exception
     */
    public function addSmsTemplate(int $TemplateType, string $TemplateName, string $TemplateContent, string $Remark)
    {
        if (!in_array($TemplateType, [0, 1, 2, 3])) throw new \InvalidArgumentException("Missing Config -- [TemplateType]");
        if (empty($TemplateName)) throw new \InvalidArgumentException("Missing Config -- [TemplateName]");
        if (empty($TemplateContent)) throw new \InvalidArgumentException("Missing Config -- [TemplateContent]");
        if (empty($Remark)) throw new \InvalidArgumentException("Missing Config -- [Remark]");

        $data = [
            'TemplateType' => $TemplateType,
            'TemplateName' => $TemplateName,
            'TemplateContent' => $TemplateContent,
            'Remark' => $Remark,
        ];

        return $this->request('AddSmsTemplate', $data);
    }

    /**
     * 调用接口ModifySmsTemplate修改未通过审核的短信模板
     * @param int $TemplateType
     * 0：验证码。
     * 1：短信通知。
     * 2：推广短信。
     * 3：国际/港澳台消息。
     * @param string $TemplateName
     * @param string $TemplateContent 长度为1~500个字符。
     * 您正在申请手机注册，验证码为：${code}，5分钟内有效！
     * @param string $Remark 长度为1~100个字符。当前的短信模板应用于双11大促推广营销
     * @return bool|mixed
     * @throws \Exception
     */
    public function modifySmsTemplate(int $TemplateType, string $TemplateName, string $TemplateContent, string $Remark)
    {
        if (!in_array($TemplateType, [0, 1, 2, 3])) throw new \InvalidArgumentException("Missing Config -- [TemplateType]");
        if (empty($TemplateName)) throw new \InvalidArgumentException("Missing Config -- [TemplateName]");
        if (empty($TemplateContent)) throw new \InvalidArgumentException("Missing Config -- [TemplateContent]");
        if (empty($Remark)) throw new \InvalidArgumentException("Missing Config -- [Remark]");

        $data = [
            'TemplateType' => $TemplateType,
            'TemplateName' => $TemplateName,
            'TemplateContent' => $TemplateContent,
            'Remark' => $Remark,
        ];

        return $this->request('ModifySmsTemplate', $data);
    }

    /**
     * 调用接口QuerySmsTemplate查询短信模板的审核状态
     * @param string $TemplateCode SMS_152550005
     * @return bool|mixed
     * @throws \Exception
     */
    public function querySmsTemplate(string $TemplateCode)
    {
        if (empty($TemplateCode)) throw new \InvalidArgumentException("Missing Config -- [TemplateCode]");

        $data = [
            'TemplateCode' => $TemplateCode,
        ];

        return $this->request('QuerySmsTemplate', $data);
    }

    /**
     * 调用接口DeleteSmsTemplate删除短信模板
     * @param string $TemplateCode SMS_152550005
     * @return bool|mixed
     * @throws \Exception
     */
    public function deleteSmsTemplate(string $TemplateCode)
    {
        if (empty($TemplateCode)) throw new \InvalidArgumentException("Missing Config -- [TemplateCode]");

        $data = [
            'TemplateCode' => $TemplateCode,
        ];

        return $this->request('DeleteSmsTemplate', $data);
    }
}