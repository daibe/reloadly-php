<?php
namespace ReloadlyPHP\Model;

use ReloadlyPHP\Http\Response;

class TopUpResponse
{

    /** @var $transaction_id int */
    private $transactionId;

    /** @var $operator_transaction_id int */
    private $operatorTransactionId;

    /** @var $custom_identifier string|null */
    private $custom_identifier;
    /** @var $recipient_phone string */
    private $recipient_phone;

    /** @var $sender_phone string */
    private $sender_phone;

    /** @var $country_code string */
    private $country_code;

    /** @var $operator_id int */
    private $operator_id;

    /** @var $operator_name string */
    private $operator_name;

    /** @var $discount string|null */
    private $discount;

    /** @var $discount_currency_code string */
    private $discount_currency_code;

    /** @var $requested_amount float */
    private $requested_amount;

    /** @var $requested_amount_currency_code string */
    private $requested_amount_currency_code;

    /** @var $delivered_amount float */
    private $delivered_amount;

    /** @var $delivered_amount_currency_code string */
    private $delivered_amount_currency_code;

    /** @var $transaction_date string */
    private $transaction_date;

    /** @var $pin_detail string|null */
    private $pin_detail;

    public static function fromResponseData($data) : ?TopUpResponse
    {
        $topUpResponse = new TopUpResponse();

        foreach ($data as $key => $value) {
            $key = "set".$key;

            if (method_exists($topUpResponse, $key)) {
                $topUpResponse->{$key}($value);
            }
        }

        return $topUpResponse;
    }


    public static function fromResponse(?Response $response) : ?TopUpResponse
    {
        return ($response != null && $response->getContent() != null) ? TopUpResponse::fromResponseData($response->getContent()) : null;
    }


    /**
     * @return int
     */
    public function getTransactionId(): int
    {
        return $this->transactionId;
    }

    /**
     * @param int $transactionId
     * @return TopUpResponse
     */
    public function setTransactionId(int $transactionId): TopUpResponse
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    /**
     * @return int
     */
    public function getOperatorTransactionId(): int
    {
        return $this->operatorTransactionId;
    }

    /**
     * @param int $operatorTransactionId
     * @return TopUpResponse
     */
    public function setOperatorTransactionId(?int $operatorTransactionId): TopUpResponse
    {
        $this->operatorTransactionId = $operatorTransactionId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomIdentifier(): ?string
    {
        return $this->custom_identifier;
    }

    /**
     * @param string $custom_identifier
     * @return TopUpResponse
     */
    public function setCustomIdentifier(string $custom_identifier): TopUpResponse
    {
        $this->custom_identifier = $custom_identifier;
        return $this;
    }

    /**
     * @return string
     */
    public function getRecipientPhone(): string
    {
        return $this->recipient_phone;
    }

    /**
     * @param string $recipient_phone
     * @return TopUpResponse
     */
    public function setRecipientPhone(string $recipient_phone): TopUpResponse
    {
        $this->recipient_phone = $recipient_phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getSenderPhone(): string
    {
        return $this->sender_phone;
    }

    /**
     * @param string $sender_phone
     * @return TopUpResponse
     */
    public function setSenderPhone(string $sender_phone): TopUpResponse
    {
        $this->sender_phone = $sender_phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->country_code;
    }

    /**
     * @param string $country_code
     * @return TopUpResponse
     */
    public function setCountryCode(string $country_code): TopUpResponse
    {
        $this->country_code = $country_code;
        return $this;
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
     * @return TopUpResponse
     */
    public function setOperatorId(int $operator_id): TopUpResponse
    {
        $this->operator_id = $operator_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getOperatorName(): string
    {
        return $this->operator_name;
    }

    /**
     * @param string $operator_name
     * @return TopUpResponse
     */
    public function setOperatorName(string $operator_name): TopUpResponse
    {
        $this->operator_name = $operator_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDiscount(): string
    {
        return $this->discount;
    }

    /**
     * @param string $discount
     * @return TopUpResponse
     */
    public function setDiscount(string $discount): TopUpResponse
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return string
     */
    public function getDiscountCurrencyCode(): string
    {
        return $this->discount_currency_code;
    }

    /**
     * @param string $discount_currency_code
     * @return TopUpResponse
     */
    public function setDiscountCurrencyCode(string $discount_currency_code): TopUpResponse
    {
        $this->discount_currency_code = $discount_currency_code;
        return $this;
    }

    /**
     * @return float
     */
    public function getRequestedAmount(): float
    {
        return $this->requested_amount;
    }

    /**
     * @param float $requested_amount
     * @return TopUpResponse
     */
    public function setRequestedAmount(float $requested_amount): TopUpResponse
    {
        $this->requested_amount = $requested_amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getRequestedAmountCurrencyCode(): string
    {
        return $this->requested_amount_currency_code;
    }

    /**
     * @param string $requested_amount_currency_code
     * @return TopUpResponse
     */
    public function setRequestedAmountCurrencyCode(string $requested_amount_currency_code): TopUpResponse
    {
        $this->requested_amount_currency_code = $requested_amount_currency_code;
        return $this;
    }

    /**
     * @return float
     */
    public function getDeliveredAmount(): float
    {
        return $this->delivered_amount;
    }

    /**
     * @param float $delivered_amount
     * @return TopUpResponse
     */
    public function setDeliveredAmount(float $delivered_amount): TopUpResponse
    {
        $this->delivered_amount = $delivered_amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getDeliveredAmountCurrencyCode(): string
    {
        return $this->delivered_amount_currency_code;
    }

    /**
     * @param string $delivered_amount_currency_code
     * @return TopUpResponse
     */
    public function setDeliveredAmountCurrencyCode(string $delivered_amount_currency_code): TopUpResponse
    {
        $this->delivered_amount_currency_code = $delivered_amount_currency_code;
        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionDate(): string
    {
        return $this->transaction_date;
    }

    /**
     * @param string $transaction_date
     * @return TopUpResponse
     */
    public function setTransactionDate(string $transaction_date): TopUpResponse
    {
        $this->transaction_date = $transaction_date;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPinDetail(): ?string
    {
        return $this->pin_detail;
    }

    /**
     * @param string $pin_detail
     * @return TopUpResponse
     */
    public function setPinDetail(?string $pin_detail): TopUpResponse
    {
        $this->pin_detail = $pin_detail;
        return $this;
    }


}