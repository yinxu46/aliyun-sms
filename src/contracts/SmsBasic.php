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


use think\facade\Config;

/**
 * Class SmsBasic
 * @package aliyun\sms\contracts
 */
class SmsBasic
{
    /**
     * 短信配置
     * @var array
     */
    public $config = [];

    /**
     * @var
     */
    public $data;

    /**
     * 返回的错误Code
     * @var string
     */
    public $errCode = '';

    /**
     * 错误信息
     * @var string
     */
    public $errMsg = '';

    /**
     * Sms constructor.
     * @param array $options
     */
    function __construct(array $options = [])
    {
        $this->config = Config::get('sms', []);
        $this->config = array_merge($options, $this->config);
        if (empty($this->config['accessKeyId'])) {
            throw new \InvalidArgumentException("Missing Config -- [accessKeyId]");
        }
        if (empty($this->config['accessKeySecret'])) {
            throw new \InvalidArgumentException("Missing Config -- [accessKeySecret]");
        }
    }

    /**
     * 请求接口
     * @param string $action
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     * @author Even <even@1000duo.cn>
     * @date 2020/03/31 12:10 下午
     */
    public function request(string $action, array $data = [])
    {
        return Tools::request($action, $data, $this->config);
    }
}