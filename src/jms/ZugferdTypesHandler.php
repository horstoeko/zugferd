<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\jms;

use horstoeko\zugferd\ZugferdSettings;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\XmlSerializationVisitor;

/**
 * Class representing a collection of serialization handlers for amount formatting and so on
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdTypesHandler implements SubscribingHandlerInterface
{
    /**
     * Return format:
     *
     *      array(
     *          array(
     *              'direction' => GraphNavigatorInterface::DIRECTION_SERIALIZATION,
     *              'format' => 'json',
     *              'type' => 'DateTime',
     *              'method' => 'serializeDateTimeToJson',
     *          ),
     *      )
     *
     * @return array
     */
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\minimum\udt\AmountType',
                'method' => 'serializeAmountType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\basic\udt\AmountType',
                'method' => 'serializeAmountType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\basicwl\udt\AmountType',
                'method' => 'serializeAmountType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\en16931\udt\AmountType',
                'method' => 'serializeAmountType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\extended\udt\AmountType',
                'method' => 'serializeAmountType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\basic\udt\QuantityType',
                'method' => 'serializeQuantityType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\basicwl\udt\QuantityType',
                'method' => 'serializeQuantityType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\en16931\udt\QuantityType',
                'method' => 'serializeQuantityType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\extended\udt\QuantityType',
                'method' => 'serializeQuantityType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\basic\udt\PercentType',
                'method' => 'serializePercentType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\basicwl\udt\PercentType',
                'method' => 'serializePercentType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\en16931\udt\PercentType',
                'method' => 'serializePercentType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\extended\udt\PercentType',
                'method' => 'serializePercentType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\basic\udt\IndicatorType',
                'method' => 'serializeIndicatorType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\basicwl\udt\IndicatorType',
                'method' => 'serializeIndicatorType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\en16931\udt\IndicatorType',
                'method' => 'serializeIndicatorType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\extended\udt\IndicatorType',
                'method' => 'serializeIndicatorType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\basic\udt\MeasureType',
                'method' => 'serializeMeasureType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\basicwl\udt\MeasureType',
                'method' => 'serializeMeasureType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\en16931\udt\MeasureType',
                'method' => 'serializeMeasureType'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'horstoeko\zugferd\entities\extended\udt\MeasureType',
                'method' => 'serializeMeasureType'
            ],
        ];
    }

    /**
     * Serialize Anount type
     * The amounts will be serialized (by default) with a precission of 2 digits
     *
     * @param XmlSerializationVisitor $visitor
     * @param mixed                   $data
     */
    public function serializeAmountType(XmlSerializationVisitor $visitor, $data)
    {
        $node = $visitor->getDocument()->createTextNode(
            number_format(
                $data->value(),
                ZugferdSettings::getSpecialDecimalPlacesMap($visitor->getCurrentNode()->getNodePath(), ZugferdSettings::getAmountDecimals()),
                ZugferdSettings::getDecimalSeparator(),
                ZugferdSettings::getThousandsSeparator()
            )
        );

        if ($data->getCurrencyID() != null) {
            $attr = $visitor->getDocument()->createAttribute("currencyID");
            $attr->value = $data->getCurrencyID();
            $visitor->getCurrentNode()->appendChild($attr);
        }

        return $node;
    }

    /**
     * Serialize quantity type
     * The quantity will be serialized (by default) with a precission of 2 digits
     *
     * @param XmlSerializationVisitor $visitor
     * @param mixed                   $data
     */
    public function serializeQuantityType(XmlSerializationVisitor $visitor, $data)
    {
        $node = $visitor->getDocument()->createTextNode(
            number_format(
                $data->value(),
                ZugferdSettings::getSpecialDecimalPlacesMap($visitor->getCurrentNode()->getNodePath(), ZugferdSettings::getQuantityDecimals()),
                ZugferdSettings::getDecimalSeparator(),
                ZugferdSettings::getThousandsSeparator()
            )
        );

        if ($data->getUnitCode() != null) {
            $attr = $visitor->getDocument()->createAttribute("unitCode");
            $attr->value = $data->getUnitCode();
            $visitor->getCurrentNode()->appendChild($attr);
        }

        return $node;
    }

    /**
     * Serialize a percantage value
     * The valze will be serialized (by default) with a precission of 2 digits
     *
     * @param XmlSerializationVisitor $visitor
     * @param mixed                   $data
     */
    public function serializePercentType(XmlSerializationVisitor $visitor, $data)
    {
        return $visitor->getDocument()->createTextNode(
            number_format(
                $data->value(),
                ZugferdSettings::getSpecialDecimalPlacesMap($visitor->getCurrentNode()->getNodePath(), ZugferdSettings::getPercentDecimals()),
                ZugferdSettings::getDecimalSeparator(),
                ZugferdSettings::getThousandsSeparator()
            )
        );
    }

    /**
     * Serialize a meassure value
     * The valze will be serialized (by default) with a precission of 2 digits
     *
     * @param XmlSerializationVisitor $visitor
     * @param mixed                   $data
     */
    public function serializeMeasureType(XmlSerializationVisitor $visitor, $data)
    {
        $node = $visitor->getDocument()->createTextNode(
            number_format(
                $data->value(),
                ZugferdSettings::getSpecialDecimalPlacesMap($visitor->getCurrentNode()->getNodePath(), ZugferdSettings::getMeasureDecimals()),
                ZugferdSettings::getDecimalSeparator(),
                ZugferdSettings::getThousandsSeparator()
            )
        );

        if ($data->getUnitCode() != null) {
            $attr = $visitor->getDocument()->createAttribute("unitCode");
            $attr->value = $data->getUnitCode();
            $visitor->getCurrentNode()->appendChild($attr);
        }

        return $node;
    }

    /**
     * Serialize a inditcator
     * False and true values will be serialized correctly (false won't be serialized
     * in the default implementation)
     *
     * @param XmlSerializationVisitor $visitor
     * @param mixed                   $data
     */
    public function serializeIndicatorType(XmlSerializationVisitor $visitor, $data)
    {
        return $visitor->getDocument()->createElement('udt:Indicator', $data->getIndicator() == false ? 'false' : 'true');
    }
}
