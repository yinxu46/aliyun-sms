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
 * Class Tools
 * @package aliyun\sms\contracts
 */
class Tools
{
    /**
     * 接口请求
     * @param $action
     * @param array $data
     * @param array $options
     * @return bool|mixed
     * @throws \Exception
     * @author Even <even@1000duo.cn>
     * @date 2020/03/31 12:12 下午
     */
    public static function request($action, $data = [], $options = [])
    {
        if (empty($options['Domain'])) throw new \Exception('Miss Config [domain]');
        if (empty($options['accessKeyId'])) throw new \Exception('Miss Config [accessKeyId]');
        if (empty($options['accessKeySecret'])) throw new \Exception('Miss Config [accessKeySecret]');
        if (empty($options['security'])) $options['security'] = false;

        $apiParams = array_merge(array(
            "SignatureMethod" => "HMAC-SHA1",
            "SignatureNonce" => uniqid(mt_rand(0, 0xffff), true),
            "SignatureVersion" => "1.0",
            "Timestamp" => gmdate("Y-m-d\TH:i:s\Z"),
            "Format" => "JSON",
            "Version" => $options['Version'],
            "AccessKeyId" => $options['accessKeyId'],
            "Action" => $action,
        ), $data);
        ksort($apiParams);
        $sortedQueryStringTmp = "";
        foreach ($apiParams as $key => $value) {
            $sortedQueryStringTmp .= "&" . self::encode($key) . "=" . self::encode($value);
        }

        $stringToSign = "GET&%2F&" . self::encode(substr($sortedQueryStringTmp, 1));

        $sign = base64_encode(hash_hmac("sha1", $stringToSign, $options['accessKeySecret'] . "&", true));

        $signature = self::encode($sign);

        $url = ($options['security'] ? 'https' : 'http') . "://{$options['Domain']}/?Signature={$signature}{$sortedQueryStringTmp}";

        return self::doRequest($url);
    }

    /**
     * 发送请求
     * @param string $url
     * @return mixed
     * @throws \HttpResponseException
     * @author Even <even@1000duo.cn>
     * @date 2020/03/31 12:12 下午
     */
    private static function doRequest(string $url)
    {
        try {
            $content = self::fetchContent($url);
            return json_decode($content, true);
        } catch (\Exception $e) {
            throw new \HttpResponseException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 编码
     * @param $str
     * @return null|string|string[]
     * @author Even <even@1000duo.cn>
     * @date 2019/08/30 下午3:03
     */
    private static function encode($str)
    {
        if (empty($str)) return $str;
        $res = urlencode($str);
        $res = preg_replace("/\+/", "%20", $res);
        $res = preg_replace("/\*/", "%2A", $res);
        $res = preg_replace("/%7E/", "~", $res);
        return $res;
    }

    /**
     * curl 请求
     * @param $url
     * @return mixed
     * @author Even <even@1000duo.cn>
     * @date 2019/08/30 下午3:03
     */
    private static function fetchContent($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "x-sdk-client" => "php/2.0.0"
        ));

        if (substr($url, 0, 5) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $rtn = curl_exec($ch);

        if ($rtn === false) {
            trigger_error("[CURL_" . curl_errno($ch) . "]: " . curl_error($ch), E_USER_ERROR);
        }
        curl_close($ch);

        return $rtn;
    }
}