<?php
namespace ReloadlyPHP\Model;

use ReloadlyPHP\Http\Response;
use stdClass;

/**
 * Class FxRate
 * @package ReloadlyPHP\Model
 * @property int $operator_id
 * @property string $name
 * @property string $fx_rate
 * @property string $currency_code
 */
class FxRate
{
    private $operator_id;
    private $name;
    private $fx_rate;
    private $currency_code;

    /**
     * Balance constructor.
     * @param $operator_id
     * @param $name
     * @param $fx_rate
     * @param $currency_code
     */
    public function __construct($operator_id = null, $name = null, $fx_rate = null, $currency_code = null)
    {
        $this->setName($name);
        $this->setFxRate($fx_rate);
        $this->setOperatorId($operator_id);
        $this->setCurrencyCode($currency_code);
    }

    public static function fromResponseData(stdClass $data) : ?FxRate
    {
        return (new FxRate())
                ->setName($data->name)
                ->setFxRate($data->fxRate)
                ->setOperatorId($data->id)
                ->setCurrencyCode($data->currencyCode);
    }

    public static function fromResponse(?Response $response) : ?FxRate
    {
        return  ($response != null && $response->getContent() != null)
                    ? FxRate::fromResponseData($response->getContent())
                    : null;
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
    public function setOperatorId(?int $operator_id): FxRate
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
    public function setName(?string $name): FxRate
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
    public function setFxRate(?string $fx_rate): FxRate
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
    public function setCurrencyCode(?string $currency_code): FxRate
    {
        $this->currency_code = $currency_code;
        return $this;
    }

}