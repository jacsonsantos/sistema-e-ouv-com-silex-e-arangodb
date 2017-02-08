<?php
/**
 * User: Jacson Santos
 * Date: 08/02/2017
 * Time: 15:48
 */
namespace Jss\Refactor;

use triagens\ArangoDb\Document;

class ExtractDocument
{
    /**
     * @var array|Document
     */
    private $doc = [];

    private $property = \ReflectionProperty::IS_PROTECTED;

    /**
     * ExtractDocument constructor.
     * @param Document $document
     */
    public function __construct($document)
    {
        if ( !($document instanceof Document) || !(is_array($document)) ) {
            return "error";
        }

        if (is_array($document)) {
            $this->doc = $document;
        }

        if ($document instanceof Document) {
            $this->doc = $document;
        }
    }

    public function setReflectionProperty($reflectionProperty)
    {
        $this->property = $reflectionProperty;
        return $this;
    }

    private function getProps()
    {
        if (is_array($this->doc)) {
            foreach ($this->doc as $doc) {
                $reflect = new ReflectionClass($this->doc);
                $this->props[]   = $reflect->getProperties($this->property);
            }
        }

        if ($this->doc instanceof Document) {
            $reflect = new ReflectionClass($this->doc);
            $this->props   = $reflect->getProperties($this->property);
        }

        return $this;
    }
}