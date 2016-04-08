<?php
/**
 * Config
 */

//Timezone default start date
define('TIMEZONE_START_DATE', '19671029T020000');

/**
 * timezones
 * @var array
 * id         = Timezone ID
 * gmt_offset = Offset from GMT time
 * daylight   = Affected by daylight savings time
 */
self::$timezones = array(
    'US-Pacific' => array(
        'gmt_offset' => -7,
        'daylight'   => TRUE
    ),
    'US-Eastern' => array(
        'gmt_offset' => -4,
        'daylight'   => TRUE
    ),
);
