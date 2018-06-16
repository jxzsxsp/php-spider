<?php

declare(strict_types=1);

/**
 * Created by IntelliJ IDEA.
 * User: Sean.Xiao<jxzsxsp@qq.com>
 * Date: 2018/6/16
 * Time: 下午7:13
 */

namespace Spider\Mdl\Data;


class Hospital
{

    private $hospitalId;
    private $hospitalName;
    private $headUrl;
    private $type;
    private $province;
    private $city;

    /**
     * @return mixed
     */
    public function getHospitalId()
    {
        return $this->hospitalId;
    }

    /**
     * @param mixed $hospitalId
     */
    public function setHospitalId($hospitalId): void
    {
        $this->hospitalId = $hospitalId;
    }

    /**
     * @return mixed
     */
    public function getHospitalName()
    {
        return $this->hospitalName;
    }

    /**
     * @param mixed $hospitalName
     */
    public function setHospitalName($hospitalName): void
    {
        $this->hospitalName = $hospitalName;
    }

    /**
     * @return mixed
     */
    public function getHeadUrl()
    {
        return $this->headUrl;
    }

    /**
     * @param mixed $headUrl
     */
    public function setHeadUrl($headUrl): void
    {
        $this->headUrl = $headUrl;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param mixed $province
     */
    public function setProvince($province): void
    {
        $this->province = $province;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

}