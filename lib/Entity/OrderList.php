<?php

namespace Coinfide\Entity;

class OrderList extends Base
{
    protected $validationRules = array(
        'orderList' => array('type' => 'list', 'prototype' => array('type' => 'object', 'class' => '\Coinfide\Entity\OrderShort', 'required' => false), 'required' => true, 'min_items' => 1),
    );

    /**
     * @var OrderShort[]
     */
    protected $orderList;

    /**
     * @return OrderShort[]
     */
    public function getOrderList()
    {
        return $this->orderList;
    }

    /**
     * @param OrderShort[] $orderList
     */
    public function setOrderList($orderList)
    {
        $this->orderList = $orderList;
    }
}
