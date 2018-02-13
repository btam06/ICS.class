<?php
include('../vendor/autoload.php');
try {
    $ics = new Itzamna\Ics();
    $event = new Itzamna\Event();

    $ics->setProdid('prodid');

    $event->setOrganizer('organizer@mail.com');
    $event->setUid('19');
    $event->setTimezone(-7);
    $event->setStartDate('-5 days');
    $event->setEndDate('+1 days');
    $event->setSummary('Test');
    $event->setLocation('Here');
    $event->setDescription('A test event');
    $event->setCategories('Tests');

    $ics->addEvent($event);

} catch (Exception $e) {
    echo $e->getMessage();
}

echo $ics;
 ?>
