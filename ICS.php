<?php
/**
 * @copyright  Copyright (c) 2015 Brian Tam
 * @author     Brian Tam [bt] <brian@imarc.net>
 * @license    MIT
 *
 * @version    1.0.0
 * @changes    1.0.0  The initial implementation [bt, 2015-02-12]
 */

class ICS {

	/**
	 * Initialize ICS parameters, this will not pass validation alone
	 */
	private $data = array(
		'organizer'   => 'noreply@imarc.net',
		'uid'         => NULL,
		'prodid'      => NULL,
		'timezone'    => 'US-New_York-New_York',
		'start_date'  => NULL,
		'end_date'    => NULL,
		'summary'     => NULL,
		'location'    => NULL,
		'description' => NULL,
		'categories'  => NULL
	);

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
					$value = format($value);


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
