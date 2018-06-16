<?php

declare(strict_types=1);

/**
 * Created by IntelliJ IDEA.
 * User: Sean.Xiao<jxzsxsp@qq.com>
 * Date: 2018/6/16
 * Time: 下午4:58
 */

namespace Spider\Mdl;

use Spider\Core\Http;
use Nette\Database\Connection;

class MdlSpider
{

    private $db;

    public function __construct()
    {
        if($this->db == null) {
            $this->db = new Connection("mysql:host=127.0.0.1;dbname=linme_mdl", "root", "123456");
        }
    }

    public function getHospital():void {
        $url = "http://m.mdl.com/api/hospitals?pn=";

        $index = 0;
        $num = 0;
        do {
            $data = Http::getData($url.$index);
            $hospitals = $data->obj->listData;

            foreach ($hospitals as $hospital) {
                MdlHospital::saveHospital($this->db, $hospital);
                $num++;
            }

            $index++;
        } while($data->obj->hasNext == 1);

        echo $num."\n";
    }

    public function getDoctor():void {
        $url = "http://m.mdl.com/api/doctors?pn=0";
        $data = Http::getData($url);
        $doctors = $data->obj->listData;

        foreach ($doctors as $doctor) {
            var_dump($doctor);
        }
    }
}