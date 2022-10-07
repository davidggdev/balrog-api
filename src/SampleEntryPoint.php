<?php

/** davidggdev - main index controller */

namespace Balrog;
 
/**
 * Default example entry point controller
 */
class SampleEntryPoint extends BaseController
{
    /**
     * @OA\Tag(
     *     name="get",
     *     description="User related operations"
     * ) 
     */
    public function get()
    { 
        echo $this->utils->parseArrayToJson(
            $this->query('SELECT * FROM test')
        );       
    }
}
