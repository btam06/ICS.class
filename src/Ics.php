<?php
namespace Itzamna;

use Carbon\Carbon;
use Exception;
use InvalidArgumentException;

/**
 * @copyright  Copyright (c) 2015 Brian Tam
 * @author     Brian Tam [bt] <brian@imarc.net>
 * @license    MIT
 */
class Ics {

	/**
	 * Default Timezone information
	 * @var array
	 */
	private static $timezones = [
		'Eastern'        => ['gmt_offset' => -5, 'daylight' => TRUE],
		'Central'        => ['gmt_offset' => -6, 'daylight' => TRUE],
		'Mountain'       => ['gmt_offset' => -7, 'daylight' => TRUE],
		'Pacific'        => ['gmt_offset' => -8, 'daylight' => TRUE]
	];

	/**
	 * Initialize ICS parameters, this will not pass validation alone
 	 * @var array
	 */
	private $data = array(
		'organizer'   => NULL,
		'uid'         => NULL,
		'prodid'      => NULL,
		'timezone'    => 'Eastern',
		'start_date'  => NULL,
		'end_date'    => NULL,
		'summary'     => NULL,
		'location'    => NULL,
		'description' => NULL,
		'categories'  => NULL
	);

	/**
	 * [$timezone_data description]
	 * @var string
	 */
	private $timezone_data = '';

	/**
	 * [generateTimezoneCode description]
	 * @param  [type] $timezone [description]
	 * @return [type]           [description]
	 */
	static private function generateTimezoneCode($timezone) {
		if ($timezone_data = self::$timezones[$timezone]) {
			$out = array();
			$out[] = 'BEGIN:VTIMEZONE';
			$out[] = 'TZID:' . $timezone;
			if ($timezone_data['daylight'] == TRUE) {

				$out[] = 'BEGIN:DAYLIGHT';
				$out[] = 'DTSTART: 19671029T020000';
				$out[] = 'RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=2SU';
				$out[] = 'TZOFFSETFROM:' . self::padTimezoneOffset($timezone_data['gmt_offset']);
				$out[] = 'TZOFFSETTO:' . self::padTimezoneOffset($timezone_data['gmt_offset'] + 1);
				$out[] = 'TZNAME:' . $timezone . '-DAYLIGHT';
				$out[] = 'END:DAYLIGHT';

				$out[] = 'BEGIN:STANDARD';
				$out[] = 'DTSTART: 19671029T020000';
				$out[] = 'RRULE:FREQ=YEARLY;BYMONTH=11;BYDAY=1SU';
				$out[] = 'TZOFFSETFROM:' . self::padTimezoneOffset($timezone_data['gmt_offset'] + 1);
				$out[] = 'TZOFFSETTO:' . self::padTimezoneOffset($timezone_data['gmt_offset']);
				$out[] = 'TZNAME:' . $timezone . '-STANDARD';
				$out[] = 'END:STANDARD';

			} else {
				$out[] = 'DTSTART: 19671029T020000';
				$out[] = 'TZOFFSETFROM:' . self::padTimezoneOffset($timezone_data['gmt_offset']);
				$out[] = 'TZOFFSETTO:' . self::padTimezoneOffset($timezone_data['gmt_offset']);
			}
			$out[] = 'END:VTIMEZONE';
			return join("\r\n", $out);
		}
	}

	/**
	 * [padTimezoneOffset description]
	 * @param [type] $gmt_offset [description]
	 */
	static private function padTimezoneOffset($gmt_offset) {
		$gmt_offset  = number_format(floatval($gmt_offset), 2, '', '');
		$gmt_offset  = strval($gmt_offset);
		$sign        = strpos($gmt_offset, '-') === 0 ? '-' : '';
		$gmt_offset  = str_replace('-', '', $gmt_offset);
		$gmt_offset  = str_pad($gmt_offset, 4, '0', STR_PAD_LEFT);
		$gmt_offset  = $sign . $gmt_offset;
		return $gmt_offset;
	}

	/**
	 * Creates a new ICS object
	 *
	 * @param  array $params  An associative array of parameters for the ICS file
	 * @return ICS
	 */
	public function __construct(array $params=array()) {
		$this->data = array_replace($this->data, array_intersect_key($params, $this->data));

		$this->setStartDate(isset($params['start_date']) ? $params['start_date'] : Carbon::now());
		$this->setEndDate(isset($params['end_date']) ? $params['end_date'] : Carbon::now());
		$this->setTimezone($this->data['timezone']);
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
	 * [configureTimezone description]
	 * @param  string  $name                      [description]
	 * @param  int     $gmt_offset                [description]
	 * @param  boolean $use_daylight_savings_time [description]
	 */
	public function configureTimezone(string $name, int $gmt_offset, boolean $use_daylight_savings_time) {
		if (!($gmt_offset < -12 || $gmt_offset > 14)) {
			throw new InvalidArgumentException('The specified GMT offset does not exist');
		}

		self::$timezones[$name] = ['gmt_offset' => $gmt_offset, 'daylight' => $use_daylight_savings_time];
		return $this;
	}

	/**
	 * [getOrganizer description]
	 * @return [type] [description]
	 */
	public function getOrganizer() {
		return $this->data['organizer'];
	}

	/**
	 * [getUid description]
	 * @return [type] [description]
	 */
	public function getUid() {
		return $this->data['uid'];
	}

	/**
	 * [getProdid description]
	 * @return [type] [description]
	 */
	public function getProdid() {
		return $this->data['prodid'];
	}

	/**
	 * [getTimezone description]
	 * @return [type] [description]
	 */
	public function getTimezone() {
		return $this->data['timezone'];
	}

	/**
	 * [getStartDate description]
	 * @return [type] [description]
	 */
	public function getStartDate() {
		return $this->data['start_date'];
	}

	/**
	 * [getEndDate description]
	 * @return [type] [description]
	 */
	public function getEndDate() {
		return $this->data['end_date'];
	}

	/**
	 * [getSummary description]
	 * @return [type] [description]
	 */
	public function getSummary() {
		return $this->data['summary'];
	}

	/**
	 * [getLocation description]
	 * @return [type] [description]
	 */
	public function getLocation() {
		return $this->data['location'];
	}

	/**
	 * [getDescription description]
	 * @return [type] [description]
	 */
	public function getDescription() {
		return $this->data['description'];
	}

	/**
	 * [getCategories description]
	 * @return [type] [description]
	 */
	public function getCategories() {
		return $this->data['categories'];
	}

	/**
	 * [setOrganizer description]
	 * @param [type] $organizer [description]
	 */
	public function setOrganizer($organizer) {
		$this->data['organizer'] = strip_tags($organizer);
		return $this;
	}

	/**
	 * [setUid description]
	 * @param [type] $uid [description]
	 */
	public function setUid($uid) {
		$this->data['uid'] = strip_tags($uid);
		return $this;
	}

	/**
	 * [setProdid description]
	 * @param [type] $prodid [description]
	 */
	public function setProdid($prodid) {
		$this->data['prodid'] = strip_tags($prodid);
		return $this;
	}

	/**
	 * [setTimezone description]
	 * @param [type] $timezone [description]
	 */
	public function setTimezone($timezone) {
		if (!isset(self::$timezones[$timezone])) {
			throw new InvalidArgumentException(sprintf('The timezone %s has not been configured', $timezone));
		}

		$this->data['timezone'] = $timezone;
		$this->timezone_data = self::generateTimezoneCode($timezone);

		return $this;
	}

	/**
	 * [setStartDate description]
	 * @param [type] $start_date [description]
	 */
	public function setStartDate($start_date) {
		if (!$start_date instanceof Carbon) {
			$start_date = new Carbon($start_date);
		}
		$this->data['start_date'] = $start_date;
		return $this;
	}

	/**
	 * [setEndDate description]
	 * @param [type] $end_date [description]
	 */
	public function setEndDate($end_date) {
		if (!$end_date instanceof Carbon) {
			$end_date = new Carbon($end_date);
		}
		$this->data['end_date'] = $end_date;
		return $this;
	}

	/**
	 * [setSummary description]
	 * @param [type] $summary [description]
	 */
	public function setSummary($summary) {
		$this->data['summary'] = $summary;
		return $this;
	}

	/**
	 * [setLocation description]
	 * @param [type] $location [description]
	 */
	public function setLocation($location) {
		$this->data['location'] = $location;
		return $this;
	}

	/**
	 * [setDescription description]
	 * @param [type] $description [description]
	 */
	public function setDescription($description) {
		$this->data['description'] = $description;
		return $this;
	}

	/**
	 * [setCategories description]
	 * @param [type] $categories [description]
	 */
	public function setCategories($categories) {
		$this->data['categories'] = strip_tags($categories);
		return $this;
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
		if ($this->timezone_data) {
			$out[] = $this->timezone_data;
		}
		$out[] = "BEGIN:VEVENT";
		$out[] = "UID:" . $this->getUid();
		$out[] = "DTSTAMP;TZID=". $this->getTimezone() . ":" . $timestamp;
		$out[] = "DTSTART;TZID=". $this->getTimezone() . ":" . $this->formatDate($this->getStartDate());
		$out[] = "DTEND;TZID="  . $this->getTimezone() . ":" . $this->formatDate($this->getEndDate());

		$out[] = "SUMMARY:"          . $this->formatText($this->getSummary());

		if ($this->getLocation()) {
			$out[] = "LOCATION:"     . $this->formatText($this->getLocation());
		}
		$out[] = "DESCRIPTION:"      . $this->formatText($this->getDescription());
		$out[] = "ORGANIZER:MAILTO:" . $this->getOrganizer();

		if ($this->getCategories()) {
			$out[] = "CATEGORIES:"   . $this->getCategories();
		}

		$out[] = "CLASS:PUBLIC";
		$out[] = "END:VEVENT";
		$out[] = "END:VCALENDAR";

		$out = join("\r\n", $out);

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
	 * @param  Carbon $date [description]
	 * @return [type]       [description]
	 */
	private function formatDate(Carbon $date) {
		return $date->format('Ymd\THis');
	}



}
