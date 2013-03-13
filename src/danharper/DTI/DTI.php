<?php namespace danharper\DTI;

use DateTime;
use DateInterval;

class DTI {

	public function __construct()
	{
	}

	public function parse($input, $defaultDate = null)
	{
		if ( ! $defaultDate instanceof DateTime)
		{
			$defaultDate = new DateTime($defaultDate);
		}

		list($inputFrom, $inputTo) = explode('/', $input.'/'); // appending extra / to ensure an index exists

		$toDate = $this->handleToDate($inputTo, $defaultDate);

		if (preg_match('/^P/', $inputFrom))
		{
			$fromDate = clone $toDate;
			$fromDate->sub(new DateInterval($inputFrom));
		}
		else
		{
			$fromDate = new DateTime($inputFrom);
		}

		return array($fromDate, $toDate);
	}

	protected function handleToDate($input, DateTime $defaultDate)
	{
		if ($input)
		{
			return new DateTime($input);
		}

		return $defaultDate;
	}

}
