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
<?php if ($event->getICSLocation()) { ?>
LOCATION: <?= $formatText($event->getICSLocation()) ?>

<?php } ?>
<?php if ($event->getICSOrganizer()) { ?>
ORGANIZER:MAILTO: <?= $event->getICSOrganizer() ?>

<?php } ?>
<?php if ($event->getICSCategories()) { ?>
CATEGORIES: <?= $event->getICSCategories() ?>

<?php } ?>
SUMMARY: <?= $formatText($event->getICSSummary()) ?>

DESCRIPTION: <?= $formatText($event->getICSDescription()) ?>

CLASS:PUBLIC
END:VEVENT
<?php } ?>
END:VCALENDAR
