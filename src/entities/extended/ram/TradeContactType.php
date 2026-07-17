<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing TradeContactType
 *
 * XSD Type: TradeContactType
 */
class TradeContactType
{

    /**
     * @var string|null $personName
     */
    private $personName = null;

    /**
     * @var string|null $departmentName
     */
    private $departmentName = null;

    /**
     * @var string|null $typeCode
     */
    private $typeCode = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\UniversalCommunicationType|null $telephoneUniversalCommunication
     */
    private $telephoneUniversalCommunication = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\UniversalCommunicationType|null $faxUniversalCommunication
     */
    private $faxUniversalCommunication = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\UniversalCommunicationType|null $emailURIUniversalCommunication
     */
    private $emailURIUniversalCommunication = null;

    /**
     * Gets as personName
     *
     * @return string|null
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
     * @return string|null
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
     * Gets as typeCode
     *
     * @return string|null
     */
    public function getTypeCode()
    {
        return $this->typeCode;
    }

    /**
     * Sets a new typeCode
     *
     * @param  string $typeCode
     * @return self
     */
    public function setTypeCode($typeCode)
    {
        $this->typeCode = $typeCode;
        return $this;
    }

    /**
     * Gets as telephoneUniversalCommunication
     *
     * @return \horstoeko\zugferd\entities\extended\ram\UniversalCommunicationType|null
     */
    public function getTelephoneUniversalCommunication()
    {
        return $this->telephoneUniversalCommunication;
    }

    /**
     * Sets a new telephoneUniversalCommunication
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\UniversalCommunicationType|null $telephoneUniversalCommunication
     * @return self
     */
    public function setTelephoneUniversalCommunication(?\horstoeko\zugferd\entities\extended\ram\UniversalCommunicationType $telephoneUniversalCommunication = null)
    {
        $this->telephoneUniversalCommunication = $telephoneUniversalCommunication;
        return $this;
    }

    /**
     * Gets as faxUniversalCommunication
     *
     * @return \horstoeko\zugferd\entities\extended\ram\UniversalCommunicationType|null
     */
    public function getFaxUniversalCommunication()
    {
        return $this->faxUniversalCommunication;
    }

    /**
     * Sets a new faxUniversalCommunication
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\UniversalCommunicationType|null $faxUniversalCommunication
     * @return self
     */
    public function setFaxUniversalCommunication(?\horstoeko\zugferd\entities\extended\ram\UniversalCommunicationType $faxUniversalCommunication = null)
    {
        $this->faxUniversalCommunication = $faxUniversalCommunication;
        return $this;
    }

    /**
     * Gets as emailURIUniversalCommunication
     *
     * @return \horstoeko\zugferd\entities\extended\ram\UniversalCommunicationType|null
     */
    public function getEmailURIUniversalCommunication()
    {
        return $this->emailURIUniversalCommunication;
    }

    /**
     * Sets a new emailURIUniversalCommunication
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\UniversalCommunicationType|null $emailURIUniversalCommunication
     * @return self
     */
    public function setEmailURIUniversalCommunication(?\horstoeko\zugferd\entities\extended\ram\UniversalCommunicationType $emailURIUniversalCommunication = null)
    {
        $this->emailURIUniversalCommunication = $emailURIUniversalCommunication;
        return $this;
    }
}
