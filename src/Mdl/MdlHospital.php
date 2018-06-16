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

class MdlHospital
{

    public static function saveHospital(Connection $db, $hospital): void {
        $db->query('INSERT INTO lm_hospital', [
            "id" => $hospital->hospitalId,
            "name" => $hospital->hospitalName,
            "head_url" => $hospital->headUrl,
            "type" => $hospital->type,
            "city" => $hospital->city,
            "province" => $hospital->province,
            "cover_url" => $hospital->cover->url,
        ], 'ON DUPLICATE KEY UPDATE', [
            "name" => $hospital->hospitalName,
            "head_url" => $hospital->headUrl,
            "type" => $hospital->type,
            "city" => $hospital->city,
            "province" => $hospital->province,
            "cover_url" => $hospital->cover->url,
        ]);
    }

    private static function insert(Connection $db, $hospital): void {
        $db->query("INSERT INTO lm_hospital", [
            "id" => $hospital->hospitalId,
            "name" => $hospital->hospitalName,
            "head_url" => $hospital->headUrl,
            "type" => $hospital->type,
            "city" => $hospital->city,
            "province" => $hospital->province,
            "cover_url" => $hospital->cover->url,
        ]);
    }

    private static function update(Connection $db, $hospital): void {
        $db->query("UPDATE lm_hospital SET", [
            "id" => $hospital->hospitalId,
            "name" => $hospital->hospitalName,
            "head_url" => $hospital->headUrl,
            "type" => $hospital->type,
            "city" => $hospital->city,
            "province" => $hospital->province,
            "cover_url" => $hospital->cover->url,
        ], "WHERE id=?", $hospital->hospitalId);
    }

}