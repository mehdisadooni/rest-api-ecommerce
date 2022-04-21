<?php
use Carbon\Carbon;

if (!function_exists('generateFileName')){
    /** Generate name for files to be stored, with time use Carbon Library
     *  and original file name at the end of generated name
     * @param $name
     * @return string
     */
    function generateFileName($name)
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $day = Carbon::now()->day;
        $hour = Carbon::now()->hour;
        $minute = Carbon::now()->minute;
        $second = Carbon::now()->second;
        $microsecond = Carbon::now()->microsecond;
        return $year . '_' . $month . '_' . $day . '_' . $hour . '_' . $minute . '_' . $second . '_' . $microsecond . '_' . $name;
    }
}
