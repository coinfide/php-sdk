<?php

namespace Coinfide\Entity;

class Order extends Base
{
    protected $validationRules = array(
        'uid' => array('type' => 'string', 'max_length' => 36, 'required' => false),
        'status' => array('type' => 'string', 'max_length' => 2, 'required' => false),
        'seller' => array('type' => 'object', 'class' => '\Coinfide\Entity\Account', 'required' => true),
        'buyer' => array('type' => 'object', 'class' => '\Coinfide\Entity\Account', 'required' => true),
        'currencyCode' => array('type' => 'string', 'max_length' => 3, 'required' => true),
        'discountAmount' => array('type' => 'decimal', 'digits' => 14, 'precision' => 2, 'required' => false),
        'discountPercent' => array('type' => 'decimal', 'digits' => 14, 'precision' => 2, 'required' => false),
        'amountTotal' => array('type' => 'decimal', 'digits' => 14, 'precision' => 2, 'required' => false),
        'issueDate' => array('type' => 'date', 'required' => false),
        'dueDate' => array('type' => 'date', 'required' => false),
        'externalOrderId' => array('type' => 'string', 'required' => false),
        'reference' => array('type' => 'string', 'required' => false),
        'note' => array('type' => 'string', 'required' => false),
        'terms' => array('type' => 'string', 'required' => false),
        'provisionChannel' => array('type' => 'string', 'max_length' => 6, 'required' => false),
        'affiliateInfo' => array('type' => 'object', 'class' => '\Coinfide\Entity\AffiliateInfo', 'required' => false),
        'acceptPaymentsIfOrderExpired' => array('type' => 'boolean', 'required' => false),
        'taxBeforeDiscount' => array('type' => 'boolean', 'required' => false),
        'taxInclusive' => array('type' => 'boolean', 'required' => false),
        'paymentPageUrl' => array('type' => 'string', 'required' => false),
        'successUrl' => array('type' => 'string', 'required' => false),
        'failUrl' => array('type' => 'string', 'required' => false),
        'orderItems' => array('type' => 'list', 'prototype' => array('type' => 'object', 'class' => '\Coinfide\Entity\OrderItem', 'required' => false), 'required' => true, 'min_items' => 1),
        'shippingAddress' => array('type' => 'object', 'class' => '\Coinfide\Entity\Address', 'required' => false)
    );

    /**
     * @var string
     */
    protected $uid;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var Account
     */
    protected $seller;

    /**
     * @var Account
     */
    protected $buyer;

    /**
     * @var string
     */
    protected $currencyCode;

    /**
     * @var float
     */
    protected $discountAmount;

    /**
     * @var float
     */
    protected $discountPercent;

    /**
     * @var float
     */
    protected $amountTotal;

    /**
     * @var string
     */
    protected $issueDate;

    /**
     * @var string
     */
    protected $dueDate;

    /**
     * @var string
     */
    protected $externalOrderId;

    /**
     * @var string
     */
    protected $reference;

    /**
     * @var string
     */
    protected $note;

    /**
     * @var string
     */
    protected $terms;

    /**
     * @var string
     */
    protected $provisionChannel;

    /**
     * @var AffiliateInfo
     */
    protected $affiliateInfo;

    /**
     * @var bool
     */
    protected $acceptPaymentsIfOrderExpired;

    /**
     * @var bool
     */
    protected $taxBeforeDiscount;

    /**
     * @var bool
     */
    protected $taxInclusive;

    /**
     * @var string
     */
    protected $paymentPageUrl;

    /**
     * @var string
     */
    protected $successUrl;

    /**
     * @var string
     */
    protected $failUrl;

    /**
     * @var OrderItem[]
     */
    protected $orderItems;

    /**
     * @var Address
     */
    protected $shippingAddress;
    
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
    public function getDiscountAmount()
    {
        return $this->discountAmount;
    }

    /**
     * @param float $discountAmount
     */
    public function setDiscountAmount($discountAmount)
    {
        $this->discountAmount = $discountAmount;
    }

    /**
     * @return float
     */
    public function getDiscountPercent()
    {
        return $this->discountPercent;
    }

    /**
     * @param float $discountPercent
     */
    public function setDiscountPercent($discountPercent)
    {
        $this->discountPercent = $discountPercent;
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
    public function getIssueDate()
    {
        return $this->issueDate;
    }

    /**
     * @param string $issueDate
     */
    public function setIssueDate($issueDate)
    {
        $this->issueDate = $issueDate;
    }

    /**
     * @return string
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param string $dueDate
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
    }

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
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return string
     */
    public function getTerms()
    {
        return $this->terms;
    }

    /**
     * @param string $terms
     */
    public function setTerms($terms)
    {
        $this->terms = $terms;
    }

    /**
     * @return string
     */
    public function getProvisionChannel()
    {
        return $this->provisionChannel;
    }

    /**
     * @param string $provisionChannel
     */
    public function setProvisionChannel($provisionChannel)
    {
        $this->provisionChannel = $provisionChannel;
    }

    /**
     * @return AffiliateInfo
     */
    public function getAffiliateInfo()
    {
        return $this->affiliateInfo;
    }

    /**
     * @param AffiliateInfo $affiliateInfo
     */
    public function setAffiliateInfo($affiliateInfo)
    {
        $this->affiliateInfo = $affiliateInfo;
    }

    /**
     * @return boolean
     */
    public function getAcceptPaymentsIfOrderExpired()
    {
        return $this->acceptPaymentsIfOrderExpired;
    }

    /**
     * @param boolean $acceptPaymentsIfOrderExpired
     */
    public function setAcceptPaymentsIfOrderExpired($acceptPaymentsIfOrderExpired)
    {
        $this->acceptPaymentsIfOrderExpired = $acceptPaymentsIfOrderExpired;
    }

    /**
     * @return boolean
     */
    public function getTaxBeforeDiscount()
    {
        return $this->taxBeforeDiscount;
    }

    /**
     * @param boolean $taxBeforeDiscount
     */
    public function setTaxBeforeDiscount($taxBeforeDiscount)
    {
        $this->taxBeforeDiscount = $taxBeforeDiscount;
    }

    /**
     * @return boolean
     */
    public function getTaxInclusive()
    {
        return $this->taxInclusive;
    }

    /**
     * @param boolean $taxInclusive
     */
    public function setTaxInclusive($taxInclusive)
    {
        $this->taxInclusive = $taxInclusive;
    }

    /**
     * @return string
     */
    public function getPaymentPageUrl()
    {
        return $this->paymentPageUrl;
    }

    /**
     * @param string $paymentPageUrl
     */
    public function setPaymentPageUrl($paymentPageUrl)
    {
        $this->paymentPageUrl = $paymentPageUrl;
    }

    /**
     * @return string
     */
    public function getSuccessUrl()
    {
        return $this->successUrl;
    }

    /**
     * @param string $successUrl
     */
    public function setSuccessUrl($successUrl)
    {
        $this->successUrl = $successUrl;
    }

    /**
     * @return string
     */
    public function getFailUrl()
    {
        return $this->failUrl;
    }

    /**
     * @param string $failUrl
     */
    public function setFailUrl($failUrl)
    {
        $this->failUrl = $failUrl;
    }

    /**
     * @return OrderItem[]
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }

    /**
     * @param OrderItem[] $orderItems
     */
    public function setOrderItems($orderItems)
    {
        $this->orderItems = $orderItems;
    }

    /**
     * @param OrderItem $orderItem
     */
    public function addOrderItem($orderItem)
    {
        $this->orderItems[] = $orderItem;
    }

    /**
     * @return Address
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @param Address $shippingAddress
     */
    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }
}
