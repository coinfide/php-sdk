<?php

use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

if ($_ENV['COINFIDE_USER'] == 'yourapiusername') {
    die('Please copy .env.example file to .env and fill in your Coinfide credentials');
}

$post = $_POST;

$checksum = $_POST['checksum'];

unset($post['checksum']);

if (md5(http_build_query($post) . $_ENV['COINFIDE_SECRET']) == $checksum) {
    echo 'Callback valid! You may process the order. Order data: ';
} else {
    echo 'Callback invalid! The order should not be processed. Order data';
}

print_r($post);
