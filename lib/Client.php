<?php

namespace Coinfide;

use Coinfide\Entity\Order;
use Coinfide\Entity\OrderList;
use Coinfide\Entity\OrderStatus;
use Coinfide\Entity\Token;
use Coinfide\Entity\WrappedOrder;

class Client
{
    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var Token
     */
    protected $token;

    /**
     * @var integer
     */
    protected $tokenFetchTime;

    /**
     * @var array
     */
    protected $options;

    public function __construct($options = array())
    {
        $this->options = array_merge(array(
            'trace' => false,
            //magic: CURL_SSLVERSION_TLSv1 = 1, but the constant is not present in many distrubutions till 5.5
            'sslOptions' => array(CURLOPT_SSLVERSION => 1)
        ), $options);
    }

    public function setMode($mode)
    {
        if ($mode == 'demo') {
            $this->endpoint = 'https://demo-paymentapi.coinfide.com/paymentapi/';
        } elseif ($mode == 'prod') {
            $this->endpoint = 'https://paymentapi.coinfide.com/paymentapi/';
        } else {
            throw new CoinfideException(sprintf('Client mode "%s" unknown', $mode));
        }
    }

    public function setCredentials($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function orderStatus($uid, $status)
    {
        $token = $this->getToken();

        $statuses = array('SE', 'DE', 'MP', 'CA');

        if (!in_array($status, $statuses)) {
            throw new \Exception(sprintf('New order status must be one of "%s"', $statuses));
        }

        $response = $this->request('order/status', array('uid' => $uid, 'status' => $status), $token->getAccessToken());

        $orderList = new OrderStatus();

        $orderList->fromArray($response);
        $orderList->validate();

        return $orderList;
    }

    public function orderDetailsByUid($uid)
    {
        $token = $this->getToken();

        $params = array('uid' => $uid);

        $response = $this->request('order/details', $params, $token->getAccessToken());

        $orderList = new OrderList();

        $orderList->fromArray($response);
        $orderList->validate();

        return $orderList;
    }

    public function orderDetailsByExternalOrderId($externalOrderId)
    {
        $token = $this->getToken();

        $params = array('externalOrderId' => $externalOrderId);

        $response = $this->request('order/details', $params, $token->getAccessToken());

        $orderList = new OrderList();

        $orderList->fromArray($response);
        $orderList->validate();

        return $orderList;
    }

    public function orderList($dateFrom, $dateTo)
    {
        $token = $this->getToken();

        $response = $this->request('order/list', array('dateFrom'=> $dateFrom, 'dateTo' => $dateTo), $token->getAccessToken());

        $orderList = new OrderList();

        $orderList->fromArray($response);
        $orderList->validate();

        return $orderList;
    }

    public function getToken()
    {
        if (!$this->token || $this->token->getExpiresIn() + $this->tokenFetchTime < time()) {
            //fetch new token. Do not refresh (yet) since PHP follows request-reponse model and does not have any
            //persistent storage by default
            if (!$this->username || !$this->password) {
                throw new CoinfideException('Please call "setCredentials" and provide your credentials');
            }

            $response = $this->request('auth/token', array('username' => $this->username, 'password' => $this->password));

            $token = new Token();
            $token->fromArray($response);

            return $this->token = $token;
        }

        return $this->token;
    }

    public function submitOrder(Order $order)
    {
        $token = $this->getToken();

        $response = $this->request('order/create', array('order' => $order->toArray()), $token->getAccessToken());

        $wrappedOrder = new WrappedOrder();

        $wrappedOrder->fromArray($response);
        $wrappedOrder->validate();

        return $wrappedOrder;
    }

    public function refund($orderId, $amount)
    {
        $token = $this->getToken();

        $response = $this->request(
            'order/refund',
            array('orderId' => $orderId, 'amount' => $amount),
            $token->getAccessToken()
        );

        $order = new Order();
        $order->fromArray($response['order']);
        $order->validate();

        return $order;
    }

    public function request($path, $data, $token = '')
    {
        if (!$this->endpoint) {
            throw new CoinfideException('No endpoint set, call "setMode" first');
        }

        if ($this->options['trace']) {
            print '--> DEBUG PATH '.$path.PHP_EOL;
            print '--> DEBUG SENT JSON START'.PHP_EOL;
            print json_encode($data, JSON_PRETTY_PRINT).PHP_EOL;
            print '--> DEBUG SENT JSON END'.PHP_EOL;
        }

        $curl = curl_init($this->endpoint . $path);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        curl_setopt_array($curl, $this->options['sslOptions']);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(sprintf('Authorization: Basic %s', $token), 'Content-Type: application/json'));

        $result = curl_exec($curl);

        $error = curl_errno($curl);

        if ($error) {
            throw new CoinfideException(sprintf('CURL error %d: %s', $error, curl_error($curl)));
        }

        if ($this->options['trace']) {
            print '--> DEBUG RECEIVED RESULT START'.PHP_EOL;
            print $result.PHP_EOL;
            print '--> DEBUG RECEIVED RESULT END'.PHP_EOL;
        }

        $decoded = json_decode($result, true);
        
        if ($decoded === null) {
            throw new CoinfideException('Received JSON is not decodable');
        }

        if ($this->options['trace']) {
            print '--> DEBUG RECEIVED JSON START'.PHP_EOL;
            print json_encode($decoded, JSON_PRETTY_PRINT).PHP_EOL;
            print '--> DEBUG RECEIVED JSON END'.PHP_EOL;
        }

        if (isset($decoded['errorData'])) {
            $message = $decoded['errorData']['errorMessage'];

            if (
                isset($decoded['errorData']['parameters']) &&
                is_array($decoded['errorData']['parameters']) &&
                count(array_filter($decoded['errorData']['parameters'], 'is_scalar')) != 0
            ) {
                $message = $message . ': ' . implode(', ', array_filter($decoded['errorData']['parameters'], 'is_scalar'));
            }

            throw new CoinfideException($message, $decoded['errorData']['errorCode']);
        }

        return $decoded;
    }
}
