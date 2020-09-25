<?php 
namespace Itzamna;
?>
BEGIN:VCALENDAR
VERSION:2.0
PRODID:<?= $prodid ?>

<?php foreach ($events as $event) { ?>
BEGIN:VEVENT
UID:<?= $event->getICSUid() ?>

DTSTAMP:<?= $formatDate($timestamp, Ics::DEFAULT_TIMEZONE) ?>

<?php if ($event->getICSStartDate() !== NULL) { ?>
DTSTART:<?= $formatDate($event->getICSStartDate(), $event->getICSTimezone()) ?>

<?php } ?>
<?php if ($event->getICSEndDate() !== NULL) { ?>
DTEND:<?= $formatDate($event->getICSEndDate(), $event->getICSTimezone()) ?>

<?php } ?>
SUMMARY: <?= $formatText($event->getICSSummary()) ?>

<?php if ($event->getICSLocation()) { ?>
LOCATION: <?= $formatText($event->getICSLocation()) ?>

<?php } ?>
DESCRIPTION: <?= $formatText($event->getICSDescription()) ?>

ORGANIZER:MAILTO: <?= $event->getICSOrganizer() ?>

<?php if ($event->getICSCategories()) { ?>
CATEGORIES: <?= $event->getICSCategories() ?>

<?php } ?>
CLASS:PUBLIC
END:VEVENT
<?php } ?>
END:VCALENDAR
