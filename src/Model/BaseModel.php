<?php
namespace BRTNetwork\BRTBinaryCodec\Model;

abstract class BaseModel
{
    protected $attributes = [];

    public function __get($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    public function __set($name, $value)
    {
        return $this->attributes[$name] = $value;
    }
}
