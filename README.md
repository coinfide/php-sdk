# Coinfide integration generic PHP SDK

## Installation 

Require it with Composer ```composer require confide/php-sdk dev-master```.

## Running

Basically, all parameters are passed to ```Coinfide\Client``` constructor. Supported parameters are:

* ```sslOptions```: array of [curl](http://php.net/manual/en/function.curl-setopt.php) options to pass to the client;
* ```trace```: passing ```'trace' => true``` dumps all requests (made and received) to console.

## Examples

Copy ```.env.example``` to ```.env``` and run the tests or examples. The following examples are included:

* ```example.php``` - example order creation, and redirection to payment form;
* ```callback.php``` - example callback processing;
* ```orderlist.php``` - getting list of orders, fetching order details;
* ```refund.php``` - payment refund;
* ```status.php``` - changing order status (cancelling order).


## Further reading

Read full documentation in the [wiki](https://github.com/coinfide/documentation/wiki)
