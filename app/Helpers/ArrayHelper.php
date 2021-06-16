<?php

if (! function_exists('to_assoc_array')) {
    // use this helper function to extract any data
    // as key value array/associative array (array that have index/key with string type)
    function to_assoc_array($arr): array
    {
        $assoc = [];
        foreach($arr as $data) {
            $assoc[$data->key] = $data;
        }
        return $assoc;
    }
}
