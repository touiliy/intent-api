<?php
namespace BIMData\Intent\Service;

use BIMData\Intent\Data\Snapshot;
use BIMData\Intent\Exception;
use GuzzleHttp\Psr7\Response;

class Site extends \BIMData\Intent\Service{

    protected $site_name;

    const TYPE_SNAPSHOT = 'snapshot';

    function __construct($site_name, $client, $end_point = 'https://api.hubintent.com/api/datahub/v1')
    {
        parent::__construct($client, $end_point);

        $this->site_name = $site_name;
    }


    static function getConfigResources()
    {
        $path_prefix = '/sites/{site}';

        return array(
            'activities' => array(
                'path' => $path_prefix.'/activities',
            ),
            'activity' => array(
                'path' => $path_prefix.'/activities/{activity}/{type}',
            )
        );
    }

    public function activities(){
        /** @var Response $response */
        $response = $this->call('GET', 'Site', 'activities', $this->addServiceParams(array()));

        return json_decode($response->getBody());
    }

    public function activity($activity, $type, \DateTime $startTime = null, \DateTime $endTime = null, $page = 1, $countByPage = 10){
        $params = array(
            'activity' => $activity,
            'type' => $type,
            'page' => $page,
            'countByPage' => $countByPage
        );

        if(!is_null($startTime)){
            $params['startTime'] = $startTime->format('Y-m-d H:i:s');
        }

        if(!is_null($endTime)){
            $params['endTime'] = $endTime->format('Y-m-d H:i:s');
        }

        /** @var Response $response */
        $response = $this->call('GET', 'Site', 'activity', $this->addServiceParams($params));

        $activity = json_decode($response->getBody());

        $data = $activity->data;
        $activity->data = array();
        foreach($data as $d){
            switch($type){
                case self::TYPE_SNAPSHOT:
                    $activity->data[] = new Snapshot($d->timestamp, $d->trustlevel, $d->value);
                    break;
                default:
                    throw new Exception('Type "'.$type.'" not supported');
                    break;
            }
        }

        return $activity;
    }

    public function addServiceParams($params = array()){
        $params['site'] = $this->site_name;

        return $params;
    }
}