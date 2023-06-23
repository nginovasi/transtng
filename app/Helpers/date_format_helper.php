<?php

function dateFormatNonSpaceyyyymmddhhmmss($date) {
    $day = substr($date, 6, 2);
    $month = substr($date, 4, 2);
    $year = substr($date, 0, 4);
    $hour = substr($date, 8, 2);
    $minute = substr($date, 10, 2);
    $second = substr($date, 12, 2);

    return $year . "-" . $month . "-" . $day . " " . $hour . ":" . $minute . ":" . $second;
}

function dateFormatYY($date) {
    $day = substr($date, 0, 2);
    $month = substr($date, 2, 2);
    $year = substr($date, 4, 2);

    return "20" . $year . "-" . $month . "-" . $day;
}

function dateFormatYYSlash($date) {
    $explode = explode("/", $date);

    return "20" . $explode[2] . "-" . $explode[1] . "-" . $explode[0];
}

function dateFormat00($date) {
    $day = substr($date, 0, 2);
    $month = substr($date, 2, 2);
    $year = substr($date, 4, 4);
    $hour = substr($date, 8, 2);
    $minute = substr($date, 10, 2);

    return $year . "-" . $month . "-" . $day . " " . $hour . ":" . $minute . ":00"; 
}

function dateFormatSlashAndDot($date) {
    $space = explode(" ", $date);

    $date = explode("/", $space[0]);

    $day = $date[0];
    $month = $date[1];
    $year = $date[2];

    $dateMinute = explode(".", $space[1]);
    $hour = $dateMinute[0];
    $minute = $dateMinute[1];
    $second = $dateMinute[2];

    return $year . "-" . $month . "-" . $day . " " . $hour . ":" . $minute . ":" . $second;
}

function dateFormat00SlashAndDot($date) {
    $space = explode(" ", $date);

    $date = explode("/", $space[0]);

    $day = $date[0];
    $month = $date[1];
    $year = $date[2];

    $dateMinute = explode(".", $space[1]);
    $hour = $dateMinute[0];
    $minute = $dateMinute[1];

    return $year . "-" . $month . "-" . $day . " " . $hour . ":" . $minute . ":00";
}

?>