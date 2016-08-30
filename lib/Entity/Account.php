<?php

namespace Coinfide\Entity;

class Account extends Base
{
    protected $validationRules = array(
        'email' => array('type' => 'string', 'required' => true, 'max_length' => 255),
        'phone' => array('type' => 'object', 'class' => '\Coinfide\Entity\Phone', 'required' => false),
        'externalUid' => array('type' => 'string', 'max_length' => 50, 'required' => false),
        'name' => array('type' => 'string', 'max_length' => 50, 'required' => false),
        'surname' => array('type' => 'string', 'max_length' => 50, 'required' => false),
        'birthDate' => array('type' => 'date', 'required' => false),
        'language' => array('type' => 'string', 'max_length' => 2, 'required' => false),
        'address' => array('type' => 'object', 'class' => '\Coinfide\Entity\Address', 'required' => false),
        'website' => array('type' => 'string', 'max_length' => 2048, 'required' => false),
        'taxpayerIdentificationNumber' => array('type' => 'string', 'max_length' => 255, 'required' => false),
        'additionalInfo' => array('type' => 'string', 'max_length' => 5000, 'required' => false),
    );

    /**
     * @var string
     */
    protected $email;

    /**
     * @var Phone
     */
    protected $phone;

    /**
     * @var string
     */
    protected $externalUid;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $surname;

    /**
     * @var string
     */
    protected $birthDate;

    /**
     * @var string
     */
    protected $language;

    /**
     * @var Address
     */
    protected $address;
    
    /**
     * @var string
     */
    protected $website;

    /**
     * @var string
     */
    protected $taxpayerIdentificationNumber;

    /**
     * @var string
     */
    protected $additionalInfo;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return Phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param Phone $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getExternalUid()
    {
        return $this->externalUid;
    }

    /**
     * @param string $externalUid
     */
    public function setExternalUid($externalUid)
    {
        $this->externalUid = $externalUid;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param string $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return string
     */
    public function getTaxpayerIdentificationNumber()
    {
        return $this->taxpayerIdentificationNumber;
    }

    /**
     * @param string $taxpayerIdentificationNumber
     */
    public function setTaxpayerIdentificationNumber($taxpayerIdentificationNumber)
    {
        $this->taxpayerIdentificationNumber = $taxpayerIdentificationNumber;
    }

    /**
     * @return string
     */
    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }

    /**
     * @param string $additionalInfo
     */
    public function setAdditionalInfo($additionalInfo)
    {
        $this->additionalInfo = $additionalInfo;
    }
}
