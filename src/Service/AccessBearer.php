<?php

namespace BIMData\IntentClient\Service;

class AccessBearer {

    protected $client_id;
    protected $client_secret;
    protected $bearer = null;
    protected $bearer_validity = null;

    protected $token_storage;

    function __construct($client_id, $client_secret, $token_storage)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->token_storage = $token_storage;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @return mixed
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    protected function fetchBearer(){
        $bearer = $this->token_storage->fetch('bearer');
        $this->bearer = (isset($bearer['intent_token']))?$bearer['intent_token']: false;
        $this->bearer_validity = (isset($bearer['intent_token_validity']))?$bearer['intent_token_validity']: false;
    }
    /**
     * @return mixed
     */
    public function getBearer()
    {
        if(is_null($this->bearer)){
            $this->fetchBearer();
        }

        if($this->bearer === false || $this->bearer_validity < time()){
            return false;
        }

        return $this->bearer;
    }

    public function setBearer($bearer, $expires_in){
        $this->bearer = $bearer;
        $this->bearer_validity = time()+$expires_in;
        $this->token_storage->save('bearer', array(
            'intent_token' => $this->bearer,
            'intent_token_validity' => $this->bearer_validity
        ));
    }
}