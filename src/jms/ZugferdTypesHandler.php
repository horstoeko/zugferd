<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\jms;

use \DOMText;
use \DOMElement;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use horstoeko\zugferd\ZugferdSettings;
use JMS\Serializer\XmlSerializationVisitor;
use JMS\Serializer\Handler\SubscribingHandlerInterface;

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
        ];
    }

    /**
     * Serialize Anount type
     * The amounts will be serialized with a precission of 2 digits
     *
     * @param  XmlSerializationVisitor $visitor
     * @param  mixed                   $data
     * @param  array                   $type
     * @param  Context                 $context
     * @return DOMText|false
     */
    public function serializeAmountType(XmlSerializationVisitor $visitor, $data, array $type, Context $context)
    {
        $node = $visitor->getDocument()->createTextNode(
            number_format(
                $data->value(),
                ZugferdSettings::getAmountDecimals(),
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
     * The quantity will be serialized with a precission of 4 digits
     *
     * @param  XmlSerializationVisitor $visitor
     * @param  mixed                   $data
     * @param  array                   $type
     * @param  Context                 $context
     * @return DOMText|false
     */
    public function serializeQuantityType(XmlSerializationVisitor $visitor, $data, array $type, Context $context)
    {
        $node = $visitor->getDocument()->createTextNode(
            number_format(
                $data->value(),
                ZugferdSettings::getQuantityDecimals(),
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
     * The valze will be serialized with a precission of 2 digits
     *
     * @param  XmlSerializationVisitor $visitor
     * @param  mixed                   $data
     * @param  array                   $type
     * @param  Context                 $context
     * @return DOMText|false
     */
    public function serializePercentType(XmlSerializationVisitor $visitor, $data, array $type, Context $context)
    {
        $node = $visitor->getDocument()->createTextNode(
            number_format(
                $data->value(),
                ZugferdSettings::getPercentDecimals(),
                ZugferdSettings::getDecimalSeparator(),
                ZugferdSettings::getThousandsSeparator()
            )
        );

        return $node;
    }

    /**
     * Serialize a inditcator
     * False and true values will be serialized correctly (false won't be serialized
     * in the default implementation)
     *
     * @param  XmlSerializationVisitor $visitor
     * @param  mixed                   $data
     * @param  array                   $type
     * @param  Context                 $context
     * @return DOMElement|false
     */
    public function serializeIndicatorType(XmlSerializationVisitor $visitor, $data, array $type, Context $context)
    {
        $node = $visitor->getDocument()->createElement('udt:Indicator', $data->getIndicator() == false ? 'false' : 'true');
        return $node;
    }
}
