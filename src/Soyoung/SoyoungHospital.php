<?php

declare(strict_types=1);

/**
 * Created by IntelliJ IDEA.
 * User: Sean.Xiao<jxzsxsp@qq.com>
 * Date: 2018/6/16
 * Time: 下午7:05
 */

namespace Spider\Soyoung;

use Nette\Database\Connection;
use Spider\Core\Http;

class SoyoungHospital
{

    public static function saveHospital(Connection $db, $hospital): void {
        $dir = dirname(__DIR__, 2);
        $basePath = $dir . "/images/soyoung";
        $avatarPath = "";
        $iconPath = "";

        if (isset($hospital->avatar->u) && !empty($hospital->avatar->u)) {
            $avatarPath = Http::download($basePath, $hospital->avatar->u);
        }

        if (isset($hospital->icon) && !empty($hospital->icon)) {
            $iconPath = Http::download($basePath, $hospital->icon);
        }

        $db->query('INSERT INTO lm_hospital', [
            "id" => $hospital->hospital_id,
            "name" => $hospital->name_cn,
            "type" => $hospital->type,
            "address" => $hospital->address,
            "certified" => $hospital->certified,
            "certified_id" => $hospital->certified_id,
            "avatar" => $hospital->avatar->u,
            "avatar_path" => $avatarPath,
            "icon" => $hospital->icon,
            "icon_path" => $iconPath,
        ], 'ON DUPLICATE KEY UPDATE', [
            "name" => $hospital->name_cn,
            "type" => $hospital->type,
            "address" => $hospital->address,
            "certified" => $hospital->certified,
            "certified_id" => $hospital->certified_id,
            "avatar" => $hospital->avatar->u,
            "avatar_path" => $avatarPath,
            "icon" => $hospital->icon,
            "icon_path" => $iconPath,
        ]);

    }

}