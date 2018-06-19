<?php

declare(strict_types=1);

/**
 * Created by IntelliJ IDEA.
 * User: Sean.Xiao<jxzsxsp@qq.com>
 * Date: 2018/6/16
 * Time: 下午6:22
 */

namespace Spider\Core;

use GuzzleHttp\Psr7\Request;
use Http\Adapter\Guzzle6\Client;
use Nette\Database\Connection;

class Http
{

    private $db;

    public function __construct()
    {
        if($this->db == null) {
            $this->db = new Connection("mysql:host=127.0.0.1;dbname=linme", "root", "123456");
        }
    }

    private function saveRecord($method, $data, $url) {
        $this->db->query("INSERT INTO lm_spider_record", [
            "method" => $method,
            "data" => $data,
            "url" => $url,
        ]);
    }

    public function getData($url) {
        $content = $this->fetchData("GET", $url);
        $data = json_decode($content);
        return $data;
    }

    public function getHtml($url) {
        $content = $this->fetchData("GET", $url);
        return $content;
    }

    public function postData($url) {
        $content = $this->fetchData("POST", $url);
        $data = json_decode($content);
        return $data;
    }

    private function fetchData($method, $url) {
        $request = new Request($method, $url);
        $client = new Client();
        $response = $client->sendRequest($request);
        $body = $response->getBody();
        $content = $body->getContents();
        $this->saveRecord($method, $content, $url);
        return $content;
    }

    public static function download($basePath, $url) {
        //去除HTTP协议头
        $filepath = substr($url, strpos($url, '//') + 2);
        //去除域名
        $filepath = substr($filepath, strpos($filepath, '/'));
        //将相对路径赋值到临时变量
        $imgpath = $filepath;
        //拼接保存绝对路径
        $filepath = $basePath . $filepath;
        //获取保存绝对路径目录
        $dir = substr($filepath, 0, strrpos($filepath, '/'));

        //创建目录
        if (!is_dir($dir)) {
            $rs = mkdir($dir, 0777, TRUE);
            if ($rs) {
                var_dump("目录{$dir}创建成功！");
            }
        }

        $http = self::pget($url);
        $ext = "";
        //如果没有扩展名根据文件类型获取
        if (!strrpos($filepath, ".")) {
            $itype = ($http['head']['content_type']);
            if ($itype == 'image/gif') {
                $ext = ".gif";
            } else if ($itype == 'image/png') {
                $ext = ".png";
            } else {
                $ext = '.jpg';
            }
        }

        //保存文件
        file_put_contents($filepath . $ext, $http['data']);
        //返回文件相对路径
        return $imgpath . $ext;
    }

    public static function pget($url, $ref = false) {
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        //curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        if ($ref) {
            curl_setopt($curl, CURLOPT_REFERER, $ref); //带来的Referer
        } else {
            curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        }
        curl_setopt($curl, CURLOPT_HTTPGET, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作

        if (curl_errno($curl)) {
            echo 'Errno' . curl_error($curl);
        }

        $data['head'] = curl_getinfo($curl);
        curl_close($curl); // 关键CURL会话
        $data['data'] = $tmpInfo;
        return $data; // 返回数据
    }

}