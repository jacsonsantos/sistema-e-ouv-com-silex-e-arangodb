<?php
namespace JSantos\Model;
/**
 * Created by PhpStorm.
 * User: jacson Santos
 * Date: 13/01/2017
 * Time: 15:57
 */
use Silex\Application;
use triagens\ArangoDb\Collection;
use triagens\ArangoDb\CollectionHandler;
use triagens\ArangoDb\DocumentHandler;
use triagens\ArangoDb\Document;

class ArangoModel
{
    private $app;

    private $lastInsertId = null;

    private $collectionHandler;

    private $collection;

    private $documentHandler;

    private $document;

    /**
     * ArangoModel constructor.
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->app = $application;
    }

    /**
     * @return CollectionHandler
     */
    private function collectionHandler()
    {
        if (!$this->collectionHandler) {
            $this->collectionHandler = new CollectionHandler($this->app['connection']);
        }
        return $this->collectionHandler;
    }

    /**
     * @return Collection
     */
    private function collection()
    {
        if(!$this->collection) {
            $this->collection = new Collection();
        }
        return $this->collection;
    }

    /**
     * @param String $nameCollection
     * @return bool
     */
    public function hasCollection($nameCollection)
    {
        $collectionHandler = $this->collectionHandler();
        return $collectionHandler->has($nameCollection);
    }

    /**
     * @param $nameCollection
     * @param array $data
     * @return bool
     */
    public function deleteCollection($nameCollection, array $data = [])
    {
        $collectionHandler = $this->collectionHandler();
        return $collectionHandler->drop($nameCollection,$data);
    }

    /**
     * @param $newCollection
     * @return mixed|null
     */
    public function createCollection($newCollection)
    {
        if (!$this->hasCollection($newCollection)) {
            $collection = $this->collection();
            $collection->setName($newCollection);

            $collectionHandler = $this->collectionHandler();
            return $collectionHandler->create($collection);
        }
        return null;
    }

    /**
     * @return DocumentHandler
     */
    private function documentHandler()
    {
        if (!$this->documentHandler) {
            $this->documentHandler = new DocumentHandler($this->app['connection']);
        }
        return $this->documentHandler;
    }

    /**
     * @return Document
     */
    private function document()
    {
        if (!$this->document) {
            $this->document = new Document();
        }
        return $this->document;
    }

    /**
     * @param $nameCollection
     * @param array $data
     * @return mixed
     */
    public function createDocument($nameCollection, array $data = [])
    {
        $document = $this->document();

        foreach ($data as $key => $value) {
            $document->set($key,$value);
        }
        $documentHandler = $this->documentHandler();
        $this->lastInsertId = $documentHandler->save($nameCollection,$document);

        return $this->lastInsertId;
    }

    /**
     * @return null|id
     */
    public function lastInsertId()
    {
        return $this->lastInsertId;
    }

    /**
     * @param $nameCollection
     * @param $id
     * @return bool
     */
    public function hasDocument($nameCollection, $id)
    {
        $documentHandler = $this->documentHandler();
        return $documentHandler->has($nameCollection,$id);
    }

    /**
     * @param $nameCollection
     * @param $id
     * @return Document
     */
    public function getDocument($nameCollection, $id)
    {
        $documentHandler = $this->documentHandler();
        return $documentHandler->get($nameCollection,$id);
    }

    /**
     * @param $nameCollection
     * @param array $document [ "key" => "needle"]
     * @return \triagens\ArangoDb\cursor
     */
    public function searchDocument($nameCollection, array $document)
    {
        $collectionHandler = $this->collectionHandler();
        return $collectionHandler->byExample($nameCollection,$document);
    }
}