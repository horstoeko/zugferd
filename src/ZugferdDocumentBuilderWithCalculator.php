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
    protected function OnBeforeGetContent()
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

        $grossPriceType = $this->objectHelper->TryCallByPathAndReturn($line, "getSpecifiedLineTradeAgreement.getGrossPriceProductTradePrice");
        if (!is_null($grossPriceType)) {
            $grossPriceAllowanceCharges = $this->objectHelper->EnsureArray($this->objectHelper->TryCallByPathAndReturn($grossPriceType, "getAppliedTradeAllowanceCharge"));
            $grossPriceAllowanceChargesSum = 0.0;

            foreach ($grossPriceAllowanceCharges as $grossPriceAllowanceCharge) {
                $grossPriceAllowanceChargeBasisAmountType = $this->objectHelper->TryCallByPathAndReturn($grossPriceAllowanceCharge, "getBasisAmount");
                $grossPriceAllowanceChargeCalculationPercentType = $this->objectHelper->TryCallByPathAndReturn($grossPriceAllowanceCharge, "getCalculationPercent");
                $grossPriceAllowanceChargeActualAmountType = $this->objectHelper->TryCallByPathAndReturn($grossPriceAllowanceCharge, "getActualAmount");
                $grossPriceAllowanceChargeIsCharge = (bool) $this->objectHelper->TryCallByPathAndReturn($grossPriceAllowanceCharge, "getChargeIndicator.getIndicator") ?? false;

                $grossPriceAllowanceChargeActualAmount = 0.0;

                if (
                    is_null($grossPriceAllowanceChargeBasisAmountType) &&
                    is_null($grossPriceAllowanceChargeCalculationPercentType) &&
                    is_null($grossPriceAllowanceChargeActualAmountType)
                ) {
                    continue;
                }

                if (!is_null($grossPriceAllowanceChargeBasisAmountType) && !is_null($grossPriceAllowanceChargeCalculationPercentType)) {
                    $grossPriceAllowanceChargeActualAmount = round(
                        ($this->objectHelper->TryCallByPathAndReturn($grossPriceAllowanceChargeBasisAmountType, "value") ?? 0.0) *
                        ($this->objectHelper->TryCallByPathAndReturn($grossPriceAllowanceChargeCalculationPercentType, "value") ?? 0.0) / 100, 2);
                } else {
                    $grossPriceAllowanceChargeActualAmount = 
                        ($this->objectHelper->TryCallByPathAndReturn($grossPriceAllowanceChargeActualAmountType, "value") ?? 0.0);
                }

                $grossPriceAllowanceChargesSum = 
                    $grossPriceAllowanceChargesSum + ($grossPriceAllowanceChargeIsCharge == false ? $grossPriceAllowanceChargeActualAmount : -$grossPriceAllowanceChargeActualAmount);
            }

            $grossPriceAmount = ($this->objectHelper->TryCallByPathAndReturn($grossPriceType, "getChargeAmount.value") ?? 0.0);
            $netPrice = $grossPriceAmount - $grossPriceAllowanceChargesSum;

            $netPriceType = $this->objectHelper->GetTradePriceType($netPrice);
            $positionagreement = $this->objectHelper->TryCallAndReturn($line, "getSpecifiedLineTradeAgreement");
            $this->objectHelper->TryCall($positionagreement, "setNetPriceProductTradePrice", $netPriceType);
        }

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
            $lineTaxes = $this->objectHelper->EnsureArray($this->objectHelper->TryCallByPathAndReturn($line, "getSpecifiedLineTradeSettlement.getApplicableTradeTax")) ?? [];

            foreach ($lineTaxes as $lineTax) {
                $vatCategory = (string) $this->objectHelper->TryCallByPathAndReturn($lineTax, "getCategoryCode.value") ?? '';
                $vatType = (string) $this->objectHelper->TryCallByPathAndReturn($lineTax, "getTypeCode.value") ?? '';
                $vatPercent = (float) $this->objectHelper->TryCallByPathAndReturn($lineTax, "getRateApplicablePercent.value") ?? 0.0;

                $vatGroupId = md5($vatCategory . $vatType . $vatPercent);

                $vatSumGrouped[$vatGroupId] = isset($vatSumGrouped[$vatGroupId]) ? $vatSumGrouped[$vatGroupId] : [$vatCategory, $vatType, $vatPercent, 0, 0];
                $vatSumGrouped[$vatGroupId][4] = $vatSumGrouped[$vatGroupId][4] + $lineAmount;
                $vatSumGrouped[$vatGroupId][3] = round($vatSumGrouped[$vatGroupId][4] * ($vatPercent / 100.0), 2);
            }
        }

        $docAllowanceCharges = $this->objectHelper->EnsureArray($this->objectHelper->TryCallByPathAndReturn($this->headerTradeSettlement, 'getSpecifiedTradeAllowanceCharge'));

        foreach ($docAllowanceCharges as $docAllowanceCharge) {
            $actualAmount = $this->objectHelper->TryCallByPathAndReturn($docAllowanceCharge, "getActualAmount.value");
            $vatCategory = (string) $this->objectHelper->TryCallByPathAndReturn($docAllowanceCharge, "getCategoryTradeTax.getCategoryCode.value") ?? '';
            $vatType = (string) $this->objectHelper->TryCallByPathAndReturn($docAllowanceCharge, "getCategoryTradeTax.getTypeCode.value") ?? '';
            $vatPercent = (float) $this->objectHelper->TryCallByPathAndReturn($docAllowanceCharge, "getCategoryTradeTax.getRateApplicablePercent.value") ?? 0.0;
            $chargeindicator = (bool) $this->objectHelper->TryCallByPathAndReturn($docAllowanceCharge, "getChargeIndicator.getIndicator") ?? false;

            $vatGroupId = md5($vatCategory . $vatType . $vatPercent);

            $vatSumGrouped[$vatGroupId] = isset($vatSumGrouped[$vatGroupId]) ? $vatSumGrouped[$vatGroupId] : [$vatCategory, $vatType, $vatPercent, 0, 0];
            $vatSumGrouped[$vatGroupId][4] = $vatSumGrouped[$vatGroupId][4] + ($chargeindicator === true ? $actualAmount : -$actualAmount);
            $vatSumGrouped[$vatGroupId][3] = round($vatSumGrouped[$vatGroupId][4] * ($vatPercent / 100.0), 2);

            $docAllowanceSum = $docAllowanceSum + ($chargeindicator === true ? 0.0 : $actualAmount);
            $docChargeSum = $docChargeSum + ($chargeindicator === true ? $actualAmount : 0.0);
        }

        $docLogisticCharges = $this->objectHelper->EnsureArray($this->objectHelper->TryCallByPathAndReturn($this->headerTradeSettlement, 'getSpecifiedLogisticsServiceCharge'));

        foreach ($docLogisticCharges as $docLogisticCharge) {
            $actualAmount = $this->objectHelper->TryCallByPathAndReturn($docLogisticCharge, "getAppliedAmount.value");
            $docChargeSum = $docChargeSum + $actualAmount;
        }

        foreach ($vatSumGrouped as $vatSumGroupedItemKey => $vatSumGroupedItem) {
            $docNetAmount = $docNetAmount + $vatSumGroupedItem[4];
            $docVatSum = $docVatSum + $vatSumGroupedItem[3];
            $this->AddDocumentTax(
                $vatSumGroupedItem[0],
                $vatSumGroupedItem[1],
                $vatSumGroupedItem[4],
                $vatSumGroupedItem[3],
                $vatSumGroupedItem[2]
            );
        }

        $summation = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getSpecifiedTradeSettlementHeaderMonetarySummation");

        $totalPrepaidAmount = $this->objectHelper->TryCallByPathAndReturn($summation, "getTotalPrepaidAmount.value") ?? 0.0;

        $this->SetDocumentSummation(
            round($docNetAmount + $docVatSum, 2),
            round($docNetAmount + $docVatSum - $totalPrepaidAmount, 2),
            round($lineTotalAmount, 2),
            round($docChargeSum, 2),
            round($docAllowanceSum, 2),
            round($docNetAmount, 2),
            round($docVatSum, 2),
            null,
            $totalPrepaidAmount
        );
    }
}
