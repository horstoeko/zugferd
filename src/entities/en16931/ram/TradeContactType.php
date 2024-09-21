<?php

namespace horstoeko\zugferd\entities\en16931\ram;

/**
 * Class representing TradeContactType
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
     * @var \horstoeko\zugferd\entities\en16931\ram\UniversalCommunicationType $telephoneUniversalCommunication
     */
    private $telephoneUniversalCommunication = null;

    /**
     * @var \horstoeko\zugferd\entities\en16931\ram\UniversalCommunicationType $emailURIUniversalCommunication
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
     * @param  string $personName
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
     * @param  string $departmentName
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
     * @return \horstoeko\zugferd\entities\en16931\ram\UniversalCommunicationType
     */
    public function getTelephoneUniversalCommunication()
    {
        return $this->telephoneUniversalCommunication;
    }

    /**
     * Sets a new telephoneUniversalCommunication
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\UniversalCommunicationType $telephoneUniversalCommunication
     * @return self
     */
    public function setTelephoneUniversalCommunication(?\horstoeko\zugferd\entities\en16931\ram\UniversalCommunicationType $telephoneUniversalCommunication = null)
    {
        $this->telephoneUniversalCommunication = $telephoneUniversalCommunication;
        return $this;
    }

    /**
     * Gets as emailURIUniversalCommunication
     *
     * @return \horstoeko\zugferd\entities\en16931\ram\UniversalCommunicationType
     */
    public function getEmailURIUniversalCommunication()
    {
        return $this->emailURIUniversalCommunication;
    }

    /**
     * Sets a new emailURIUniversalCommunication
     *
     * @param  \horstoeko\zugferd\entities\en16931\ram\UniversalCommunicationType $emailURIUniversalCommunication
     * @return self
     */
    public function setEmailURIUniversalCommunication(?\horstoeko\zugferd\entities\en16931\ram\UniversalCommunicationType $emailURIUniversalCommunication = null)
    {
        $this->emailURIUniversalCommunication = $emailURIUniversalCommunication;
        return $this;
    }
}
