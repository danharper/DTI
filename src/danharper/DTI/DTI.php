<?php namespace danharper\DTI;

use DateTime;
use DateInterval;

class DTI {

	public function __construct()
	{
	}

	public function parse($input, $default_datetime = null)
	{
		if ( ! $default_datetime instanceof DateTime)
		{
			$default_datetime = new DateTime($default_datetime);
		}

		if (preg_match('/^P/', $input))
		{
			$output = clone $default_datetime;
			$output->sub(new DateInterval($input));
		}
		else
		{
			$output = new DateTime($input);
		}

		return array($output, $default_datetime);
	}

}
