<?php

declare(strict_types=1);

/**
 * Created by IntelliJ IDEA.
 * User: Sean.Xiao<jxzsxsp@qq.com>
 * Date: 2018/6/17
 * Time: 下午1:14
 */

namespace Spider\Soyoung;

use Nette\Database\Connection;
use Spider\Core\Http;

class SoyoungDoctor
{

    public static function saveDoctor(Connection $db, $doctor): void {
        $dir = dirname(__DIR__, 2);
        $basePath = $dir . "/images/soyoung";
        $avatarPath = "";
        $iconPath = "";

        if (isset($doctor->avatar->u) && !empty($doctor->avatar->u)) {
            $avatarPath = Http::download($basePath, $doctor->avatar->u);
        }

        if (isset($doctor->icon) && !empty($doctor->icon)) {
            $iconPath = Http::download($basePath, $doctor->icon);
        }

        $db->query('INSERT INTO lm_doctor', [
            "id" => $doctor->doctor_id,
            "name" => $doctor->name_cn,
            "certified" => $doctor->certified,
            "certified_id" => $doctor->certified_id,
            "hospital_id" => $doctor->hospital_id,
            "avatar" => $doctor->avatar->u,
            "avatar_path" => $avatarPath,
            "zizhi" => $doctor->zizhi,
            "position" => $doctor->positionName,
            "icon" => $doctor->icon,
            "icon_path" => $iconPath,
        ], 'ON DUPLICATE KEY UPDATE', [
            "name" => $doctor->name_cn,
            "certified" => $doctor->certified,
            "certified_id" => $doctor->certified_id,
            "hospital_id" => $doctor->hospital_id,
            "avatar" => $doctor->avatar->u,
            "avatar_path" => $avatarPath,
            "zizhi" => $doctor->zizhi,
            "position" => $doctor->positionName,
            "icon" => $doctor->icon,
            "icon_path" => $iconPath,
        ]);

    }

}