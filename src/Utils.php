<?php

/** davidggdev - main index controller */

namespace Balrog;
 
class Utils
{
    /**
     * Parse array to json and enable exceptions on error
     */
    public function parseArrayToJson(array $collection): string
    {
        return json_encode($collection, JSON_THROW_ON_ERROR);
    }
}
