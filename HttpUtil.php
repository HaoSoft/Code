<?php
/**
 * 基于http相关的Get,Post相关工具类
 *
 * @author qingsongr@gmail.com
 */

namespace Components\Utils;

use Components\Exceptions\HttpException;

/**
 * Class HttpUtil.
 */
class HttpUtil
{

    /**
     * Curl Get 方式.
     *
     * @param string $url Get请求的url地址.
     *
     * @return array Code: 0 成功,非o 异常.
     */
    public static function curlGet($url)
    {
        if ($url) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            $output = curl_exec($ch);
            $curlErrNo = curl_errno($ch);
            //  $curlError = curl_error($ch);
            curl_close($ch);
            return array('code' => $curlErrNo, 'message' => $output);
        } else {
            return array('code' => '-1', 'message' => 'Curl:' . $url);
        }
    }

    /**
     * Curl Get 方式.
     *
     * @param string  $url               Post请求的url地址.
     * @param string  $data              Post数据内容.
     * @param boolean $convertToUrlQuery 是否转换数据为url query.
     *
     * @return array Code: 0 成功,非o 异常.
     */
    public static function curlPost($url, $data, $convertToUrlQuery = true)
    {
        if ($url) {
            $data = ($convertToUrlQuery) ? http_build_query($data) : $data;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            
            if ($convertToUrlQuery) {
                $data = http_build_query($data);
            }

            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $output = curl_exec($ch);
            $curlErrNo = curl_errno($ch);
            // $curlError = curl_error($ch);
            curl_close($ch);
            return array('code' => $curlErrNo, 'message' => $output);
        } else {
            return array('code' => '-1', 'message' => 'Curl:' . $url);
        }
    }

    /**
     * Curl Post File 方式.
     *
     * @param string $url      Post请求的url地址.
     * @param string $data     Post数据内容.
     * @param string $user     Post认证用户.
     * @param string $password Post认证密码.
     *
     * @return array Code: 0 成功,非o 异常.
     */
    public static function curlFilePost($url, $data, $user = '', $password = '')
    {
        if ($url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            if ($user && $password) {
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $password);
                // curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            }
            $output = curl_exec($ch);
            $curlErrNo = curl_errno($ch);
            curl_close($ch);
            return array('code' => $curlErrNo, 'message' => $output);
        } else {
            return array('code' => '-1', 'message' => 'Curl:' . $url);
        }
    }

}
