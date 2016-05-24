<?php

namespace Coinfide;

use Coinfide\Entity\Order;
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
    protected $sslOptions;

    public function __construct($sslOptions = [])
    {
        $this->sslOptions = $sslOptions;
    }

    public function setMode($mode)
    {
        if ($mode == 'demo') {
            $this->endpoint = 'http://demo-api.enauda.com/paymentapi/';
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

        $curl = curl_init($this->endpoint . $path);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        curl_setopt_array($curl, $this->sslOptions);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(sprintf('Authorization: Basic %s', $token), 'Content-Type: application/json'));

        $result = curl_exec($curl);

        $error = curl_errno($curl);

        if ($error) {
            throw new CoinfideException(sprintf('CURL error %d: %s', $error, curl_error($curl)));
        }

        $decoded = json_decode($result, true);
        
        if (!$decoded) {
            throw new CoinfideException('Received JSON is not decodable');
        }

        if (isset($decoded['errorData'])) {
            throw new CoinfideException($decoded['errorData']['errorMessage'], $decoded['errorData']['errorCode']);
        }

        return $decoded;
    }
}
