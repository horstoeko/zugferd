<?php

namespace horstoeko\zugferd;

use horstoeko\zugferd\entities\basic\rsm\CrossIndustryInvoice;

class ZugferdDocumentBasicProfile extends ZugferdDocument
{
    /**
     * @inheritDoc
     */
    protected function initSerializerBuilder()
    {
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/basic/qdt', 'horstoeko\zugferd\entities\basic\qdt');
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/basic/ram', 'horstoeko\zugferd\entities\basic\ram');
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/basic/rsm', 'horstoeko\zugferd\entities\basic\rsm');
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/basic/udt', 'horstoeko\zugferd\entities\basic\udt');
    }

    /**
     * @inheritDoc
     */
    protected function getInvoiceObjectClass()
    {
        return CrossIndustryInvoice::class;
    }
}
