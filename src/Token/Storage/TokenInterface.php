<?php
namespace BIMData\Intent\Token\Storage;

interface TokenInterface{
    public function fetch($var);

    public function save($var, $data);
}