<?php

declare(strict_types=1);

/**
 * Created by IntelliJ IDEA.
 * User: Sean.Xiao<jxzsxsp@qq.com>
 * Date: 2018/6/17
 * Time: 下午3:59
 */

namespace Spider\Tests\Soyoung;


use PHPUnit\Framework\TestCase;
use Spider\Soyoung\SoyoungSpider;

class SoyoungSpiderTest extends TestCase
{

    public function testSoyoungSpider():void {
        $spider = new SoyoungSpider();
        //$spider->getItem();
        //$spider->getItemGroup();
        //$spider->getHospital();
        //$spider->getDoctor();
        $spider->getDoctorHtml();
        $spider->getHospitalHtml();
    }

}