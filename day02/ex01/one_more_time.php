#!/usr/bin/php
<?php

if ($argc == 2)
{
    date_default_timezone_set("Europe/Paris");
    $split = explode(' ', preg_replace('/ +/', ' ', trim($argv[1])));
    $tab_days = array("Lundi", "Mardi", "Mercedi", "Jeudi", "Vendredi",
                    "Samedi", "Dimanche");
    $tab_months = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
                        "Juillet", "Août", "Septembre", "Octobre", "Novembre");
    $week_day = $split[0];
    $curr_time = explode(':', preg_replace('/ +/', ' ', trim($split[4])));
    $curr_hour = $curr_time[0];
    $curr_min = $curr_time[1];
    $curr_sec = $curr_time[2];
    $nb_of_day = $split[1];
    $curr_month = $split[2];
    $curr_year = $split[3];
    if (array_search($curr_month, $tab_months) && array_search($week_day, $tab_days) &&
        is_numeric($curr_hour) && is_numeric($curr_min) && is_numeric($curr_sec) &&
        is_numeric($nb_of_day) && is_numeric($curr_year) && strlen($curr_hour) == 2 &&
        strlen($curr_min) == 2 && strlen($curr_sec) == 2 && strlen($curr_year) == 4 &&
        (strlen($nb_of_day) == 1 || strlen($nb_of_day) < 3) && $curr_hour >= 00 &&
        $curr_hour < 24 && $curr_min >= 00 && $curr_min < 60 && $curr_sec >= 00 &&
        $curr_sec < 60 && $curr_year >= 1970 && $nb_of_day > 0 && $nb_of_day < 32)
    {
        foreach ($tab_months as $key => $value)
            if ($curr_month == $value)
                $curr_month = $key + 1;
        if (is_numeric($curr_month))
            echo mktime($curr_hour, $curr_min, $curr_sec, $curr_month, $nb_of_day, $curr_year)."\n";
    }
    else
        echo "Wrong Format\n";
}

?>