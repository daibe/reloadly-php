<?php
namespace ReloadlyPHP\Model;

use ReloadlyPHP\Http\Response;

/**
 * Class Country
 * @package ReloadlyPHP\Model
 * @property string $operator_id
 * @property string $name
 * @property string $currency_code
 * @property string $currency_name
 * @property string $currency_symbol
 * @property string $flag
 * @property string $calling_codes
 */
class Country
{

    private $iso_name;
    private $name;
    private $currency_code;
    private $currency_name;
    private $currency_symbol;
    private $flag;
    private $calling_codes;

    /**
     * Balance constructor.
     * @param $iso_name
     * @param $name
     * @param $currency_code
     * @param $currency_name
     * @param $currency_symbol
     * @param $flag
     * @param $calling_codes
     */
    public function __construct($iso_name, $name, $currency_code, $currency_name, $currency_symbol, $flag, $calling_codes)
    {
        $this->setIsoName($iso_name);
        $this->setName($name);
        $this->setCurrencyCode($currency_code);
        $this->setCurrencyName($currency_name);
        $this->setCurrencySymbol($currency_symbol);
        $this->setFlag($flag);
        $this->setCallingCodes($calling_codes);
    }

    public static function fromResponseData($json) : ?Country
    {
        return new Country($json->isoName, $json->name, $json->currencyCode, $json->currencyName, $json->currencySymbol, $json->flag, $json->callingCodes);
    }


    public static function fromResponse(?Response $response) : ?Country
    {
        return ($response != null && $response->getContent() != null) ? Country::fromResponseData($response->getContent()) : null;
    }

    /**
     * @return string
     */
    public function getIsoName(): ?string
    {
        return $this->iso_name;
    }

    /**
     * @param string $iso_name
     * @return Country
     */
    public function setIsoName(?string $iso_name): Country
    {
        $this->iso_name = $iso_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Country
     */
    public function setName(?string $name): Country
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): ?string
    {
        return $this->currency_code;
    }

    /**
     * @param string $currency_code
     * @return Country
     */
    public function setCurrencyCode(?string $currency_code): Country
    {
        $this->currency_code = $currency_code;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrencyName(): ?string
    {
        return $this->currency_name;
    }

    /**
     * @param string $currency_name
     * @return Country
     */
    public function setCurrencyName(?string $currency_name): Country
    {
        $this->currency_name = $currency_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrencySymbol(): ?string
    {
        return $this->currency_symbol;
    }

    /**
     * @param string $currency_symbol
     * @return Country
     */
    public function setCurrencySymbol(?string $currency_symbol): Country
    {
        $this->currency_symbol = $currency_symbol;
        return $this;
    }

    /**
     * @return string
     */
    public function getFlag(): ?string
    {
        return $this->flag;
    }

    /**
     * @param string $flag
     * @return Country
     */
    public function setFlag(?string $flag): Country
    {
        $this->flag = $flag;
        return $this;
    }

    /**
     *
     */
    public function getCallingCodes()
    {
        return explode(',', $this->calling_codes);
    }

    /**
     * @param $calling_codes
     * @return Country
     */
    public function setCallingCodes($calling_codes): Country
    {
        $glued = "";

        foreach ($calling_codes as $calling_code) {
            $glued .= ", $calling_code";
        }

        $this->calling_codes = trim($glued, ", ");
        return $this;
    }

}