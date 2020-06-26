<?php
namespace ReloadlyPHP\Model;

use ReloadlyPHP\Http\Response;

/**
 * Class FxRate
 * @package ReloadlyPHP\Model
 */
class FxRate
{

    /** @var $operator_id int */
    private $operator_id;

    /** @var $name string */
    private $name;

    /** @var $fx_rate string */
    private $fx_rate;

    /** @var $currency_code string */
    private $currency_code;

    /**
     * Balance constructor.
     * @param $operator_id
     * @param $name
     * @param $fx_rate
     * @param $currency_code
     */
    public function __construct($operator_id, $name, $fx_rate, $currency_code)
    {
        $this->setOperatorId($operator_id);
        $this->setCurrencyCode($currency_code);
        $this->setName($name);
        $this->setFxRate($fx_rate);
    }


    public static function fromJson($json) : ?FxRate
    {
        return new FxRate($json->id, $json->name, $json->fxRate, $json->currencyCode);
    }


    public static function fromResponse(?Response $response) : ?FxRate
    {
        return ($response != null && $response->getContent() != null) ? FxRate::fromJson($response->getContent()) : null;
    }

    /**
     * @return int
     */
    public function getOperatorId(): int
    {
        return $this->operator_id;
    }

    /**
     * @param int $operator_id
     * @return FxRate
     */
    public function setOperatorId(int $operator_id): FxRate
    {
        $this->operator_id = $operator_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return FxRate
     */
    public function setName(string $name): FxRate
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getFxRate(): string
    {
        return $this->fx_rate;
    }

    /**
     * @param string $fx_rate
     * @return FxRate
     */
    public function setFxRate($fx_rate): FxRate
    {
        $this->fx_rate = strval($fx_rate);
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currency_code;
    }

    /**
     * @param string $currency_code
     * @return FxRate
     */
    public function setCurrencyCode(string $currency_code): FxRate
    {
        $this->currency_code = $currency_code;
        return $this;
    }


}