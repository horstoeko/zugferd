<?php

namespace horstoeko\zugferd\basic\ram;

/**
 * Class representing ExchangedDocumentContextType
 *
 *
 * XSD Type: ExchangedDocumentContextType
 */
class ExchangedDocumentContextType
{

    /**
     * @var \horstoeko\zugferd\basic\ram\DocumentContextParameterType $businessProcessSpecifiedDocumentContextParameter
     */
    private $businessProcessSpecifiedDocumentContextParameter = null;

    /**
     * @var \horstoeko\zugferd\basic\ram\DocumentContextParameterType $guidelineSpecifiedDocumentContextParameter
     */
    private $guidelineSpecifiedDocumentContextParameter = null;

    /**
     * Gets as businessProcessSpecifiedDocumentContextParameter
     *
     * @return \horstoeko\zugferd\basic\ram\DocumentContextParameterType
     */
    public function getBusinessProcessSpecifiedDocumentContextParameter()
    {
        return $this->businessProcessSpecifiedDocumentContextParameter;
    }

    /**
     * Sets a new businessProcessSpecifiedDocumentContextParameter
     *
     * @param \horstoeko\zugferd\basic\ram\DocumentContextParameterType $businessProcessSpecifiedDocumentContextParameter
     * @return self
     */
    public function setBusinessProcessSpecifiedDocumentContextParameter(\horstoeko\zugferd\basic\ram\DocumentContextParameterType $businessProcessSpecifiedDocumentContextParameter)
    {
        $this->businessProcessSpecifiedDocumentContextParameter = $businessProcessSpecifiedDocumentContextParameter;
        return $this;
    }

    /**
     * Gets as guidelineSpecifiedDocumentContextParameter
     *
     * @return \horstoeko\zugferd\basic\ram\DocumentContextParameterType
     */
    public function getGuidelineSpecifiedDocumentContextParameter()
    {
        return $this->guidelineSpecifiedDocumentContextParameter;
    }

    /**
     * Sets a new guidelineSpecifiedDocumentContextParameter
     *
     * @param \horstoeko\zugferd\basic\ram\DocumentContextParameterType $guidelineSpecifiedDocumentContextParameter
     * @return self
     */
    public function setGuidelineSpecifiedDocumentContextParameter(\horstoeko\zugferd\basic\ram\DocumentContextParameterType $guidelineSpecifiedDocumentContextParameter)
    {
        $this->guidelineSpecifiedDocumentContextParameter = $guidelineSpecifiedDocumentContextParameter;
        return $this;
    }


}

