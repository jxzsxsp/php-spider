<?php

declare(strict_types=1);

/**
 * Created by IntelliJ IDEA.
 * User: Sean.Xiao<jxzsxsp@qq.com>
 * Date: 2018/6/16
 * Time: 下午4:44
 */

namespace Spider;


use Spider\Mdl\MdlSpider;

class Main
{

    public static function getMdlHospital():void {
        MdlSpider::getHospital();
    }

}