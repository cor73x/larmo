<?php

namespace FP\Larmo\Infrastructure\Adapter;

class MongoDbStorage
{
    private $connection;

    public function __construct($url, $port, $user, $password, $db, array $options = [])
    {
        if ($user) {
            $server = "mongodb://$user:$password@$url:$port/$db";
        } else {
            $server = "mongodb://$url:$port/$db";
        }
        $mongoClient = new \MongoClient($server, $options);

        $this->connection = $mongoClient->selectDB($db);
    }

    public function batchInsert($collection, array $data)
    {
        return $this->connection->{$collection}->batchInsert($data);
    }

    public function find($collection, $find = array())
    {
        return $this->connection->{$collection}->find($find);
    }
}