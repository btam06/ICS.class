<?php
namespace Itzamna;

use Carbon\Carbon;
use Exception;
use InvalidArgumentException;

/**
 * @copyright  Copyright (c) 2018 Brian Tam
 * @author     Brian Tam [bt] <btam06@gmail.com>
 * @license    MIT
 */
class Ics {

	/**
	 * [protected description]
	 * @var [type]
	 */
	protected $events = array();


    /**
     * [protected description]
     * @var [type]
     */
    protected $prodid;


	/**
	 * Creates a new ICS object
	 *
	 * @param  array $params  An associative array of parameters for the ICS file
	 * @return ICS
	 */
	public function __construct() {
		switch(php_sapi_name()) {
			case 'cli':
				$eol = PHP_EOL;
				break;
			default:
				$eol = "\r\n";
				break;
		}
		define('EOL', $eol);
	}


	/**
	 * Output the ICS
	 *
	 * @return string The ICS file as a string
	 */
	public function __toString() {
		return $this->make();
	}


	/**
	 * [addEvent description]
	 * @param EventInterface $event [description]
	 */
	public function addEvent(EventInterface $event) {
		$this->events[$event->getUid()] = $event;
		return $this;
	}

	/**
	 * [getEvents description]
	 * @return [type] [description]
	 */
	public function getEvents()
	{
		return $this->events;
	}

	/**
	 * [setProdid description]
	 * @param [type] $prodid [description]
	 */
	public function setProdid($prodid) {
		$this->prodid = strip_tags($prodid);
		return $this;
	}

	/**
	 * [getProdid description]
	 * @return [type] [description]
	 */
	public function getProdid() {
		return $this->prodid;
	}

	/**
	 * Output the ICS
	 *
	 * @return string The ICS file as a string
	 */
	public function make() {
		$timestamp = new Carbon();

		$out   = array();
		$out[] = "BEGIN:VCALENDAR";
		$out[] = "VERSION:2.0";
		$out[] = "PRODID:" . $this->getProdid();

		$events    = array();
		$timezones = array();
		$timezone_data = array();
		foreach ($this->getEvents() as $event) {
			// Add timezone code for events if it's new
			$timestamp->setTimezone($event->getTimezone());
			if (!in_array($timestamp->timezoneName, $timezone_data) && ($timezone = $timestamp->timezoneName)) {
				$dst = FALSE;
				$transitions = $timestamp->timezone->getTransitions(
					strtotime(date('Y-01-01')),
					strtotime(date('Y-12-31'))
				);
				$offset = $timestamp->dst ? $timestamp->offsetHours - 1 : $timestamp->offsetHours;

				$timezone_data[] = $timezone;
				$timezones[] = 'BEGIN:VTIMEZONE';
				$timezones[] = 'TZID:' . $this->formatText($timezone);

				foreach ($transitions as $transition) {
					if ($transition['isdst']) {
						$dst = TRUE;
						break;
					}
				}
				if ($dst) {
					$timezones[] = 'BEGIN:DAYLIGHT';
					$timezones[] = 'DTSTART: 19671029T020000';
					$timezones[] = 'RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=2SU';
					$timezones[] = 'TZOFFSETFROM:' . $this->padTimezoneOffset($offset);
					$timezones[] = 'TZOFFSETTO:' . $this->padTimezoneOffset($offset + 1);
					$timezones[] = 'TZNAME:' . $this->formatText($timezone) . '-DAYLIGHT';
					$timezones[] = 'END:DAYLIGHT';

					$timezones[] = 'BEGIN:STANDARD';
					$timezones[] = 'DTSTART: 19671029T020000';
					$timezones[] = 'RRULE:FREQ=YEARLY;BYMONTH=11;BYDAY=1SU';
					$timezones[] = 'TZOFFSETFROM:' . $this->padTimezoneOffset($offset + 1);
					$timezones[] = 'TZOFFSETTO:' . $this->padTimezoneOffset($offset);
					$timezones[] = 'TZNAME:' . $this->formatText($timezone) . '-STANDARD';
					$timezones[] = 'END:STANDARD';

				} else {
					$timezones[] = 'DTSTART: 19671029T020000';
					$timezones[] = 'TZOFFSETFROM:' . $this->padTimezoneOffset($offset);
					$timezones[] = 'TZOFFSETTO:' . $this->padTimezoneOffset($offset);
				}
				$timezones[] = 'END:VTIMEZONE';
			}
			$events[] = "BEGIN:VEVENT";
			$events[] = "UID:" . $event->getUid();
			$events[] = "DTSTAMP;TZID=". $this->formatText($timezone) . ":" . $this->formatDate($timestamp);
			$events[] = "DTSTART;TZID=". $this->formatText($timezone) . ":" . $this->formatDate($event->getStartDate());
			$events[] = "DTEND;TZID="  . $this->formatText($timezone) . ":" . $this->formatDate($event->getEndDate());

			$events[] = "SUMMARY:"          . $this->formatText($event->getSummary());

			if ($event->getLocation()) {
				$events[] = "LOCATION:"     . $this->formatText($event->getLocation());
			}
			$events[] = "DESCRIPTION:"      . $this->formatText($event->getDescription());
			$events[] = "ORGANIZER:MAILTO:" . $event->getOrganizer();

			if ($event->getCategories()) {
				$events[] = "CATEGORIES:"   . $event->getCategories();
			}

			$events[] = "CLASS:PUBLIC";
			$events[] = "END:VEVENT";
		}

		$out = array_merge($out, $timezones);
		$out = array_merge($out, $events);

		$out[] = "END:VCALENDAR";

		$out = join(EOL, $out);

		return $out;
	}

	/**
	 * Format a string for export to ics
	 *
	 * @param string $text The string to format
	 * @return string
	 */
	private function formatText($text) {

		$translations = array(
			"</p>"   => '.\n  ',
			"\r\n"   => '\n',
			"&nbsp;" => ' ',
			","      => '\,',
			";"      => '\;',
			":"      => '\:'
		);

		$text = strip_tags($text);
		$text = str_replace(array_keys($translations), array_values($translations), $text);
		$text = html_entity_decode($text);

		return $text;
	}

	/**
	 * [formatDate description]
	 * @param  [type] $date [description]
	 * @return [type]       [description]
	 */
	private function formatDate($date) {
		if (!$date instanceof Carbon) {
			$date = new Carbon($date);
		}
		return $date->format('Ymd\THis');
	}


	/**
	 * [padTimezoneOffset description]
	 * @param [type] $gmt_offset [description]
	 */
	private function padTimezoneOffset($gmt_offset) {
		$gmt_offset  = number_format(floatval($gmt_offset), 2, '', '');
		$gmt_offset  = strval($gmt_offset);
		$sign        = strpos($gmt_offset, '-') === 0 ? '-' : '';
		$gmt_offset  = str_replace('-', '', $gmt_offset);
		$gmt_offset  = str_pad($gmt_offset, 4, '0', STR_PAD_LEFT);
		$gmt_offset  = $sign . $gmt_offset;
		return $gmt_offset;
	}
}
