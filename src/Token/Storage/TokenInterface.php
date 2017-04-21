<?php
namespace BIMData\IntentClient\Token\Storage;

interface TokenInterface{
    public function fetch($var);

    public function save($var, $data);
}