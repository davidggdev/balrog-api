<?php

/** davidggdev - main index controller */

namespace Balrog;

/**
 * Base constructor scaffold default entry points controllers
 */
class BaseController
{

    /**
     * @var Utils   $utils  Utils instance
     */
    protected ?Utils $utils = null;

    /**
     * @var Database   $database  Database instance
     */
    protected ?Database $database = null;

    protected $predisClient = null;
    /**
     * Create inner instances
     */
    public function __construct()
    {
        $this->utils = new Utils();

        $this->database = new Database();

        $this->predisClient = new \Predis\Client();
    }

    protected function setResponse(array $collection, string $predisPredefKey = "")
    {
        if ($this->isPredis()) {
            $class = get_class($this);
            $method = debug_backtrace(!DEBUG_BACKTRACE_PROVIDE_OBJECT | DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['function'];
            $predisKey = ($predisPredefKey !== '') ? $predisPredefKey : $class . '_' . $method;
             
        }
        return [$predisKey];
    }

    protected function isPredis()
    {
        return class_exists('\Predis\Client');
    }
  
    protected function setPredisValue(string $key, string $value)
    {
        $this->predisClient->set($key, $value);
    }

    protected function getPredisValue(string $key)
    {
        return $this->predisClient->get($key);
    }

    protected function query(string $query) : array
    {
        $class = get_class($this);
        $method = debug_backtrace(!DEBUG_BACKTRACE_PROVIDE_OBJECT | DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['function'];
        $predisKey = $class . '_' . $method;

        if ($this->isPredis()) { 
            if($response = $this->getPredisValue($predisKey)){        
               $result = json_decode($response); 
            } else {
                $result = $this->database->query($query); 
                $this->setPredisValue($predisKey, json_encode($result));
            }
        } else {
            $result = $this->database->query($query); 
        }
        return $result;
    }
}
