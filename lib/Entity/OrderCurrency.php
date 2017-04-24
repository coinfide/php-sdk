<?php

namespace Coinfide\Entity;

class OrderCurrency extends Base
{
    protected $validationRules = array(
        'currencyCode' => array('type' => 'string', 'min_length' => 3, 'max_length' => 3, 'required' => true),
        'rate' => array('type' => 'decimal', 'digits' => 3, 'precision' => 3, 'required' => false),
        'amount' => array('type' => 'decimal', 'digits' => 14, 'precision' => 2, 'required' => false)
    );

    /**
     * @var string
     */
    protected $currencyCode;

    /**
     * @var float
     */
    protected $rate;

    /**
     * @var float
     */
    protected $amount;

    /**
     * OrderCurrency constructor.
     * @param string|null $currencyCode
     */
    public function __construct($currencyCode = null)
    {
        if ($currencyCode !== null) {
            $this->currencyCode = $currencyCode;
        }
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * @param string $currencyCode
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}
