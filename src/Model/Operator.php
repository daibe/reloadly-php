<?php
namespace ReloadlyPHP\Model;

use ReloadlyPHP\Http\Response;

/**
 * Class Operator
 * @package ReloadlyPHP\Model
 */
class Operator
{
    /** @var $operator_id int */
    private $operator_id;

    /** @var $name string */
    private $name;

    /** @var $bundle bool */
    private $bundle;

    /** @var $bundle bool */
    private $data;

    /** @var $pin bool */
    private $pin;

    /** @var $supportsLocalAmounts bool */
    private $supportsLocalAmounts;

    /** @var $denominationType string */
    private $denominationType;

    /** @var $senderCurrencyCode string */
    private $senderCurrencyCode;

    /** @var $senderCurrencySymbol string */
    private $senderCurrencySymbol;

    /** @var $destinationCurrencyCode string */
    private $destinationCurrencyCode;

    /** @var $commission float */
    private $commission;

    /** @var $internationalDiscount float */
    private $internationalDiscount;

    /** @var $localDiscount float */
    private $localDiscount;

    /** @var $mostPopularAmount float */
    private $mostPopularAmount;

    /** @var $minAmount float */
    private $minAmount;

    /** @var $maxAmount float */
    private $maxAmount;

    /** @var $localMinAmount float */
    private $localMinAmount;

    /** @var $localMaxAmount float */
    private $localMaxAmount;

    /** @var $country array */
    private $country;

    /** @var $fx array */
    private $fx;

    /** @var $logoUrls string */
    private $logoUrls;

    /** @var $fixedAmounts array */
    private $fixedAmounts;

    /** @var $fixedAmountsDescriptions array */
    private $fixedAmountsDescriptions;

    /** @var $localFixedAmounts array */
    private $localFixedAmounts;

    /** @var $localFixedAmountsDescriptions array */
    private $localFixedAmountsDescriptions;

    /** @var $suggestedAmountsMap array */
    private $suggestedAmountsMap;

    /** @var $promotions array */
    private $promotions;


    public static function fromJson($json) : ?Operator
    {
        $operator = new Operator();

        foreach ($json as $key => $value) {
            $key = "set".$key;

            if (method_exists($operator, $key)) {
                $operator->{$key}($value);
            }
        }

        return $operator;
    }


    public static function fromResponse(?Response $response) : ?Operator
    {
        return ($response != null && $response->getContent() != null) ? Operator::fromJson($response->getContent()) : null;
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
     * @return Operator
     */
    public function setOperatorId(int $operator_id): Operator
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
     * @return Operator
     */
    public function setName(string $name): Operator
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function isBundle(): bool
    {
        return $this->bundle;
    }

    /**
     * @param bool $bundle
     * @return Operator
     */
    public function setBundle(bool $bundle): Operator
    {
        $this->bundle = $bundle;
        return $this;
    }

    /**
     * @return bool
     */
    public function isData(): bool
    {
        return $this->data;
    }

    /**
     * @param bool $data
     * @return Operator
     */
    public function setData(bool $data): Operator
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPin(): bool
    {
        return $this->pin;
    }

    /**
     * @param bool $pin
     * @return Operator
     */
    public function setPin(?bool $pin): Operator
    {
        $this->pin = $pin;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSupportsLocalAmounts(): bool
    {
        return $this->supportsLocalAmounts;
    }

    /**
     * @param bool $supportsLocalAmounts
     * @return Operator
     */
    public function setSupportsLocalAmounts(bool $supportsLocalAmounts): Operator
    {
        $this->supportsLocalAmounts = $supportsLocalAmounts;
        return $this;
    }

    /**
     * @return string
     */
    public function getDenominationType(): string
    {
        return $this->denominationType;
    }

    /**
     * @param string $denominationType
     * @return Operator
     */
    public function setDenominationType(?string $denominationType): Operator
    {
        $this->denominationType = $denominationType;
        return $this;
    }

    /**
     * @return string
     */
    public function getSenderCurrencyCode(): string
    {
        return $this->senderCurrencyCode;
    }

    /**
     * @param string $senderCurrencyCode
     * @return Operator
     */
    public function setSenderCurrencyCode(?string $senderCurrencyCode): Operator
    {
        $this->senderCurrencyCode = $senderCurrencyCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getSenderCurrencySymbol(): string
    {
        return $this->senderCurrencySymbol;
    }

    /**
     * @param string $senderCurrencySymbol
     * @return Operator
     */
    public function setSenderCurrencySymbol(?string $senderCurrencySymbol): Operator
    {
        $this->senderCurrencySymbol = $senderCurrencySymbol;
        return $this;
    }

    /**
     * @return string
     */
    public function getDestinationCurrencyCode(): string
    {
        return $this->destinationCurrencyCode;
    }

    /**
     * @param string $destinationCurrencyCode
     * @return Operator
     */
    public function setDestinationCurrencyCode(?string $destinationCurrencyCode): Operator
    {
        $this->destinationCurrencyCode = $destinationCurrencyCode;
        return $this;
    }

    /**
     * @return float
     */
    public function getCommission(): ?float
    {
        return $this->commission;
    }

    /**
     * @param float $commission
     * @return Operator
     */
    public function setCommission(?float $commission): Operator
    {
        $this->commission = $commission;
        return $this;
    }

    /**
     * @return float
     */
    public function getInternationalDiscount(): ?float
    {
        return $this->internationalDiscount;
    }

    /**
     * @param float $internationalDiscount
     * @return Operator
     */
    public function setInternationalDiscount(?float $internationalDiscount): Operator
    {
        $this->internationalDiscount = $internationalDiscount;
        return $this;
    }

    /**
     * @return float
     */
    public function getLocalDiscount(): ?float
    {
        return $this->localDiscount;
    }

    /**
     * @param float $localDiscount
     * @return Operator
     */
    public function setLocalDiscount(?float $localDiscount): Operator
    {
        $this->localDiscount = $localDiscount;
        return $this;
    }

    /**
     * @return float
     */
    public function getMostPopularAmount(): ?float
    {
        return $this->mostPopularAmount;
    }

    /**
     * @param float $mostPopularAmount
     * @return Operator
     */
    public function setMostPopularAmount(?float $mostPopularAmount): Operator
    {
        $this->mostPopularAmount = $mostPopularAmount;
        return $this;
    }

    /**
     * @return float
     */
    public function getMinAmount(): ?float
    {
        return $this->minAmount;
    }

    /**
     * @param float $minAmount
     * @return Operator
     */
    public function setMinAmount(?float $minAmount): Operator
    {
        $this->minAmount = $minAmount;
        return $this;
    }

    /**
     * @return float
     */
    public function getMaxAmount(): ?float
    {
        return $this->maxAmount;
    }

    /**
     * @param float $maxAmount
     * @return Operator
     */
    public function setMaxAmount(?float $maxAmount): Operator
    {
        $this->maxAmount = $maxAmount;
        return $this;
    }

    /**
     * @return float
     */
    public function getLocalMinAmount(): ?float
    {
        return $this->localMinAmount;
    }

    /**
     * @param float $localMinAmount
     * @return Operator
     */
    public function setLocalMinAmount(?float $localMinAmount): Operator
    {
        $this->localMinAmount = $localMinAmount;
        return $this;
    }

    /**
     * @return float
     */
    public function getLocalMaxAmount(): ?float
    {
        return $this->localMaxAmount;
    }

    /**
     * @param float $localMaxAmount
     * @return Operator
     */
    public function setLocalMaxAmount(?float $localMaxAmount): Operator
    {
        $this->localMaxAmount = $localMaxAmount;
        return $this;
    }

    /**
     * @return array
     */
    public function getCountry(): array
    {
        return $this->country;
    }

    /**
     * @param $country
     * @return Operator
     */
    public function setCountry($country): Operator
    {
        $_country = json_encode($country);
        $this->country = json_decode($_country, true);
        return $this;
    }

    /**
     * @return array
     */
    public function getFx(): ?array
    {
        return $this->fx;
    }

    /**
     * @param array $fx
     * @return Operator
     */
    public function setFx($fx): Operator
    {
        $_fx = json_encode($fx);
        $this->fx = json_decode($_fx, true);
        return $this;
    }

    /**
     * @return string
     */
    public function getLogoUrls(): string
    {
        return $this->logoUrls;
    }

    /**
     * @param string $logoUrls
     * @return Operator
     */
    public function setLogoUrls($logoUrls): Operator
    {
        $this->logoUrls = json_encode($logoUrls);
        return $this;
    }

    /**
     * @return array
     */
    public function getFixedAmounts(): array
    {
        return $this->fixedAmounts;
    }

    /**
     * @param array $fixedAmounts
     * @return Operator
     */
    public function setFixedAmounts($fixedAmounts): Operator
    {
        $_fixedAmounts = json_encode($fixedAmounts);
        $this->fixedAmounts = json_decode($_fixedAmounts);
        return $this;
    }

    /**
     * @return array
     */
    public function getFixedAmountsDescriptions(): array
    {
        return $this->fixedAmountsDescriptions;
    }

    /**
     * @param array $fixedAmountsDescriptions
     * @return Operator
     */
    public function setFixedAmountsDescriptions($fixedAmountsDescriptions): Operator
    {
        $_fixedAmountsDescriptions = json_encode($fixedAmountsDescriptions);
        $this->fixedAmountsDescriptions = json_decode($_fixedAmountsDescriptions);
        return $this;
    }

    /**
     * @return array
     */
    public function getLocalFixedAmounts(): ?array
    {
        return $this->localFixedAmounts;
    }

    /**
     * @param array $localFixedAmounts
     * @return Operator
     */
    public function setLocalFixedAmounts($localFixedAmounts): Operator
    {
        $_localFixedAmounts = json_encode($localFixedAmounts);
        $this->localFixedAmounts = json_decode($_localFixedAmounts);
        return $this;
    }

    /**
     * @return array
     */
    public function getLocalFixedAmountsDescriptions(): ?array
    {
        return $this->localFixedAmountsDescriptions;
    }

    /**
     * @param array $localFixedAmountsDescriptions
     * @return Operator
     */
    public function setLocalFixedAmountsDescriptions($localFixedAmountsDescriptions): Operator
    {
        $_localFixedAmountsDescriptions = json_encode($localFixedAmountsDescriptions);
        $this->localFixedAmountsDescriptions = json_decode($_localFixedAmountsDescriptions);
        return $this;
    }

    /**
     * @return array
     */
    public function getSuggestedAmountsMap(): ?array
    {
        return $this->suggestedAmountsMap;
    }

    /**
     * @param array $suggestedAmountsMap
     * @return Operator
     */
    public function setSuggestedAmountsMap($suggestedAmountsMap): Operator
    {
        $_suggestedAmountsMap = json_encode($suggestedAmountsMap);
        $this->localFixedAmountsDescriptions = json_decode($_suggestedAmountsMap);
        return $this;
    }

    /**
     * @return array
     */
    public function getPromotions(): ?array
    {
        return $this->promotions;
    }

    /**
     * @param array $promotions
     * @return Operator
     */
    public function setPromotions($promotions): Operator
    {
        $this->promotions = $promotions;
        $_promotions = json_encode($promotions);
        $this->localFixedAmountsDescriptions = json_decode($_promotions);
        return $this;
    }

}