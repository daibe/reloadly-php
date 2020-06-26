<?php
namespace ReloadlyPHP\Model;


use DateTime;
use DateTimeInterface;
use Exception;
use ReloadlyPHP\Http\Response;

/**
 * Class Balance
 * @package ReloadlyPHP\Model
 *
 * @property $balance string
 * @property $currency_code string
 * @property $currency_name string
 * @property $updated_at DateTime
 */
class Balance
{

    // {"balance":0.00,"currencyCode":"USD","currencyName":"US Dollar","updatedAt":"2020-06-03 07:45:48"}

    private $balance;
    private $currency_code;
    private $currency_name;
    private $updated_at;

    /**
     * Balance constructor.
     * @param $balance
     * @param $currency_code
     * @param $currency_name
     * @param $updated_at
     */
    public function __construct($balance, $currency_code, $currency_name, $updated_at)
    {
        $this->setBalance($balance);
        $this->setCurrencyCode($currency_code);
        $this->setCurrencyName($currency_name);
        $this->setUpdatedAt($updated_at);
    }


    public static function fromJson($json) : ?Balance
    {
        return new Balance($json->balance, $json->currencyCode, $json->currencyName, $json->updatedAt);
    }


    public static function fromResponse(?Response $response) : ?Balance
    {
        return ($response != null && $response->getContent() != null) ? Balance::fromJson($response->getContent()) : null;
    }

    /**
     * @return string
     */
    public function getBalance() : string
    {
        return $this->balance;
    }

    /**
     * @param mixed $balance
     * @return Balance
     */
    public function setBalance($balance)
    {
        $this->balance = strval($balance);
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrencyCode() : string
    {
        return $this->currency_code;
    }

    /**
     * @param string $currency_code
     * @return $this
     */
    public function setCurrencyCode(string $currency_code)
    {
        $this->currency_code = $currency_code;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrencyName() : string
    {
        return $this->currency_name;
    }

    /**
     * @param string $currency_name
     * @return $this
     */
    public function setCurrencyName(string $currency_name)
    {
        $this->currency_name = $currency_name;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt() : ?DateTimeInterface
    {
        return $this->updated_at;
    }

    /**
     * @param string|null $updated_at
     * @return $this
     */
    public function setUpdatedAt(?string $updated_at)
    {
        try {
            $this->updated_at = new DateTime($updated_at);
        } catch (Exception $e) {
        }
        return $this;
    }


}