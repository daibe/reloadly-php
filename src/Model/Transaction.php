<?php
namespace ReloadlyPHP\Model;

use DateTime;
use DateTimeInterface;
use Exception;
use ReloadlyPHP\Http\Response;

class Transaction
{

    /** @var $transaction_id int */
    private $transaction_id;

    /** @var $operator_transaction_id int */
    private $operator_transaction_id;

    /** @var $custom_identifier string|null */
    private $custom_identifier;

    /** @var $recipient_phone string|null */
    private $recipient_phone;

    /** @var $sender_phone string|null */
    private $sender_phone;

    /** @var $country_code string|null */
    private $country_code;

    /** @var $operator_id int */
    private $operator_id;

    /** @var $operator_name string|null */
    private $operator_name;

    /** @var $discount float */
    private $discount;

    /** @var $discount_currency_code string|null */
    private $discount_currency_code;

    /** @var $requested_amount int */
    private $requested_amount;

    /** @var $requested_amount_currency_code string|null */
    private $requested_amount_currency_code;

    /** @var $delivered_amount float */
    private $delivered_amount;

    /** @var $delivered_amount_currency_code string */
    private $delivered_amount_currency_code;

    /** @var $transaction_date DateTimeInterface */
    private $transaction_date;

    /** @var $pinDetail string|null */
    private $pinDetail;


    public static function fromResponseData($data) : ?Transaction
    {
        $transaction = new Transaction();

        foreach ($data as $key => $value) {
            $key = "set".$key;

            if (method_exists($transaction, $key)) {
                $transaction->{$key}($value);
            }
        }

        return $transaction;
    }


    public static function fromResponse(?Response $response) : ?Transaction
    {
        return ($response != null && $response->getContent() != null) ? Transaction::fromResponseData($response->getContent()) : null;
    }


    /**
     * @return int
     */
    public function getTransactionId(): int
    {
        return $this->transaction_id;
    }

    /**
     * @param int $transaction_id
     * @return Transaction
     */
    public function setTransactionId(?int $transaction_id): Transaction
    {
        $this->transaction_id = $transaction_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getOperatorTransactionId(): int
    {
        return $this->operator_transaction_id;
    }

    /**
     * @param int $operator_transaction_id
     * @return Transaction
     */
    public function setOperatorTransactionId(?int $operator_transaction_id): Transaction
    {
        $this->operator_transaction_id = $operator_transaction_id;
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
     * @return Transaction
     */
    public function setCustomIdentifier(?string $custom_identifier): Transaction
    {
        $this->custom_identifier = $custom_identifier;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRecipientPhone(): ?string
    {
        return $this->recipient_phone;
    }

    /**
     * @param string $recipient_phone
     * @return Transaction
     */
    public function setRecipientPhone(?string $recipient_phone): Transaction
    {
        $this->recipient_phone = $recipient_phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSenderPhone(): ?string
    {
        return $this->sender_phone;
    }

    /**
     * @param string $sender_phone
     * @return Transaction
     */
    public function setSenderPhone(?string $sender_phone): Transaction
    {
        $this->sender_phone = $sender_phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->country_code;
    }

    /**
     * @param string $country_code
     * @return Transaction
     */
    public function setCountryCode(?string $country_code): Transaction
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
     * @return Transaction
     */
    public function setOperatorId(?int $operator_id): Transaction
    {
        $this->operator_id = $operator_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getOperatorName(): ?string
    {
        return $this->operator_name;
    }

    /**
     * @param string $operator_name
     * @return Transaction
     */
    public function setOperatorName(?string $operator_name): Transaction
    {
        $this->operator_name = $operator_name;
        return $this;
    }

    /**
     * @return float
     */
    public function getDiscount(): float
    {
        return $this->discount;
    }

    /**
     * @param float $discount
     * @return Transaction
     */
    public function setDiscount(?float $discount): Transaction
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDiscountCurrencyCode(): ?string
    {
        return $this->discount_currency_code;
    }

    /**
     * @param string $discount_currency_code
     * @return Transaction
     */
    public function setDiscountCurrencyCode(?string $discount_currency_code): Transaction
    {
        $this->discount_currency_code = $discount_currency_code;
        return $this;
    }

    /**
     * @return int
     */
    public function getRequestedAmount(): int
    {
        return $this->requested_amount;
    }

    /**
     * @param int $requested_amount
     * @return Transaction
     */
    public function setRequestedAmount(?int $requested_amount): Transaction
    {
        $this->requested_amount = $requested_amount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRequestedAmountCurrencyCode(): ?string
    {
        return $this->requested_amount_currency_code;
    }

    /**
     * @param string $requested_amount_currency_code
     * @return Transaction
     */
    public function setRequestedAmountCurrencyCode(?string $requested_amount_currency_code): Transaction
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
     * @return Transaction
     */
    public function setDeliveredAmount(float $delivered_amount): Transaction
    {
        $this->delivered_amount = $delivered_amount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeliveredAmountCurrencyCode(): ?string
    {
        return $this->delivered_amount_currency_code;
    }

    /**
     * @param string $delivered_amount_currency_code
     * @return Transaction
     */
    public function setDeliveredAmountCurrencyCode(string $delivered_amount_currency_code): Transaction
    {
        $this->delivered_amount_currency_code = $delivered_amount_currency_code;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getTransactionDate(): DateTimeInterface
    {
        return $this->transaction_date;
    }

    /**
     * @param string $transaction_date
     * @return Transaction
     */
    public function setTransactionDate(string $transaction_date): Transaction
    {
        try {
            $this->transaction_date = new DateTime($transaction_date);
        } catch (Exception $e) {
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPinDetail(): ?string
    {
        return $this->pinDetail;
    }

    /**
     * @param string $pinDetail
     * @return Transaction
     */
    public function setPinDetail(?string $pinDetail): Transaction
    {
        $this->pinDetail = $pinDetail;
        return $this;
    }

}