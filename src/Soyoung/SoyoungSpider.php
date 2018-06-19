<?php

declare(strict_types=1);

/**
 * Created by IntelliJ IDEA.
 * User: Sean.Xiao<jxzsxsp@qq.com>
 * Date: 2018/6/17
 * Time: 下午3:51
 */

namespace Spider\Soyoung;

use Spider\Core\Http;
use Nette\Database\Connection;

class SoyoungSpider
{

    private $db;
    private $http;

    public function __construct()
    {
        if($this->db == null) {
            $this->db = new Connection("mysql:host=127.0.0.1;dbname=linme_soyoung", "root", "123456");
        }

        if($this->http == null) {
            $this->http = new Http();
        }
    }

    public function getItem():void {
        $itemUrl = "http://api.soyoung.com/v4/itemnewlist";

        $data = $this->http->getData($itemUrl);
        $items = $data->responseData->item;

        foreach ($items as $menu1) {
            SoyoungItem::saveItemMenu1($this->db, $menu1);

            foreach ($menu1->menu2 as $menu2) {
                SoyoungItem::saveItemMenu2($this->db, $menu2);

                foreach ($menu2->item as $item) {
                    SoyoungItem::saveItem($this->db, $item, $menu2->menu2_id);
                }
            }
        }

    }

    public function getItemGroup():void {
        $groupUrl = "http://api.soyoung.com/v8/items/getItemIndex";

        $data = $this->http->getData($groupUrl);
        $items = $data->responseData->item;

        foreach ($items as $menu1) {
            SoyoungItem::saveItemGroup($this->db, $menu1->name);

            $groupId = SoyoungItem::getItemGroupId($this->db, $menu1->name);

            foreach ($menu1->menu1 as $item) {
                $itemId = SoyoungItem::getItemId($this->db, $item->name);
                SoyoungItem::saveItemGroupRel($this->db, $itemId, $groupId);
            }
        }
    }

    public function getHospital():void {
        $url = "http://api.soyoung.com/v8/hospitals/list?index=";

        $index = 0;
        $num = 0;
        do {
            $data = $this->http->getData($url.$index);
            $hospitals = $data->responseData->dphospital;

            foreach ($hospitals as $hospital) {
                SoyoungHospital::saveHospital($this->db, $hospital);
                $num++;
            }

            $index++;
        } while($data->responseData->has_more == "1");

        echo $num."\n";
    }

    public function getDoctor():void {
        $url = "http://api.soyoung.com/v8/doctors/doctorlist?index=";

        $index = 0;
        $num = 0;
        do {
            $data = $this->http->getData($url.$index);
            $doctors = $data->responseData->dpdoctor;

            foreach ($doctors as $doctor) {
                SoyoungDoctor::saveDoctor($this->db, $doctor);

                $num++;
            }

            $index++;
        } while($data->responseData->has_more == "1");

    }

    public function getDoctorHtml():void {
        $infoUrl = "http://h5inapp.soyoung.com/doctor/info?doctor_id=";
        $detailUrl = "http://h5inapp.soyoung.com/doctor/detail?doctor_id=";
        $honor = "http://h5inapp.soyoung.com/doctor/honor?doctor_id=";
        $license = "http://h5inapp.soyoung.com/doctor/license?doctor_id=";
        $callUrl = "http://h5inapp.soyoung.com/doctor/doctorCal?doctor_id=";
        $productUrl = "http://h5inapp.soyoung.com/doctor/doctorProduct?doctor_id=";

        $index = 0;
        do {
            $this->http->getHtml($infoUrl.$index);
            $this->http->getHtml($detailUrl.$index);
            $this->http->getHtml($honor.$index);
            $this->http->getHtml($license.$index);
            $this->http->getHtml($callUrl.$index);
            $this->http->getHtml($productUrl.$index);

            sleep(random_int(1,10));
            $index++;
        } while ($index <= 100000);
    }

    public function getHospitalHtml():void {
        $infoUrl = "http://h5inapp.soyoung.com/hospital/info?hospital_id=";
        $detailUrl = "http://h5inapp.soyoung.com/hospital/Photo?album_id=1&hospital_id=";
        $photoJson = "http://h5inapp.soyoung.com/hospital/photo?album_id=12&json=1&hospital_id=";

        $index = 0;
        $albumIds = [1,2,12];
        do {
            $this->http->getHtml($infoUrl.$index);

            $i = 0;
            do {
                $this->http->getHtml("http://h5inapp.soyoung.com/hospital/Photo?album_id={$i}&hospital_id={$index}");
                $this->http->getData("http://h5inapp.soyoung.com/hospital/photo?album_id={$i}&json=1&hospital_id={$index}");

                $i++;
            } while ($i <= 20);

            sleep(random_int(1,10));
            $index++;
        } while ($index <= 200000);
    }

}