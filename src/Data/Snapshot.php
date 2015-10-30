<?php

namespace BIMData\Intent\Data;

use BIMData\Intent\Exception;

class Snapshot{
    protected $value;
    protected $date;
    protected $trustLevel;

    const TRUSTLEVEL_SENSOR = 'SENSOR';
    const TRUSTLEVEL_MANUAL = 'MANUAL';
    const TRUSTLEVEL_TRUSTED_SENSOR = 'TRUSTED_SENSOR';
    const TRUSTLEVEL_TRUSTED_MANUAL = 'TRUSTED_MANUAL';
    const TRUSTLEVEL_ESTIMATE = 'ESTIMATE';

    function __construct($timestamp, $trustLevel, $value)
    {
        $date = new \DateTime();
        $date->setTimestamp($timestamp/1000);

        if(!in_array($trustLevel, array(self::TRUSTLEVEL_ESTIMATE, self::TRUSTLEVEL_MANUAL, self::TRUSTLEVEL_TRUSTED_MANUAL, self::TRUSTLEVEL_TRUSTED_SENSOR, self::TRUSTLEVEL_SENSOR))){
            throw new Exception('"'.$trustLevel.'" is not a TrustLevel ');
        }
        $this->date = $date;
        $this->trustLevel = $trustLevel;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getTrustLevel()
    {
        return $this->trustLevel;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }


}