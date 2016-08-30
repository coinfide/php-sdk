<?php

namespace Coinfide\Test;

use Coinfide\Entity\Account;
use Coinfide\Entity\Address;
use Coinfide\Entity\AffiliateInfo;
use Coinfide\Entity\Callback;
use Coinfide\Entity\Order;
use Coinfide\Entity\OrderItem;
use Coinfide\Entity\Phone;
use Coinfide\Entity\Tax;
use Coinfide\Entity\Token;
use Coinfide\Entity\WrappedOrder;

class SerializationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Check wrapped order for deserialization
     */
    public function testWrappedOrder()
    {
        $json = json_decode(file_get_contents(__DIR__ . '/fixtures/wrapped_order.json'), true);

        $order = new WrappedOrder();
        $order->fromArray($json);
        $order->validate();
    }


    /**
     * Check simpliest fromArray and token
     */
    public function testTokenFromArray()
    {
        $json = '{"accessToken":"590ec8e107fd345c328e258e0dd12dda","expiresIn":3600,"refreshToken":"7e8bdae569e94caa89a60a9825b0a302"}';
        
        $token = new Token();
        $token->fromArray(json_decode($json, true));
        $token->validate();
        
        $this->assertEquals('590ec8e107fd345c328e258e0dd12dda', $token->getAccessToken());
        $this->assertEquals('7e8bdae569e94caa89a60a9825b0a302', $token->getRefreshToken());
        $this->assertEquals(3600, $token->getExpiresIn());
    }

    /**
     * Check fixture file for validity
     */
    public function testOrderFromArray()
    {
        $json = json_decode(file_get_contents(__DIR__ . '/fixtures/example_order.json'), true);

        $order = new Order();
        $order->fromArray($json['order']);
        $order->validate();
    }

    /**
     * Check callback deserialization
     */
    public function testCallbacks()
    {
        $json = json_decode(file_get_contents(__DIR__ . '/fixtures/callback.json'), true);

        $order = new Callback();
        $order->fromArray($json);
        $order->validate();
    }

    /**
     * both checks serialization and validation
     */
    public function testOrderSerialize()
    {
        $json = json_decode(file_get_contents(__DIR__ . '/fixtures/example_order.json'), true);

        $seller = new Account();
        $seller->setEmail('merchant@coinfide.com');

        $sellerPhone = new Phone();
        $sellerPhone->setCountryCode('371');
        $sellerPhone->setNumber('20000000');

        $sellerAddress = new Address();
        $sellerAddress->setCountryCode('LV');
        $sellerAddress->setCity('Riga');
        $sellerAddress->setFirstAddressLine('Duntes 4');
        $sellerAddress->setSecondAddressLine('Office 403');
        $sellerAddress->setState('Rigas');
        $sellerAddress->setPostalCode('LV-2020');

        $seller->setAddress($sellerAddress);
        $seller->setPhone($sellerPhone);

        $seller->setBirthDate('19951015000000');

        $seller->setWebsite('http://www.example.com');
        $seller->setTaxpayerIdentificationNumber('TAX83642');
        $seller->setAdditionalInfo('Additional information for buyer');

        $buyer = new Account();
        $buyer->setEmail('anna.bord@enauda.com');

        $buyerPhone = new Phone();
        $buyerPhone->setCountryCode('371');
        $buyerPhone->setNumber('21111111');

        $buyer->setName('Anna');
        $buyer->setSurname('Borg');
        $buyer->setLanguage('en');

        $buyerAddress = new Address();
        $buyerAddress->setCountryCode('LV');
        $buyerAddress->setCity('Riga');
        $buyerAddress->setFirstAddressLine('Brivibas 1/2');
        $buyerAddress->setSecondAddressLine('Office 404');
        $buyerAddress->setState('Rigas');
        $buyerAddress->setPostalCode('LV-1010');

        $buyer->setAddress($buyerAddress);
        $buyer->setPhone($buyerPhone);

        $order = new Order();

        $buyer->setEmail('buyer@coinfide.com');

        $order->setSeller($seller);
        $order->setBuyer($buyer);

        $order->setCurrencyCode('EUR');
        $order->setDiscountAmount(0.00);
        $order->setDiscountPercent(0.00);
        $order->setIssueDate('20151001184000');
        $order->setDueDate('20171201184000');
        $order->setExternalOrderId('TSPV000001');
        $order->setReference('REF582764');
        $order->setNote('Some note here');
        $order->setTerms('Terms and conditions');
        $order->setAmountTotal(110);

        $affiliateInfo = new AffiliateInfo();
        $affiliateInfo->setAffiliateId('AF4');
        $affiliateInfo->setCampaignId('C539');
        $affiliateInfo->setBannerId('BRT13');
        $affiliateInfo->setCustomParameters('tr=24&hd=3');

        $order->setAffiliateInfo($affiliateInfo);
        $order->setAcceptPaymentsIfOrderExpired(true);
        $order->setTaxBeforeDiscount(true);
        $order->setTaxInclusive(true);
        $order->setSuccessUrl('http://seller.success.url');
        $order->setPaymentPageUrl('http://seller.payment.page.url');
        $order->setFailUrl('http://seller.fail.url');
        $order->setProvisionChannel('123456');

        $orderItem = new OrderItem();
        $orderItem->setType('I');
        $orderItem->setName('Item1');
        $orderItem->setDescription('First item description');
        $orderItem->setPriceUnit(10.00);
        $orderItem->setQuantity(10);
        $orderItem->setDiscountAmount(0);
        $orderItem->setDiscountPercent(10);

        $tax = new Tax();
        $tax->setRate(20);
        $tax->setName('Tax 20%');

        $orderItem->setTax($tax);

        $order->addOrderItem($orderItem);

        $orderItem = new OrderItem();
        $orderItem->setType('S');
        $orderItem->setName('Shipping with FedEx');
        $orderItem->setPriceUnit(20.00);
        $orderItem->setQuantity(1);

        $tax = new Tax();
        $tax->setRate(10);
        $tax->setName('Tax 10%');

        $orderItem->setTax($tax);

        $order->addOrderItem($orderItem);

        $shippingAddress = new Address();
        $shippingAddress->setCountryCode('MT');
        $shippingAddress->setCity('M\'scala');
        $shippingAddress->setFirstAddressLine('Triq Il-Buhagiar');
        $shippingAddress->setSecondAddressLine('Fl.2, Hortana Court');
        $shippingAddress->setState('South');
        $shippingAddress->setPostalCode('MSK2100');

        $order->setShippingAddress($shippingAddress);

        $this->assertEquals($json, array('order' => $order->toArray()));
    }
}
