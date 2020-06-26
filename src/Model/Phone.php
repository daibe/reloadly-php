<?php
namespace ReloadlyPHP\Model;


class Phone
{

    /** @var $country_code string */
    private $country_code;

    /** @var $number string */
    private $number;

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->country_code;
    }

    /**
     * @param string $country_code
     * @return Phone
     */
    public function setCountryCode(string $country_code): Phone
    {
        $this->country_code = $country_code;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return Phone
     */
    public function setNumber(string $number): Phone
    {
        $this->number = $number;
        return $this;
    }


    public function toArray()
    {
        return [
            "countryCode" => $this->getCountryCode(),
            "number" => $this->getNumber(),
        ];
    }
}