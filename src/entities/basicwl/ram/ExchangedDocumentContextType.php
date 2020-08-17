<?php

namespace horstoeko\zugferd\basicwl\ram;

/**
 * Class representing ExchangedDocumentContextType
 *
 *
 * XSD Type: ExchangedDocumentContextType
 */
class ExchangedDocumentContextType
{

    /**
     * @var \horstoeko\zugferd\basicwl\ram\DocumentContextParameterType $businessProcessSpecifiedDocumentContextParameter
     */
    private $businessProcessSpecifiedDocumentContextParameter = null;

    /**
     * @var \horstoeko\zugferd\basicwl\ram\DocumentContextParameterType $guidelineSpecifiedDocumentContextParameter
     */
    private $guidelineSpecifiedDocumentContextParameter = null;

    /**
     * Gets as businessProcessSpecifiedDocumentContextParameter
     *
     * @return \horstoeko\zugferd\basicwl\ram\DocumentContextParameterType
     */
    public function getBusinessProcessSpecifiedDocumentContextParameter()
    {
        return $this->businessProcessSpecifiedDocumentContextParameter;
    }

    /**
     * Sets a new businessProcessSpecifiedDocumentContextParameter
     *
     * @param \horstoeko\zugferd\basicwl\ram\DocumentContextParameterType $businessProcessSpecifiedDocumentContextParameter
     * @return self
     */
    public function setBusinessProcessSpecifiedDocumentContextParameter(\horstoeko\zugferd\basicwl\ram\DocumentContextParameterType $businessProcessSpecifiedDocumentContextParameter)
    {
        $this->businessProcessSpecifiedDocumentContextParameter = $businessProcessSpecifiedDocumentContextParameter;
        return $this;
    }

    /**
     * Gets as guidelineSpecifiedDocumentContextParameter
     *
     * @return \horstoeko\zugferd\basicwl\ram\DocumentContextParameterType
     */
    public function getGuidelineSpecifiedDocumentContextParameter()
    {
        return $this->guidelineSpecifiedDocumentContextParameter;
    }

    /**
     * Sets a new guidelineSpecifiedDocumentContextParameter
     *
     * @param \horstoeko\zugferd\basicwl\ram\DocumentContextParameterType $guidelineSpecifiedDocumentContextParameter
     * @return self
     */
    public function setGuidelineSpecifiedDocumentContextParameter(\horstoeko\zugferd\basicwl\ram\DocumentContextParameterType $guidelineSpecifiedDocumentContextParameter)
    {
        $this->guidelineSpecifiedDocumentContextParameter = $guidelineSpecifiedDocumentContextParameter;
        return $this;
    }


}

