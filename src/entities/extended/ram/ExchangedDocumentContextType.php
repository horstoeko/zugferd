<?php

namespace horstoeko\zugferd\entities\extended\ram;

/**
 * Class representing ExchangedDocumentContextType
 *
 * XSD Type: ExchangedDocumentContextType
 */
class ExchangedDocumentContextType
{

    /**
     * @var \horstoeko\zugferd\entities\extended\udt\IndicatorType $testIndicator
     */
    private $testIndicator = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\DocumentContextParameterType $businessProcessSpecifiedDocumentContextParameter
     */
    private $businessProcessSpecifiedDocumentContextParameter = null;

    /**
     * @var \horstoeko\zugferd\entities\extended\ram\DocumentContextParameterType $guidelineSpecifiedDocumentContextParameter
     */
    private $guidelineSpecifiedDocumentContextParameter = null;

    /**
     * Gets as testIndicator
     *
     * @return \horstoeko\zugferd\entities\extended\udt\IndicatorType
     */
    public function getTestIndicator()
    {
        return $this->testIndicator;
    }

    /**
     * Sets a new testIndicator
     *
     * @param  \horstoeko\zugferd\entities\extended\udt\IndicatorType $testIndicator
     * @return self
     */
    public function setTestIndicator(?\horstoeko\zugferd\entities\extended\udt\IndicatorType $testIndicator = null)
    {
        $this->testIndicator = $testIndicator;
        return $this;
    }

    /**
     * Gets as businessProcessSpecifiedDocumentContextParameter
     *
     * @return \horstoeko\zugferd\entities\extended\ram\DocumentContextParameterType
     */
    public function getBusinessProcessSpecifiedDocumentContextParameter()
    {
        return $this->businessProcessSpecifiedDocumentContextParameter;
    }

    /**
     * Sets a new businessProcessSpecifiedDocumentContextParameter
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\DocumentContextParameterType $businessProcessSpecifiedDocumentContextParameter
     * @return self
     */
    public function setBusinessProcessSpecifiedDocumentContextParameter(?\horstoeko\zugferd\entities\extended\ram\DocumentContextParameterType $businessProcessSpecifiedDocumentContextParameter = null)
    {
        $this->businessProcessSpecifiedDocumentContextParameter = $businessProcessSpecifiedDocumentContextParameter;
        return $this;
    }

    /**
     * Gets as guidelineSpecifiedDocumentContextParameter
     *
     * @return \horstoeko\zugferd\entities\extended\ram\DocumentContextParameterType
     */
    public function getGuidelineSpecifiedDocumentContextParameter()
    {
        return $this->guidelineSpecifiedDocumentContextParameter;
    }

    /**
     * Sets a new guidelineSpecifiedDocumentContextParameter
     *
     * @param  \horstoeko\zugferd\entities\extended\ram\DocumentContextParameterType $guidelineSpecifiedDocumentContextParameter
     * @return self
     */
    public function setGuidelineSpecifiedDocumentContextParameter(\horstoeko\zugferd\entities\extended\ram\DocumentContextParameterType $guidelineSpecifiedDocumentContextParameter)
    {
        $this->guidelineSpecifiedDocumentContextParameter = $guidelineSpecifiedDocumentContextParameter;
        return $this;
    }
}
