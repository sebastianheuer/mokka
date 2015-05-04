<?php
namespace Mokka\Comparator;

class DomNodeComparator implements ComparatorInterface
{
    /**
     * @param mixed $a
     * @param mixed $b
     * @return boolean
     */
    public function isEqual($a, $b)
    {
        return $this->_getComparableXmlString($a) === $this->_getComparableXmlString($b);
    }

    private function _getComparableXmlString(\DOMNode $node)
    {
        if ($node instanceof \DOMDocument) {
            return $node->C14N();
        }
        $dom = new \DOMDocument();
        $dom->appendChild($dom->importNode($node, true));

        return $dom->C14N();
    }


}