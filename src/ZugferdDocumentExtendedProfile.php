<?php

namespace horstoeko\zugferd;

use horstoeko\zugferd\entities\extended\rsm\CrossIndustryInvoice;

class ZugferdDocumentExtendedProfile extends ZugferdDocument
{
    /**
     * @inheritDoc
     */
    protected function initSerializerBuilder()
    {
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/extended/qdt', 'horstoeko\zugferd\entities\extended\qdt');
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/extended/ram', 'horstoeko\zugferd\entities\extended\ram');
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/extended/rsm', 'horstoeko\zugferd\entities\extended\rsm');
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/extended/udt', 'horstoeko\zugferd\entities\extended\udt');
    }

    /**
     * Returns the classname of the invoice object type
     *
     * @return string
     */
    protected function getInvoiceObjectClass()
    {
        return CrossIndustryInvoice::class;
    }
}
