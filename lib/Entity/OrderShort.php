<?php

namespace Coinfide\Entity;

class OrderShort extends Base
{
    protected $validationRules = array(
        'externalOrderId' => array('type' => 'string', 'required' => false),
        'uid' => array('type' => 'string', 'max_length' => 36, 'required' => true),
        'seller' => array('type' => 'object', 'class' => '\Coinfide\Entity\Account', 'required' => true),
        'buyer' => array('type' => 'object', 'class' => '\Coinfide\Entity\Account', 'required' => true),
        'amountTotal' => array('type' => 'decimal', 'digits' => 14, 'precision' => 2, 'required' => true),
        'currencyCode' => array('type' => 'string', 'max_length' => 3, 'required' => true),
        'status' => array('type' => 'string', 'max_length' => 2, 'required' => true),
        'testOrder' => array('type' => 'boolean', 'required' => true),
        'merchantUrl' => array('type' => 'string', 'required' => false),
        'transactions' => array('type' => 'list', 'prototype' => array('type' => 'object', 'class' => '\Coinfide\Entity\Transaction', 'required' => false), 'required' => false, 'min_items' => 1)
    );

    /**
     * @var string
     */
    protected $externalOrderId;

    /**
     * @var string
     */
    protected $uid;

    /**
     * @var Account
     */
    protected $seller;

    /**
     * @var Account
     */
    protected $buyer;

    /**
     * @var float
     */
    protected $amountTotal;

    /**
     * @var string
     */
    protected $currencyCode;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var boolean
     */
    protected $testOrder;

    /**
     * @var string
     */
    protected $merchantUrl;

    /**
     * @var Transaction[]
     */
    protected $transactions;

    /**
     * @return string
     */
    public function getExternalOrderId()
    {
        return $this->externalOrderId;
    }

    /**
     * @param string $externalOrderId
     */
    public function setExternalOrderId($externalOrderId)
    {
        $this->externalOrderId = $externalOrderId;
    }

    /**
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param string $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return Account
     */
    public function getSeller()
    {
        return $this->seller;
    }

    /**
     * @param Account $seller
     */
    public function setSeller($seller)
    {
        $this->seller = $seller;
    }

    /**
     * @return Account
     */
    public function getBuyer()
    {
        return $this->buyer;
    }

    /**
     * @param Account $buyer
     */
    public function setBuyer($buyer)
    {
        $this->buyer = $buyer;
    }

    /**
     * @return float
     */
    public function getAmountTotal()
    {
        return $this->amountTotal;
    }

    /**
     * @param float $amountTotal
     */
    public function setAmountTotal($amountTotal)
    {
        $this->amountTotal = $amountTotal;
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
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return boolean
     */
    public function getTestOrder()
    {
        return $this->testOrder;
    }

    /**
     * @param boolean $testOrder
     */
    public function setTestOrder($testOrder)
    {
        $this->testOrder = $testOrder;
    }

    /**
     * @return string
     */
    public function getMerchantUrl()
    {
        return $this->merchantUrl;
    }

    /**
     * @param string $merchantUrl
     */
    public function setMerchantUrl($merchantUrl)
    {
        $this->merchantUrl = $merchantUrl;
    }

    /**
     * @return Transaction[]
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @param Transaction[] $transactions
     */
    public function setTransactions($transactions)
    {
        $this->transactions = $transactions;
    }
}
