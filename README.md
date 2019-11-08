# Overview
Itzamna ICS is a tool intended to be able to easily generate an ICS file.

# Concepts
## Events
Itzamna includes an event object, but you can use any event that implements the included EventInterface to set and get related fields.

### Fields
TODO: Definitions
 Field       | Description
 ----------- | ----------------------
 Organizer   | TODO
 Uid         | TODO
 Timezone*   | Event time zone        
 Start Date* | Event start date       
 End Date*   | Event end date         
 Summary     | Short summary          
 Location    | Location string        
 Description | Full event description
 Categories  | TODO

\*: Note that all date/time fields use [Carbon](https://carbon.nesbot.com/docs/) and will accept any valid value that carbon will for those fields.

## Ics Object
The ICS object allows you to set a prodid and add any number of Events.

# Usage
```
$ics = new Itzamna\Ics();
$event = new Itzamna\Event();

$ics->setICSProdid('prodid');

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

echo $ics;
```

# External Resources
[ICS Property Resource](https://tools.ietf.org/html/rfc5545)
[Carbon](https://carbon.nesbot.com/docs/)
