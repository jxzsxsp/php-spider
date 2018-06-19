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
use Spider\Core\Http;

class MdlDoctor
{

    public static function saveDoctor(Connection $db, $doctor): void {
        $dir = dirname(__DIR__, 2);
        $basePath = $dir . "/images/mdl";
        $headPath = "";

        if (isset($doctor->headUrl) && !empty($doctor->headUrl)) {
            $headPath = Http::download($basePath, $doctor->headUrl);
        }

        $db->query('INSERT INTO lm_doctor', [
            "id" => $doctor->doctorId,
            "name" => $doctor->doctorName,
            "hospital_id" => $doctor->hospitalId,
            "head_url" => $doctor->headUrl,
            "head_path" => $headPath,
            "position" => $doctor->position,
            "sex" => $doctor->sex,
            "province" => $doctor->province,
            "city" => $doctor->city,
            "case_num" => $doctor->doctorNum->caseNum,
            "skill" => $doctor->skill,
        ], 'ON DUPLICATE KEY UPDATE', [
            "name" => $doctor->doctorName,
            "hospital_id" => $doctor->hospitalId,
            "head_url" => $doctor->headUrl,
            "head_path" => $headPath,
            "position" => $doctor->position,
            "sex" => $doctor->sex,
            "province" => $doctor->province,
            "city" => $doctor->city,
            "case_num" => $doctor->doctorNum->caseNum,
            "skill" => $doctor->skill,
        ]);

    }

}