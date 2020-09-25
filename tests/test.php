<?php
include('../vendor/autoload.php');
try {
    $ics = new Itzamna\Ics();
    $event = new Itzamna\Event();

    $ics->setICSProdid('Itzamna Events');

    $event->setICSOrganizer('organizer@mail.com');
    $event->setICSUid('19');
    $event->setICSTimezone(-7);
    $event->setICSStartDate('-5 days');
    $event->setICSEndDate('+1 days');
    $event->setICSSummary('Test');
    $event->setICSLocation('Here');
    $event->setICSDescription('A test event');
    $event->setICSCategories('Tests');

    $ics->addEvent($event);

} catch (Exception $e) {
    echo $e->getMessage();
}

echo $ics->make();
 ?>
