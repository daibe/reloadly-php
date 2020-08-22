<?php
namespace ReloadlyPHP\Model;

use DateTime;
use DateTimeInterface;
use Exception;
use ReloadlyPHP\Http\Response;
use stdClass;

/**
 * Class Balance
 * @package ReloadlyPHP\Model
 *
 * @property float $balance
 * @property string $currency_code
 * @property string $currency_name
 * @property DateTime $updated_at
 */
class Balance
{
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
    public function __construct($balance = null, $currency_code = null, $currency_name = null, $updated_at = null)
    {
        $this->setBalance($balance);
        $this->setCurrencyCode($currency_code);
        $this->setCurrencyName($currency_name);
        $this->setUpdatedAt($updated_at);
    }


    public static function fromResponseData(stdClass $data) : ?Balance
    {
        return (new Balance())
                ->setBalance($data->balance)
                ->setCurrencyCode($data->currencyCode)
                ->setCurrencyName($data->currencyName)
                ->setUpdatedAt($data->updatedAt);
    }


    public static function fromResponse(?Response $response) : ?Balance
    {
        return ($response != null && $response->getContent() != null) ? Balance::fromResponseData($response->getContent()) : null;
    }

    /**
     * @return float|null
     */
    public function getBalance() : ?float
    {
        return $this->balance;
    }

    /**
     * @param float $balance
     * @return Balance
     */
    public function setBalance(?float $balance)
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
    public function setCurrencyCode(?string $currency_code)
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
    public function setCurrencyName(?string $currency_name)
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