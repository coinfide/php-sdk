<?php

namespace Coinfide\Example;

use Coinfide\Client;
use Coinfide\Entity\Account;
use Coinfide\Entity\Order;
use Coinfide\Entity\OrderItem;
use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

if ($_ENV['COINFIDE_USER'] == 'yourapiusername') {
    die('Please copy .env.example file to .env and fill in your Coinfide credentials');
}

\Symfony\Component\Debug\Debug::enable();

/*
 * Configure this values in your Dashboard,
 * Profile - Business details - API username and API secret key
 */
$client = new Client();
$client->setMode($_ENV['COINFIDE_MODE']);
$client->setCredentials($_ENV['COINFIDE_USER'], $_ENV['COINFIDE_PASSWORD']);

/*
 * Create order; this is a minimal amount of values needed to submit an order. For full example, consult order methods
 * or test/SerializationTest
 */
$order = new Order();

$seller = new Account();

//important!! change this to your actual e-mail, or the example will not work
$seller->setEmail('seller@coinfide.com');

$order->setSeller($seller);

$buyer = new Account();
$buyer->setEmail('buyer@coinfide.com');

$order->setBuyer($buyer);

$order->setCurrencyCode('EUR');
$order->setExternalOrderId('external_order_id');

$orderItem = new OrderItem();
$orderItem->setType('I');
$orderItem->setName('Some random goods');
$orderItem->setPriceUnit(12.34);
$orderItem->setQuantity(1.23);

$order->addOrderItem($orderItem);

$order->validate();

//change this to reflect your local server success.php url if needed
$order->setSuccessUrl((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/success.php');

/**
 * Submit order and redirect to payment form
 */
$wrappedOrder = $client->submitOrder($order);

/**
 * One of the Client::METHODS or a custom string provided by Coinfide
 */
//$wrappedOrder->setMethod('banklink');

header('Location: '.$wrappedOrder->getRedirectUrl());
