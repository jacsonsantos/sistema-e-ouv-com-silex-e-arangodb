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
        return new CollectionHandler($this->app['connection']);
    }

    /**
     * @return Collection
     */
    private function collection()
    {
        return new Collection();
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
        return ($this->collectionHandler())->drop($nameCollection,$data);
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

            return ($this->collectionHandler())->create($collection);
        }

        return null;
    }

    /**
     * @return DocumentHandler
     */
    private function documentHandler()
    {
        return new DocumentHandler($this->app['connection']);
    }

    /**
     * @return Document
     */
    private function document()
    {
        return new Document();
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

        $this->lastInsertId = ($this->documentHandler())->save($nameCollection,$document);

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
        return ($this->documentHandler())->has($nameCollection,$id);
    }

    /**
     * @param $nameCollection
     * @param $id
     * @return Document
     */
    public function getDocument($nameCollection, $id)
    {
        return ($this->documentHandler())->get($nameCollection,$id);
    }

    /**
     * @param $nameCollection
     * @param array $document [ "key" => "needle"]
     * @return \triagens\ArangoDb\cursor
     */
    public function searchDocument($nameCollection, array $document)
    {
        return ($this->collectionHandler())->byExample($nameCollection,$document);
    }
}