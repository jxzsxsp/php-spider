<?php

declare(strict_types=1);

/**
 * Created by IntelliJ IDEA.
 * User: Sean.Xiao<jxzsxsp@qq.com>
 * Date: 2018/6/16
 * Time: 下午7:05
 */

namespace Spider\Mdl;

use Nette\Database\Connection;
use Spider\Core\Http;

class MdlHospital
{

    public static function saveHospital(Connection $db, $hospital): void {
        $dir = dirname(__DIR__, 2);
        $basePath = $dir . "/images/mdl";
        $headPath = "";
        $coverPath = "";

        if (isset($hospital->headUrl) && !empty($hospital->headUrl)) {
            $headPath = Http::download($basePath, $hospital->headUrl);
        }

        if (isset($hospital->cover->url) && !empty($hospital->cover->url)) {
            $coverPath = Http::download($basePath, $hospital->cover->url);
        }

        $db->query('INSERT INTO lm_hospital', [
            "id" => $hospital->hospitalId,
            "name" => $hospital->hospitalName,
            "head_url" => $hospital->headUrl,
            "head_path" => $headPath,
            "type" => $hospital->type,
            "city" => $hospital->city,
            "province" => $hospital->province,
            "cover_url" => $hospital->cover->url,
            "cover_path" => $coverPath,
        ], 'ON DUPLICATE KEY UPDATE', [
            "name" => $hospital->hospitalName,
            "head_url" => $hospital->headUrl,
            "head_path" => $headPath,
            "type" => $hospital->type,
            "city" => $hospital->city,
            "province" => $hospital->province,
            "cover_url" => $hospital->cover->url,
            "cover_path" => $coverPath,
        ]);

    }

}