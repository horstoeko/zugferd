<?php

namespace horstoeko\zugferd;

/**
 * Class representing the auto-calculator for amounts of a document 
 * builded by document build
 */
class ZugferdDocumentBuilderWithCalculator extends ZugferdDocumentBuilder
{
    /**
     * @inheritDoc
     *
     * @return void
     */
    protected function OnBeforeWriteFile(string $xmlfilename)
    {
        $this->Calculate();
    }

    /**
     * Complete calculation of all amounts
     *
     * @return ZugferdDocumentBuilderWithCalculator
     */
    public function Calculate(): ZugferdDocumentBuilderWithCalculator
    {
        $this->CalculatePositionLineSummations();
        $this->CalculateDocumentSummation();

        return $this;
    }

    /**
     * Calculate all line summations
     *
     * @return void
     */
    public function CalculatePositionLineSummations()
    {
        $lines = $this->objectHelper->TryCallAndReturn($this->headerSupplyChainTradeTransaction, 'getIncludedSupplyChainTradeLineItem') ?? [];

        foreach ($lines as $line) {
            $this->CalculatePositionLineSummation($line);
        }
    }

    /**
     * Calculate a single summations
     *
     * @return void
     */
    public function CalculatePositionLineSummation(object $line)
    {
        $positionsettlement = $this->objectHelper->TryCallAndReturn($line, "getSpecifiedLineTradeSettlement");

        $billedQuantity = (float) $this->objectHelper->TryCallByPathAndReturn($line, "getSpecifiedLineTradeDelivery.getBilledQuantity.value") ?? 0.0;
        $netPrice = (float) $this->objectHelper->TryCallByPathAndReturn($line, "getSpecifiedLineTradeAgreement.getNetPriceProductTradePrice.getChargeAmount.value") ?? 0.0;
        $positionAllowanceCharges = (array) $this->objectHelper->TryCallByPathAndReturn($line, "getSpecifiedLineTradeSettlement.getSpecifiedTradeAllowanceCharge") ?? [];
        $positionAllowanceChargesSum = 0.0;

        foreach ($positionAllowanceCharges as $positionAllowanceCharge) {
            $isCharge = (bool) $this->objectHelper->TryCallByPathAndReturn($positionAllowanceCharge, "getChargeIndicator.getIndicator") ?? false;
            $actualAmount = (float) $this->objectHelper->TryCallByPathAndReturn($positionAllowanceCharge, "getActualAmount.value") ?? 0.0;
            $positionAllowanceChargesSum = $positionAllowanceChargesSum + ($isCharge == false ? -$actualAmount : $actualAmount);
        }

        $summation =
            $this->objectHelper->GetTradeSettlementLineMonetarySummationType(
                round($netPrice * $billedQuantity + $positionAllowanceChargesSum, 2),
                round($positionAllowanceChargesSum, 2)
            );

        $this->objectHelper->TryCall($positionsettlement, "setSpecifiedTradeSettlementLineMonetarySummation", $summation);

        return $this;
    }

    public function CalculateDocumentSummation()
    {
        $lines = $this->objectHelper->TryCallAndReturn($this->headerSupplyChainTradeTransaction, 'getIncludedSupplyChainTradeLineItem') ?? [];

        $lineTotalAmount = 0.0;
        $vatSumGrouped = [];
        $docAllowanceSum = 0.0;
        $docChargeSum = 0.0;
        $docNetAmount = 0.0;
        $docVatSum = 0.0;

        foreach ($lines as $line) {
            $lineAmount = $this->objectHelper->TryCallByPathAndReturn($line, "getSpecifiedLineTradeSettlement.getSpecifiedTradeSettlementLineMonetarySummation.getLineTotalAmount.value") ?? 0.0;
            $lineTotalAmount = $lineTotalAmount + $lineAmount;
            $lineTaxes = $this->objectHelper->ensureArray($this->objectHelper->TryCallByPathAndReturn($line, "getSpecifiedLineTradeSettlement.getApplicableTradeTax")) ?? [];

            foreach ($lineTaxes as $lineTax) {
                $vatCategory = (string) $this->objectHelper->TryCallByPathAndReturn($lineTax, "getCategoryCode.value") ?? '';
                $vatType = (string) $this->objectHelper->TryCallByPathAndReturn($lineTax, "getTypeCode.value") ?? '';
                $vatPercent = (float) $this->objectHelper->TryCallByPathAndReturn($lineTax, "getRateApplicablePercent.value") ?? 0.0;

                $vatGroupId = md5($vatCategory . $vatType . $vatPercent);

                $vatSumGrouped[$vatGroupId] = isset($vatSumGrouped[$vatGroupId]) ? $vatSumGrouped[$vatGroupId] : [$vatCategory, $vatType, $vatPercent, 0, 0];
                $vatSumGrouped[$vatGroupId][100] = $vatSumGrouped[$vatGroupId][100] + $lineAmount;
                $vatSumGrouped[$vatGroupId][101] = round($vatSumGrouped[$vatGroupId][100] * ($vatPercent / 100.0), 2);
            }
        }

        $docAllowanceCharges = $this->objectHelper->TryCallByPathAndReturn($this->headerTradeSettlement, 'getSpecifiedTradeAllowanceCharge') ?? [];
        $docAllowanceCharges = !is_array($docAllowanceCharges) ? [$docAllowanceCharges] : $docAllowanceCharges;

        foreach ($docAllowanceCharges as $docAllowanceCharge) {
            $actualAmount = $this->objectHelper->TryCallByPathAndReturn($docAllowanceCharge, "getActualAmount.value");
            $vatCategory = (string) $this->objectHelper->TryCallByPathAndReturn($docAllowanceCharge, "getCategoryTradeTax.getCategoryCode.value") ?? '';
            $vatType = (string) $this->objectHelper->TryCallByPathAndReturn($docAllowanceCharge, "getCategoryTradeTax.getTypeCode.value") ?? '';
            $vatPercent = (float) $this->objectHelper->TryCallByPathAndReturn($docAllowanceCharge, "getCategoryTradeTax.getRateApplicablePercent.value") ?? 0.0;
            $chargeindicator = (bool) $this->objectHelper->TryCallByPathAndReturn($docAllowanceCharge, "getChargeIndicator.getIndicator") ?? false;

            $vatGroupId = md5($vatCategory . $vatType . $vatPercent);

            $vatSumGrouped[$vatGroupId] = isset($vatSumGrouped[$vatGroupId]) ? $vatSumGrouped[$vatGroupId] : [$vatCategory, $vatType, $vatPercent, 0, 0];
            $vatSumGrouped[$vatGroupId][100] = $vatSumGrouped[$vatGroupId][100] + ($chargeindicator === true ? $actualAmount : -$actualAmount);
            $vatSumGrouped[$vatGroupId][101] = round($vatSumGrouped[$vatGroupId][100] * ($vatPercent / 100.0), 2);
            $docAllowanceSum = $docAllowanceSum + ($chargeindicator === true ? 0.0 : $actualAmount);
            $docChargeSum = $docChargeSum + ($chargeindicator === true ? $actualAmount : 0.0);
        }

        foreach ($vatSumGrouped as $vatSumGroupedItemKey => $vatSumGroupedItem) {
            $docNetAmount = $docNetAmount + $vatSumGroupedItem[100];
            $docVatSum = $docVatSum + $vatSumGroupedItem[101];
            $this->AddDocumentTax(
                $vatSumGroupedItem[0],
                $vatSumGroupedItem[1],
                $vatSumGroupedItem[100],
                $vatSumGroupedItem[101],
                $vatSumGroupedItem[2]
            );
        }

        $summation = $this->objectHelper->GetTradeSettlementHeaderMonetarySummationTypeOnly();

        $totalPrepaidAmount = $this->objectHelper->TryCallByPathAndReturn($summation, "getTotalPrepaidAmount.value") ?? 0;
        $invoiceCurrencyCode = $this->objectHelper->TryCallByPathAndReturn($this->invoiceObject, "getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceCurrencyCode.value", "");

        $summation = $this->objectHelper->GetTradeSettlementHeaderMonetarySummationTypeOnly();

        $this->objectHelper->TryCallAll($summation, ["addToGrandTotalAmount", "setGrandTotalAmount"], $this->objectHelper->GetAmountType(round($docNetAmount + $docVatSum, 2)));
        $this->objectHelper->TryCall($summation, "setDuePayableAmount", $this->objectHelper->GetAmountType(round($docNetAmount + $docVatSum - $totalPrepaidAmount, 2)));
        $this->objectHelper->TryCall($summation, "setLineTotalAmount", $this->objectHelper->GetAmountType(round($lineTotalAmount, 2)));
        $this->objectHelper->TryCall($summation, "setChargeTotalAmount", $this->objectHelper->GetAmountType(round($docChargeSum, 2)));
        $this->objectHelper->TryCall($summation, "setAllowanceTotalAmount", $this->objectHelper->GetAmountType(round($docAllowanceSum, 2)));
        $this->objectHelper->TryCallAll($summation, ["addToTaxBasisTotalAmount", "setTaxBasisTotalAmount"], $this->objectHelper->GetAmountType(round($docNetAmount, 2)));
        $this->objectHelper->TryCallAll($summation, ["addToTaxTotalAmount", "setTaxTotalAmount"], $this->objectHelper->GetAmountType(round($docVatSum, 2), $invoiceCurrencyCode));
        $this->objectHelper->TryCall($summation, "setRoundingAmount", $this->objectHelper->GetAmountType(0));
        $this->objectHelper->TryCall($summation, "setTotalPrepaidAmount", $this->objectHelper->GetAmountType($totalPrepaidAmount));

        $this->objectHelper->TryCall($this->headerTradeSettlement, "setSpecifiedTradeSettlementHeaderMonetarySummation", $summation);
    }
}
