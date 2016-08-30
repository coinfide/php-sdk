<?php

namespace Coinfide\Entity;

class Address extends Base
{
    protected $validationRules = array(
        'countryCode' => array('type' => 'string', 'max_length' => 2, 'required' => true),
        'city' => array('type' => 'string', 'max_length' => 50, 'required' => true),
        'firstAddressLine' => array('type' => 'string', 'max_length' => 60, 'required' => true),
        'secondAddressLine' => array('type' => 'string', 'max_length' => 60, 'required' => false),
        'state' => array('type' => 'string', 'max_length' => 50, 'required' => false),
        'postalCode' => array('type' => 'string', 'max_length' => 10, 'required' => true)
    );

    /**
     * @var string
     */
    protected $countryCode;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $firstAddressLine;

    /**
     * @var string
     */
    protected $secondAddressLine;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $postalCode;

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getFirstAddressLine()
    {
        return $this->firstAddressLine;
    }

    /**
     * @param string $firstAddressLine
     */
    public function setFirstAddressLine($firstAddressLine)
    {
        $this->firstAddressLine = $firstAddressLine;
    }

    /**
     * @return string
     */
    public function getSecondAddressLine()
    {
        return $this->secondAddressLine;
    }

    /**
     * @param string $secondAddressLine
     */
    public function setSecondAddressLine($secondAddressLine)
    {
        $this->secondAddressLine = $secondAddressLine;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }
    
}
