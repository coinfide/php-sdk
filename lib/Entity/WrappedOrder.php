<?php

namespace Coinfide\Entity;

class WrappedOrder extends Base
{
    protected $validationRules = array(
        'order' => array('type' => 'object', 'class' => '\Coinfide\Entity\Order', 'required' => true),
        'redirectUrl' => array('type' => 'string', 'required' => true)
    );

    /**
     * @var string
     */
    protected $orderId;

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var string
     */
    protected $redirectUrl;

    /**
     * @var string
     */
    protected $method = null;

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl . ($this->method ? '&method='.$this->method : '');
    }

    /**
     * @param string $redirectUrl
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

}
