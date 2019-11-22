<?php
    function strtodatetime($time, $format = "Y-m-d H:i:s") {
        return date($format, strtotime($time));
    }
?>