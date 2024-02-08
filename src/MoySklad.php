<?php

namespace rare\mysklad;

use rare\mysklad\Components\Http\MoySkladHttpClient;
use rare\mysklad\Registers\EntityRegistry;

class MoySklad{

    /**
     * @var MoySkladHttpClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $hashCode;

    /**
     * @var MoySklad[]
     */
    protected static $instances = [];

    protected function __construct($access_token, $hashCode, $subdomain = "api")
    {
        $this->client = new MoySkladHttpClient($access_token, $subdomain);
        $this->hashCode = $hashCode;
    }

    /**
     * Use it instead of constructor
     * @param $login
     * @param $password
     * @param $posToken
     * @return MoySklad
     */
    public static function getInstance($access_token, $subdomain = "api", $posToken = null){
        $hash = $access_token;
        if ( empty(static::$instances[$hash]) ){
            static::$instances[$hash] = new static($access_token, $hash, $subdomain);
            EntityRegistry::instance()->bootEntities();
        }
        return static::$instances[$hash];
    }

    /**
     * Get instance with given hashcode
     * @param $hashCode
     * @return MoySklad
     */
    public static function findInstanceByHash($hashCode){
        return static::$instances[$hashCode];
    }

    /**
     * We're java now
     * @return string
     */
    public function hashCode(){
        return $this->hashCode;
    }

    /**
     * @return MoySkladHttpClient
     */
    public function getClient(){
        return $this->client;
    }

    public function setToken($access_token){
        $this->client->setToken($access_token);
    }
}
