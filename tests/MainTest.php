<?php

declare(strict_types=1);

/**
 * Created by IntelliJ IDEA.
 * User: Sean.Xiao<jxzsxsp@qq.com>
 * Date: 2018/6/16
 * Time: 下午4:51
 */

namespace Spider\Tests;

use Nette\Database\Connection;
use PHPUnit\Framework\TestCase;
use Spider\Main;

class MainTest extends TestCase
{

    public function testMain():void {
        $db = new Connection("mysql:host=127.0.0.1;dbname=linme_mdl", "root", "123456");
        $results = $db->query("select * from lm_hospital");
        var_dump($results->getRowCount());
    }
}