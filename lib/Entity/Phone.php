<?php

namespace Coinfide\Entity;

use Coinfide\CoinfideException;

class Phone extends Base
{
    protected $validationRules = array(
        'countryCode' => array('type' => 'string', 'required' => false),
        'number' => array('type' => 'string', 'required' => false),
        'fullNumber' => array('type' => 'string', 'required' => false)
    );



    /**
     * @var string
     */
    protected $countryCode;

    /**
     * @var string
     */
    protected $number;

    /**
     * @var string
     */
    protected $fullNumber;

    public function validate()
    {
        parent::validate();

        if (!($this->fullNumber || ($this->number && $this->countryCode))) {
            throw new CoinfideException(sprintf('Please set either fullNumber or number AND countryCode for Phone object'));
        }
    }

    /**
     * @return string
     */
    public function getFullNumber()
    {
        return $this->fullNumber;
    }

    /**
     * @param string $fullNumber
     */
    public function setFullNumber($fullNumber)
    {
        $this->fullNumber = $fullNumber;
    }

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
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }
}
