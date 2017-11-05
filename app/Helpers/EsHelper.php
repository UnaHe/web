<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 2017/11/05
 * Time: 14:46
 */
namespace App\Helpers;

use Elasticsearch\ClientBuilder;

class EsHelper
{
    private $client;

    public function __construct(){
        $this->client = ClientBuilder::create()
            ->setHosts(config("elasticsearch.hosts"))
            ->setRetries(2)
            ->build();
    }

    public function client(){
        return $this->client;
    }

    public function search($data, $raw=false){
        $results = $this->client->search($data);
        if(!$raw){
            $retData = [];
            foreach ($results['hits']['hits'] as $result){
                $retData[] = $result['_source'];
            }
        }else{
            $retData = $results;
        }

        return $retData;
    }
}