<?php
namespace BIMData\Intent\Token\Storage;

class Session implements TokenInterface{
    function __construct()
    {
        session_start();
    }

    public function fetch($var)
    {
        return (isset($_SESSION[$var]))?unserialize($_SESSION[$var]):false;
    }

    public function save($var, $data)
    {
        $_SESSION[$var] = serialize($data);
    }

}