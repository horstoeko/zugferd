<?php

namespace horstoeko\zugferd\ram;

/**
 * Class representing ExchangedDocumentContextType
 *
 *
 * XSD Type: ExchangedDocumentContextType
 */
class ExchangedDocumentContextType
{

    /**
     * @var \horstoeko\zugferd\udt\IndicatorType $testIndicator
     */
    private $testIndicator = null;

    /**
     * @var \horstoeko\zugferd\ram\DocumentContextParameterType $businessProcessSpecifiedDocumentContextParameter
     */
    private $businessProcessSpecifiedDocumentContextParameter = null;

    /**
     * @var \horstoeko\zugferd\ram\DocumentContextParameterType $guidelineSpecifiedDocumentContextParameter
     */
    private $guidelineSpecifiedDocumentContextParameter = null;

    /**
     * Gets as testIndicator
     *
     * @return \horstoeko\zugferd\udt\IndicatorType
     */
    public function getTestIndicator()
    {
        return $this->testIndicator;
    }

    /**
     * Sets a new testIndicator
     *
     * @param \horstoeko\zugferd\udt\IndicatorType $testIndicator
     * @return self
     */
    public function setTestIndicator(\horstoeko\zugferd\udt\IndicatorType $testIndicator)
    {
        $this->testIndicator = $testIndicator;
        return $this;
    }

    /**
     * Gets as businessProcessSpecifiedDocumentContextParameter
     *
     * @return \horstoeko\zugferd\ram\DocumentContextParameterType
     */
    public function getBusinessProcessSpecifiedDocumentContextParameter()
    {
        return $this->businessProcessSpecifiedDocumentContextParameter;
    }

    /**
     * Sets a new businessProcessSpecifiedDocumentContextParameter
     *
     * @param \horstoeko\zugferd\ram\DocumentContextParameterType $businessProcessSpecifiedDocumentContextParameter
     * @return self
     */
    public function setBusinessProcessSpecifiedDocumentContextParameter(\horstoeko\zugferd\ram\DocumentContextParameterType $businessProcessSpecifiedDocumentContextParameter)
    {
        $this->businessProcessSpecifiedDocumentContextParameter = $businessProcessSpecifiedDocumentContextParameter;
        return $this;
    }

    /**
     * Gets as guidelineSpecifiedDocumentContextParameter
     *
     * @return \horstoeko\zugferd\ram\DocumentContextParameterType
     */
    public function getGuidelineSpecifiedDocumentContextParameter()
    {
        return $this->guidelineSpecifiedDocumentContextParameter;
    }

    /**
     * Sets a new guidelineSpecifiedDocumentContextParameter
     *
     * @param \horstoeko\zugferd\ram\DocumentContextParameterType $guidelineSpecifiedDocumentContextParameter
     * @return self
     */
    public function setGuidelineSpecifiedDocumentContextParameter(\horstoeko\zugferd\ram\DocumentContextParameterType $guidelineSpecifiedDocumentContextParameter)
    {
        $this->guidelineSpecifiedDocumentContextParameter = $guidelineSpecifiedDocumentContextParameter;
        return $this;
    }


}

