<?php

$classes = [
    'CoinfideException',
    'Entity\Base',
    'Entity\Account',
    'Entity\Address',
    'Entity\AffiliateInfo',
    'Entity\Callback',
    'Entity\Order',
    'Entity\OrderItem',
    'Entity\OrderCurrency',
    'Entity\OrderList',
    'Entity\OrderShort',
    'Entity\OrderStatus',
    'Entity\Parameter',
    'Entity\Phone',
    'Entity\Tax',
    'Entity\Token',
    'Entity\Transaction',
    'Entity\WrappedOrder',
    'Client',
];

$combined = [];

foreach ($classes as $class) {
    $code = file_get_contents(__DIR__.'/lib/'.str_replace('\\', '/', $class).'.php');

    $code = str_replace('<?php', '', $code);

    $code = preg_replace('/namespace([^;]+);/', 'namespace $1 {', $code);

    $code = $code . '}';

    $combined[] = $code;
}

$combined = '<?php'.PHP_EOL.PHP_EOL.implode(PHP_EOL, $combined).PHP_EOL;

file_put_contents(__DIR__.'/combined.php', $combined);