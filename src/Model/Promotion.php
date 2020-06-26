<?php
namespace ReloadlyPHP\Model;

use ReloadlyPHP\Http\Response;

/**
 * Class Promotion
 * @package ReloadlyPHP\Model
 */
class Promotion
{

    /** @var $promotion_id int */
    private $promotion_id;

    /** @var $operator_id int */
    private $operator_id;

    /** @var $title string */
    private $title;

    /** @var $title2 string */
    private $title2;

    /** @var $description string */
    private $description;

    /** @var $start_date string */
    private $start_date;

    /** @var $end_date string */
    private $end_date;

    /** @var $denominations string */
    private $denominations;

    /** @var $local_denominations string */
    private $local_denominations;


    public static function fromJson($json) : ?Promotion
    {
        $promotion = new Promotion();

        foreach ($json as $key => $value) {
            $key = "set".$key;

            if (method_exists($promotion, $key)) {
                $promotion->{$key}($value);
            }
        }

        return $promotion;
    }


    public static function fromResponse(?Response $response) : ?Promotion
    {
        return ($response != null && $response->getContent() != null) ? Promotion::fromJson($response->getContent()) : null;
    }

    /**
     * @return int
     */
    public function getPromotionId(): int
    {
        return $this->promotion_id;
    }

    /**
     * @param int $promotion_id
     * @return Promotion
     */
    public function setPromotionId(int $promotion_id): Promotion
    {
        $this->promotion_id = $promotion_id;
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
     * @return Promotion
     */
    public function setOperatorId(int $operator_id): Promotion
    {
        $this->operator_id = $operator_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Promotion
     */
    public function setTitle(string $title): Promotion
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle2(): string
    {
        return $this->title2;
    }

    /**
     * @param string $title2
     * @return Promotion
     */
    public function setTitle2(string $title2): Promotion
    {
        $this->title2 = $title2;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Promotion
     */
    public function setDescription(string $description): Promotion
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->start_date;
    }

    /**
     * @param string $start_date
     * @return Promotion
     */
    public function setStartDate(string $start_date): Promotion
    {
        $this->start_date = $start_date;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndDate(): string
    {
        return $this->end_date;
    }

    /**
     * @param string $end_date
     * @return Promotion
     */
    public function setEndDate(string $end_date): Promotion
    {
        $this->end_date = $end_date;
        return $this;
    }

    /**
     * @return string
     */
    public function getDenominations(): string
    {
        return $this->denominations;
    }

    /**
     * @param string $denominations
     * @return Promotion
     */
    public function setDenominations(string $denominations): Promotion
    {
        $this->denominations = $denominations;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocalDenominations(): string
    {
        return $this->local_denominations;
    }

    /**
     * @param string $local_denominations
     * @return Promotion
     */
    public function setLocalDenominations(string $local_denominations): Promotion
    {
        $this->local_denominations = $local_denominations;
        return $this;
    }

}