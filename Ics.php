<?php
/**
 * @copyright  Copyright (c) 2015 Brian Tam
 * @author     Brian Tam [bt] <brian@imarc.net>
 * @license    MIT
 */

class Ics {

	private static $timezones = [
		'Eastern'        => ['gmt_offset' => -5, 'daylight' => TRUE],
		'Central'        => ['gmt_offset' => -6, 'daylight' => TRUE],
		'Mountain'       => ['gmt_offset' => -7, 'daylight' => TRUE],
		'Pacific'        => ['gmt_offset' => -8, 'daylight' => TRUE],
		'America/Denver' => ['gmt_offset' => -7, 'daylight' => TRUE]
	];

	/**
	 * Initialize ICS parameters, this will not pass validation alone
	 */
	private $data = array(
		'organizer'   => 'noreply@imarc.net',
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
	private $timezone_data = '';

	static private function generateTimezoneCode($timezone) {
		if ($timezone_data = self::$timezones[$timezone]) {
			$out = array();
			$out[] = 'BEGIN:VTIMEZONE';
			$out[] = 'TZID:' . $timezone;
			if ($timezone_data['daylight']) {

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
		} else {
			throw new \Exception('Timezone: ' . $timezone . ' not supported');
		}

	}

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
	public function __construct($params = NULL) {
		if (is_array($params)) {

			foreach ($params as $param => $value) {

				$this->__set($param, $value);

			}

		}

	}

	/**
	 * Set a parameter
	 *
	 * @param  string $param  Parameter to set
	 * @param  string $value  Value to set
	 * @return void
	 */
	public function __set($param, $value) {

		if (in_array($param, array_keys($this->data))) {

			switch($param) {

				case 'start_date':
				case 'end_date':
					$value = strtotime($value);
					break;

				case 'summary':
				case 'location':
				case 'description':
					$value = $this->format($value);
					break;

				case 'timezone':
					$this->timezone_data = self::generateTimezoneCode($value);
					break;

				default:
					$value = strip_tags($value);
					break;

			}

			$this->data[$param] = $value;

		}

	}

	/**
	 * Get a parameter
	 *
	 * @param  string $param  Parameter to set
	 * @param  string $value  Value to set
	 * @return void
	 */
	public function __get($param) {

		if (isset($this->data[$param])) {

			$value = $this->data[$param];

			switch($param) {

				case 'start_date':
				case 'end_date':
					$value = date('Ymd\THis', $value);
					break;

			}

			return $value;
		}

		return NULL;
	}

	/**
	 * Output the ICS
	 *
	 * @return string The ICS file as a string
	 */
	public function __toString() {
		$timestamp  = date('Ymd\THis');

		$out = array();
		$out[] = "BEGIN:VCALENDAR";
		$out[] = "VERSION:2.0";
		$out[] = "PRODID:" . $this->prodid;
		if ($this->timezone_data) {
			$out[] = $this->timezone_data;
		}
		$out[] = "BEGIN:VEVENT";
		$out[] = "UID:" . $this->uid;
		$out[] = "DTSTAMP;TZID=". $this->timezone . ":" . $timestamp;
		$out[] = "DTSTART;TZID=". $this->timezone . ":" . $this->start_date;
		$out[] = "DTEND;TZID="  . $this->timezone . ":" . $this->end_date;

		$out[] = "SUMMARY:"          . $this->summary;

		if ($this->location) {
			$out[] = "LOCATION:"     . $this->location;
		}
		$out[] = "DESCRIPTION:"      . $this->description;
		$out[] = "ORGANIZER:MAILTO:" . $this->organizer;

		if ($this->categories) {
			$out[] = "CATEGORIES:"   . $this->categories;
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
	private function format($text) {

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



}
