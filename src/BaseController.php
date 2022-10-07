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

    /**
     * Create inner instances
     */
    public function __construct()
    { 
        $this->utils = new Utils();

        $this->database = new Database();
    } 
}
