<?php

if(!function_exists('submission_status_color')) {
    function submission_status_color(String $status): String
    {
        switch ($status) {
            case "ACCEPTED":
                return "success";
            case "REJECTED":
                return "danger";
            default:
                return "primary";
        }
    }
}
