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
        $data0 = $this->database->query('SELECT * FROM test');
        
        $data = $this->database->select(
            ['id','url'],
            'test'
        );

        // $data2 = $this->database->select(
        //     ['*'],
        //     'test', 
        //     ['id' => 2]
        // );
        
        echo $this->utils->parseArrayToJson($data);
        // echo $this->utils->parseArrayToJson($data);
        // echo $this->utils->parseArrayToJson($data2);
    }
}
