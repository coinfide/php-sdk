<?php

namespace Coinfide\Entity;

class OrderStatus extends Base
{
    protected $validationRules = array(
        'order' => array('type' => 'object', 'class' => '\Coinfide\Entity\Order', 'required' => true),
        'redirectUrl' => array('type' => 'string', 'required' => false)
    );

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var string
     */
    protected $redirectUrl;

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
        return $this->redirectUrl;
    }

    /**
     * @param string $redirectUrl
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

}
