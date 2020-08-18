<?php

namespace horstoeko\zugferd;

use horstoeko\zugferd\entities\basicwl\rsm\CrossIndustryInvoice;

class ZugferdDocumentBasicWLProfile extends ZugferdDocument
{
    /**
     * @inheritDoc
     */
    protected function initSerializerBuilder()
    {
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/basicwl/qdt', 'horstoeko\zugferd\entities\basicwl\qdt');
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/basicwl/ram', 'horstoeko\zugferd\entities\basicwl\ram');
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/basicwl/rsm', 'horstoeko\zugferd\entities\basicwl\rsm');
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/basicwl/udt', 'horstoeko\zugferd\entities\basicwl\udt');
    }

    /**
     * @inheritDoc
     */
    protected function getInvoiceObjectClass()
    {
        return CrossIndustryInvoice::class;
    }
}
