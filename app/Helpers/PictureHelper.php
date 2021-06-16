<?php

if (! function_exists('default_profile_picture')) {
    // use this helper function to extract any data
    // as key value array/associative array (array that have index/key with string type)
    function default_profile_picture($name): string
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=E5E7EB&background=262B40';
    }
}
