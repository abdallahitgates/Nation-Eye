<?php

namespace App\Exceptions;

use Exception;
use ReflectionClass;

class BalaghatException extends Exception
{
    protected $data = null;
    protected $type = null;

    public function __construct($data, $type = null)
    {
        parent::__construct('BalaghatException : ', 1);
        $this->data = $data;
        $this->type = $type ?: $this;
    }

    public function getData()
    {
        $className = (new ReflectionClass($this->type))->getName();
        return [$className => $this->data];
    }
}
