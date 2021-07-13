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

    /** @var $pin_details string|null */
    private $pin_details;

    /** @var $recipient_email string|null */
    private $recipient_email;

    /** @var $balance_info array */
    private $balance_info;

    public static function fromResponseData($data) : ?TopUpResponse
    {

        $topUpResponse = (new TopUpResponse())
            ->setTransactionId($data->transactionId)
            ->setCustomIdentifier($data->customIdentifier)
            ->setRecipientPhone($data->recipientPhone)
            ->setRecipientEmail($data->recipientEmail)
            ->setSenderPhone($data->senderPhone)
            ->setOperatorId($data->operatorId)
            ->setOperatorName($data->operatorName)
            ->setOperatorTransactionId($data->operatorTransactionId)
            ->setCountryCode($data->countryCode)
            ->setDiscount($data->discount)
            ->setDiscountCurrencyCode($data->discountCurrencyCode)
            ->setRequestedAmount($data->requestedAmount)
            ->setRequestedAmountCurrencyCode($data->requestedAmountCurrencyCode)
            ->setDeliveredAmount($data->deliveredAmount)
            ->setDeliveredAmountCurrencyCode($data->deliveredAmountCurrencyCode)
            ->setTransactionDate($data->transactionDate)
            ->setPinDetails($data->pinDetail)
            ->setBalanceInfo($data->balanceInfo);

        return $topUpResponse;
    }


    public static function fromResponse(?Response $response) : ?TopUpResponse
    {
        return ($response != null && $response->getContent() != null)
                ? TopUpResponse::fromResponseData($response->getContent())
                : null;
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
     * @return string
     */
    public function getOperatorTransactionId(): string
    {
        return $this->operatorTransactionId;
    }

    /**
     * @param string $operatorTransactionId
     * @return TopUpResponse
     */
    public function setOperatorTransactionId(?string $operatorTransactionId): TopUpResponse
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
     * @param string $customIdentifier
     * @return TopUpResponse
     */
    public function setCustomIdentifier(string $customIdentifier): TopUpResponse
    {
        $this->custom_identifier = $customIdentifier;
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
     * @param string|null $recipientPhone
     * @return TopUpResponse
     */
    public function setRecipientPhone(?string $recipientPhone): TopUpResponse
    {
        $this->recipient_phone = $recipientPhone;
        return $this;
    }

    /**
     * @return string
     */
    public function getRecipientEmail(): string
    {
        return $this->recipient_email;
    }

    /**
     * @param string|null $recipientEmail
     * @return TopUpResponse
     */
    public function setRecipientEmail(?string $recipientEmail): TopUpResponse
    {
        $this->recipient_email = $recipientEmail;
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
     * @param string $senderPhone
     * @return TopUpResponse
     */
    public function setSenderPhone(string $senderPhone): TopUpResponse
    {
        $this->sender_phone = $senderPhone;
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
     * @param string $countryCode
     * @return TopUpResponse
     */
    public function setCountryCode(string $countryCode): TopUpResponse
    {
        $this->country_code = $countryCode;
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
     * @param int $operatorId
     * @return TopUpResponse
     */
    public function setOperatorId(int $operatorId): TopUpResponse
    {
        $this->operator_id = $operatorId;
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
     * @param string $operatorName
     * @return TopUpResponse
     */
    public function setOperatorName(string $operatorName): TopUpResponse
    {
        $this->operator_name = $operatorName;
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
     * @param string $discountCurrencyCode
     * @return TopUpResponse
     */
    public function setDiscountCurrencyCode(?string $discountCurrencyCode): TopUpResponse
    {
        $this->discount_currency_code = $discountCurrencyCode;
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
     * @param float $requestedAmount
     * @return TopUpResponse
     */
    public function setRequestedAmount(?float $requestedAmount): TopUpResponse
    {
        $this->requested_amount = $requestedAmount;
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
     * @param string $requestedAmountCurrencyCode
     * @return TopUpResponse
     */
    public function setRequestedAmountCurrencyCode(?string $requestedAmountCurrencyCode): TopUpResponse
    {
        $this->requested_amount_currency_code = $requestedAmountCurrencyCode;
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
     * @param float $deliveredAmount
     * @return TopUpResponse
     */
    public function setDeliveredAmount(?float $deliveredAmount): TopUpResponse
    {
        $this->delivered_amount = $deliveredAmount;
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
     * @param string $deliveredAmountCurrencyCode
     * @return TopUpResponse
     */
    public function setDeliveredAmountCurrencyCode(?string $deliveredAmountCurrencyCode): TopUpResponse
    {
        $this->delivered_amount_currency_code = $deliveredAmountCurrencyCode;
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
     * @param string $transactionDate
     * @return TopUpResponse
     */
    public function setTransactionDate(string $transactionDate): TopUpResponse
    {
        $this->transaction_date = $transactionDate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPinDetails(): ?string
    {
        return $this->pin_details;
    }

    /**
     * @param string|null $pinDetails
     * @return TopUpResponse
     */
    public function setPinDetails(?string $pinDetails): TopUpResponse
    {
        $this->pin_details = $pinDetails;
        return $this;
    }

    /**
     * @return array
     */
    public function getBalanceInfo(): ?array
    {
        return $this->balance_info;
    }

    /**
     * @param array $balanceInfo
     * @return TopUpResponse
     */
    public function setBalanceInfo($balanceInfo): TopUpResponse
    {
        $_balanceInfo = json_encode($balanceInfo);
        $this->balance_info = json_decode($_balanceInfo, true);
        return $this;
    }


}