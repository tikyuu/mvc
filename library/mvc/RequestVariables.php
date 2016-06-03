<?php

/**
* 
*/
abstract class RequestVariables
{
    protected $_values;

    function __construct()
    {
        $this->setValues();
    }

    abstract protected function setValues();

    public function get($key = null)
    {
        $ret = null;
        if (null == $key) {
            $ret = $this->_values;
        } else {
            if (true == $this->has($key)) {
                $ret = $this->_values[$key];
            }
        }

        return $ret;
    }

    public function has($key)
    {
        if (false == array_key_exists($key, $this->_values)) {
            return false;
        }
        return true;
    }
}