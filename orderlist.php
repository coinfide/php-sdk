<?php

namespace Coinfide\Example;

use Coinfide\Client;
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

$orders = $client->orderList('20160101000000', '20161231000000');

print 'Dumping all orders ('.count($orders->getOrderList()).'):'.PHP_EOL;

print json_encode($orders->toArray(), JSON_PRETTY_PRINT).PHP_EOL;

if (!count($orders->getOrderList())) {
    print 'Please provide at least some orders to continue'.PHP_EOL;
} else {
    print 'Fetching order by uid'.PHP_EOL;

    $order = $client->orderDetailsByUid($orders->getOrderList()[0]->getUid());

    print json_encode($order->toArray(), JSON_PRETTY_PRINT).PHP_EOL;

    $externalFound = false;

    foreach ($orders->getOrderList() as $order) {
        if ($order->getExternalOrderId()) {
            $externalFound = true;

            print 'Fetching order by externalOrderId'.PHP_EOL;

            $order = $client->orderDetailsByExternalOrderId($order->getExternalOrderId());

            print json_encode($order->toArray(), JSON_PRETTY_PRINT).PHP_EOL;

            break;
        }
    }

    if (!$externalFound) {
        print 'No order with ExternalOrderId found'.PHP_EOL;
    }
}
