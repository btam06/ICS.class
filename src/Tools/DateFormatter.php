<?php
namespace Itzamna;

use Carbon\Carbon;

/**
 * 
 */
class DateFormatter
{
	/**
	 * Turn Carbon parsable dates into UTC translated ICS format
	 * @param  [type] $date Carbon parsable date string
	 * @param  string $timezone PHP formatted timezone string
	 * @return string ICS formatted time string
	 */
	public function __invoke($date, $timezone) {
		if (!$date instanceof Carbon) {
			$date = new Carbon($date, $timezone);
		}

		// Always format dates to UTC.  This helps client software 
		$date->setTimezone(Ics::DEFAULT_TIMEZONE);

		return $date->format('Ymd\THis\Z');
	}
}