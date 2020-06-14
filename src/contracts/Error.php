<?php
// +----------------------------------------------------------------------
// | Aliyun SMS
// +----------------------------------------------------------------------
// | 日期 2020-06-14
// +----------------------------------------------------------------------
// | 开发者 Even <even@1000duo.cn>
// +----------------------------------------------------------------------
// | 版权所有 2020~2021 苏州千朵网络科技有限公司 [ https://www.1000duo.cn ]
// +----------------------------------------------------------------------

namespace aliyun\sms\contracts;

/**
 * Class Error
 * @package aliyun\sms\contracts
 */
class Error
{
    static $message = [
        'system.close' => '短信功能已关闭',
        'system.error' => '系统服务异常',
        'InvalidAccessKeyId.NotFound' => 'AccessKeyId不存在',
        'isp.RAM_PERMISSION_DENY' => 'RAM权限DENY',
        'isp.OUT_OF_SERVICE' => '业务停机',
        'isp.PRODUCT_UN_SUBSCRIPT' => '未开通云通信产品的阿里云客户',
        'isp.PRODUCT_UNSUBSCRIBE' => '产品未开通',
        'isp.ACCOUNT_NOT_EXISTS' => '账户不存在',
        'isp.ACCOUNT_ABNORMAL' => '账户异常',
        'isp.SMS_TEMPLATE_ILLEGAL' => '短信模板不合法',
        'isp.SMS_SIGNATURE_ILLEGAL' => '短信签名不合法',
        'isp.INVALID_PARAMETERS' => '参数异常',
        'isp.SYSTEM_ERROR' => '系统错误',
        'isp.MOBILE_NUMBER_ILLEGAL' => '非法手机号',
        'isp.MOBILE_COUNT_OVER_LIMIT' => '手机号码数量超过限制',
        'isp.TEMPLATE_MISSING_PARAMETERS' => '模板缺少变量',
        'isv.BUSINESS_LIMIT_CONTROL' => '短信发送频繁请稍后在试',
        'isp.INVALID_JSON_PARAM' => 'JSON参数不合法，只接受字符串值',
        'isp.BLACK_KEY_CONTROL_LIMIT' => '黑名单管控',
        'isp.PARAM_LENGTH_LIMIT' => '参数超出长度限制',
        'isp.PARAM_NOT_SUPPORT_URL' => '不支持URL',
        'isv.AMOUNT_NOT_ENOUGH' => '账户余额不足',
    ];
}