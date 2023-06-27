<?php

function dateFormatSlashReverseFromddmmyyyyToyyyymmdd($date) {
    return date_format(date_create(implode("-", array_reverse(explode("/", $date)))), "Y-m-d");
}

function dateFormatSlashReverseFromddmmyyyyToyyyymmddhis($date, $hour) {
    return date_format(date_create(implode("-", array_reverse(explode("/", $date))) . " " . $hour), "Y-m-d H:i:s");
}

function dateFormatStringNoSpaceFromyyyymmddToyyymmdd($date) {
    return date_format(date_create($date), "Y-m-d");
}

function dateFormatStringNoSpaceFromddmmyyyToyyymmdd($date) {
    $day = substr($date, 0, 2);
    $month = substr($date, 2, 2);
    $year = substr($date, 4, 4);

    return  date_format(date_create($year . "-" . $month . "-" . $day), "Y-m-d"); 
}

function dateFormatSlashFromyyyymmddhisToyyymmdd($date) {
    return date_format(date_create($date), "Y-m-d");
}

function dateFormatSlashFromddmmyyyyToyyyymmdd($date) {
    $explode = explode("/", $date);
    return date_format(date_create("20" . $explode[2] . "-" . $explode[1] . "-" . $explode[0]), "Y-m-d");
}

function dateFormatStringNoSpaceFromddmmyyyyToyyyymmdd($date) {
    $day = substr($date, 0, 2);
    $month = substr($date, 2, 2);
    $year = substr($date, 4, 2);

    return date_format(date_create("20" . $year . "-" . $month . "-" . $day), "Y-m-d");
}

function dateFormatStringNoSpaceFromddmmyyyyToyyyymmddFull($date) {
    $day = substr($date, 0, 2);
    $month = substr($date, 2, 2);
    $year = substr($date, 4, 4);

    return date_format(date_create($year . "-" . $month . "-" . $day), "Y-m-d");
}

function dateFormatSlashAndDotFromddmmyyyyhisToyyyymmdd($date) {
    $space = explode(" ", $date);

    $date = explode("/", $space[0]);

    $day = $date[0];
    $month = $date[1];
    $year = $date[2];

    $dateMinute = explode(".", $space[1]);
    $hour = $dateMinute[0];
    $minute = $dateMinute[1];
    $second = $dateMinute[2];

    return date_format(date_create($year . "-" . $month . "-" . $day), "Y-m-d");
}

function dateFormatSlashAndDotFromddmmyyhiToyyyymmdd($date) {
    $space = explode(" ", $date);

    $date = explode("/", $space[0]);

    $day = $date[0];
    $month = $date[1];
    $year = $date[2];

    $dateMinute = explode(".", $space[1]);
    $hour = $dateMinute[0];
    $minute = $dateMinute[1];

    return date_format(date_create($year . "-" . $month . "-" . $day), "Y-m-d");
}

function dateFormatStringNoSpaceFromyyyymmddhisToyyymmddhis($date) {
    $day = substr($date, 6, 2);
    $month = substr($date, 4, 2);
    $year = substr($date, 0, 4);
    $hour = substr($date, 8, 2);
    $minute = substr($date, 10, 2);
    $second = substr($date, 12, 2);

    return date_format(date_create($year . "-" . $month . "-" . $day . " " . $hour . ":" . $minute . ":" . $second), "Y-m-d H:i:s");
}

?>