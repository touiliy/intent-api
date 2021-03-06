<?php

namespace BIMData\Intent;

abstract class Service {
    /** @var Client */
    protected $client;
    protected $end_point;
    protected $end_point_oauth;

    function __construct($client, $end_point = 'https://api.hubintent.com/api/datahub/v1', $end_point_oauth = 'https://accounts.hubintent.com/oauth/token')
    {
        $this->client = $client;
        $this->http_client = new \GuzzleHttp\Client();
        $this->end_point = $end_point;
        $this->end_point_oauth = $end_point_oauth;
    }

    function call($httpMethod, $service_name, $service_method, $params = array()){
        if(!$this->client->getBearer()){
            $options = [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->client->getClientId(),
                    'client_secret' => $this->client->getClientSecret()
                ],
                'http_errors' => false
            ];

            $response = $this->http_client->request('POST', $this->end_point_oauth, $options);

            if($response->getStatusCode() != 200){
                throw new Exception('Can\'t fetch access token');
            }

            $json = json_decode($response->getBody());

            $this->client->setBearer($json->access_token, $json->expires_in);
        }

        $path = self::getPath($service_name, $service_method);

        $first_get = false;
        foreach($params as $name => $value){
            $search = '{'.$name.'}';
            if(stripos($path, $search)){
                $path = str_ireplace($search, $value, $path);
            }else{
                if(mb_strtoupper($httpMethod) == 'GET'){
                    $path .= ((!$first_get)?'?':'&').$name.'='.$value;
                    $first_get = true;
                }
            }
        }

        return $this->http_client->request($httpMethod, $this->end_point.$path, [
            'headers' => $this->getHeaders()
        ]);
    }

    function getHeaders(){
        $headers = array();
        if($this->client->getBearer()){
            $headers['Authorization'] = 'Bearer '.$this->client->getBearer();
        }
        return $headers;
    }

    function getPath($service_name, $service_method){
        $className = '\\BIMData\\Intent\\Service\\'.$service_name;
        if(!class_exists($className)){
            throw new Exception('"'.$service_name.'" Service doesn\'t exist');
        }

        $config = $className::getConfigResources();

        if(!isset($config[$service_method])){
            throw new Exception('Method "'.$service_method.'" of "'.$service_name.'" Service doesn\'t exist');
        }

        return $config[$service_method]['path'];
    }
}