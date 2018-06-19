<?php

declare(strict_types=1);

/**
 * Created by IntelliJ IDEA.
 * User: Sean.Xiao<jxzsxsp@qq.com>
 * Date: 2018/6/17
 * Time: 下午1:14
 */

namespace Spider\Mdl;


use Nette\Database\Connection;

class MdlItem
{

    public static function saveItem(Connection $db, $item) {
        $db->query("INSERT INTO lm_item", [
            "id" => $item->itemId,
            "name" => $item->itemName,
            "url" => $item->url,
        ], "ON DUPLICATE KEY UPDATE", [
            "name" => $item->itemName,
            "url" => $item->url,
        ]);
    }

    public static function saveDoctorItemCase(Connection $db, $doctorId, $itemId, $caseNum) {
        $db->query("INSERT INTO lm_doctor_item_case", [
            "doctor_id" => $doctorId,
            "item_id" => $itemId,
            "case_num" => $caseNum,
        ], "ON DUPLICATE KEY UPDATE", [
            "case_num" => $caseNum,
        ]);
    }

}