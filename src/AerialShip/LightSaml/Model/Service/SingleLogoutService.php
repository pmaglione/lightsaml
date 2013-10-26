<?php

namespace AerialShip\LightSaml\Model\Service;

use AerialShip\LightSaml\Binding;
use AerialShip\LightSaml\Error\InvalidXmlException;
use AerialShip\LightSaml\Protocol;


class SingleLogoutService extends AbstractService
{

    function getXml(\DOMNode $parent) {
        $result = $parent->ownerDocument->createElementNS(Protocol::NS_METADATA, 'md:SingleLogoutService');
        $parent->appendChild($result);
        $result->setAttribute('Binding', $this->getBinding());
        $result->setAttribute('Location', $this->getLocation());
        return $result;
    }

    /**
     * @param \DOMElement $xml
     * @throws \AerialShip\LightSaml\Error\InvalidXmlException
     * @return \DOMElement[]
     */
    function loadFromXml(\DOMElement $xml) {
        if ($xml->localName != 'SingleLogoutService' || $xml->namespaceURI != Protocol::NS_METADATA) {
            throw new InvalidXmlException('Expected SingleLogoutService element and '.Protocol::NS_METADATA.' namespace but got '.$xml->localName);
        }
        return parent::loadFromXml($xml);
    }


    /**
     * @param \DOMElement $root
     * @throws \AerialShip\LightSaml\Error\InvalidXmlException
     * @return \DOMElement[] unknown elements
     */
    public function loadXml(\DOMElement $root) {
        if (!$root->hasAttribute('Binding')) {
            throw new InvalidXmlException("Missing Binding attribute");
        }
        if (!$root->hasAttribute('Location')) {
            throw new InvalidXmlException("Missing Location attribute");
        }
        $this->setBinding($root->getAttribute('Binding'));
        $this->setLocation($root->getAttribute('Location'));
        return array();
    }


}