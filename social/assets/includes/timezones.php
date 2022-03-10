<?php
function SK_getTimezones()
{
    $timezones = null;
    
    if ($timezones === null)
    {
        $timezones = array();
        $offsets = array();
        $now = new DateTime();
        
        foreach (DateTimeZone::listIdentifiers() as $timezone)
        {
            $now->setTimezone(new DateTimeZone($timezone));
            $offsets[] = $offset = $now->getOffset();
            $timezones[$timezone] = '(' . SK_convertToGMT($offset) . ') ' . SK_rearrangeTimezoneName($timezone);
        }
        
        array_multisort($offsets, $timezones);
    }
    
    unset($timezones['UTC']);
    return $timezones;
}

function SK_convertToGMT($offset) {
    $hours = intval($offset / 3600);
    $minutes = abs(intval($offset % 3600 / 60));
    return 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
}

function SK_rearrangeTimezoneName($name) {
    $name = str_replace('/', ', ', $name);
    $name = str_replace('_', ' ', $name);
    $name = str_replace('St ', 'St. ', $name);
    return $name;
}
