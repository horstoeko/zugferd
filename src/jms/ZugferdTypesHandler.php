<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\jms;

use JMS\Serializer\XmlSerializationVisitor;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Context;

/**
 * Class representing a collection of serialization handlers
 * for amount formatting and so on...
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdTypesHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        return [
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
        ];
    }

    public function serializeAmountType(XmlSerializationVisitor $visitor, $data, array $type, Context $context)
    {
        $node = $visitor->getDocument()->createTextNode(number_format($data->value(), 2, ".", ""));

        if ($data->getCurrencyID() != null) {
            $attr = $visitor->getDocument()->createAttribute("currencyID");
            $attr->value = $data->getCurrencyID();
            $visitor->getCurrentNode()->appendChild($attr);
        }

        return $node;
    }

    public function serializeQuantityType(XmlSerializationVisitor $visitor, $data, array $type, Context $context)
    {
        $node = $visitor->getDocument()->createTextNode(number_format($data->value(), 4, ".", ""));

        if ($data->getUnitCode() != null) {
            $attr = $visitor->getDocument()->createAttribute("unitCode");
            $attr->value = $data->getUnitCode();
            $visitor->getCurrentNode()->appendChild($attr);
        }

        return $node;
    }

    public function serializePercentType(XmlSerializationVisitor $visitor, $data, array $type, Context $context)
    {
        $node = $visitor->getDocument()->createTextNode(number_format($data->value(), 2, ".", ""));
        return $node;
    }
}
