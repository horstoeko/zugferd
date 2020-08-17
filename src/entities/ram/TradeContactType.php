<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing TradeContactType
 *
 *
 * XSD Type: TradeContactType
 */
class TradeContactType
{

    /**
     * @var string $personName
     */
    private $personName = null;

    /**
     * @var string $departmentName
     */
    private $departmentName = null;

    /**
     * @var \horstoeko\zugferd\ram\UniversalCommunicationType $telephoneUniversalCommunication
     */
    private $telephoneUniversalCommunication = null;

    /**
     * @var \horstoeko\zugferd\ram\UniversalCommunicationType $faxUniversalCommunication
     */
    private $faxUniversalCommunication = null;

    /**
     * @var \horstoeko\zugferd\ram\UniversalCommunicationType $emailURIUniversalCommunication
     */
    private $emailURIUniversalCommunication = null;

    /**
     * Gets as personName
     *
     * @return string
     */
    public function getPersonName()
    {
        return $this->personName;
    }

    /**
     * Sets a new personName
     *
     * @param string $personName
     * @return self
     */
    public function setPersonName($personName)
    {
        $this->personName = $personName;
        return $this;
    }

    /**
     * Gets as departmentName
     *
     * @return string
     */
    public function getDepartmentName()
    {
        return $this->departmentName;
    }

    /**
     * Sets a new departmentName
     *
     * @param string $departmentName
     * @return self
     */
    public function setDepartmentName($departmentName)
    {
        $this->departmentName = $departmentName;
        return $this;
    }

    /**
     * Gets as telephoneUniversalCommunication
     *
     * @return \horstoeko\zugferd\ram\UniversalCommunicationType
     */
    public function getTelephoneUniversalCommunication()
    {
        return $this->telephoneUniversalCommunication;
    }

    /**
     * Sets a new telephoneUniversalCommunication
     *
     * @param \horstoeko\zugferd\ram\UniversalCommunicationType $telephoneUniversalCommunication
     * @return self
     */
    public function setTelephoneUniversalCommunication(\horstoeko\zugferd\ram\UniversalCommunicationType $telephoneUniversalCommunication)
    {
        $this->telephoneUniversalCommunication = $telephoneUniversalCommunication;
        return $this;
    }

    /**
     * Gets as faxUniversalCommunication
     *
     * @return \horstoeko\zugferd\ram\UniversalCommunicationType
     */
    public function getFaxUniversalCommunication()
    {
        return $this->faxUniversalCommunication;
    }

    /**
     * Sets a new faxUniversalCommunication
     *
     * @param \horstoeko\zugferd\ram\UniversalCommunicationType $faxUniversalCommunication
     * @return self
     */
    public function setFaxUniversalCommunication(\horstoeko\zugferd\ram\UniversalCommunicationType $faxUniversalCommunication)
    {
        $this->faxUniversalCommunication = $faxUniversalCommunication;
        return $this;
    }

    /**
     * Gets as emailURIUniversalCommunication
     *
     * @return \horstoeko\zugferd\ram\UniversalCommunicationType
     */
    public function getEmailURIUniversalCommunication()
    {
        return $this->emailURIUniversalCommunication;
    }

    /**
     * Sets a new emailURIUniversalCommunication
     *
     * @param \horstoeko\zugferd\ram\UniversalCommunicationType $emailURIUniversalCommunication
     * @return self
     */
    public function setEmailURIUniversalCommunication(\horstoeko\zugferd\ram\UniversalCommunicationType $emailURIUniversalCommunication)
    {
        $this->emailURIUniversalCommunication = $emailURIUniversalCommunication;
        return $this;
    }


}

