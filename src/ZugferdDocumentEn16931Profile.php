<?php

namespace horstoeko\zugferd;

use horstoeko\zugferd\entities\en16931\rsm\CrossIndustryInvoice;

class ZugferdDocumentEn16931Profile extends ZugferdDocument
{
    /**
     * @inheritDoc
     */
    protected function initSerializerBuilder()
    {
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/en16931/qdt', 'horstoeko\zugferd\entities\en16931\qdt');
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/en16931/ram', 'horstoeko\zugferd\entities\en16931\ram');
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/en16931/rsm', 'horstoeko\zugferd\entities\en16931\rsm');
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/en16931/udt', 'horstoeko\zugferd\entities\en16931\udt');
    }

    /**
     * @inheritDoc
     */
    protected function getInvoiceObjectClass()
    {
        return CrossIndustryInvoice::class;
    }
}
