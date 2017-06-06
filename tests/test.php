<?php
include('../vendor/autoload.php');
include('../Ics.php');
try {
    $ics = new Itzamna\Ics(array(
        'organizer'   => 'noreply@imarc.net',
        'uid'         => NULL,
        'prodid'      => NULL,
        'timezone'    => 'Eastern',
        'start_date'  => '2016-04-07 5:00:00',
        'end_date'    => '2016-04-07 6:00:00',
        'summary'     => 'test',
        'location'    => NULL,
        'description' => NULL,
        'categories'  => NULL
    ));
} catch (Exception $e) {
    echo $e->getMessage();
}

echo $ics;
 ?>
