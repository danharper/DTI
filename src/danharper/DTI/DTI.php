<?php namespace danharper\DTI;

use DateTime;
use DateInterval;

class DTI {

	public function parse($input, $defaultDate = null)
	{
		if ( ! $defaultDate instanceof DateTime)
		{
			$defaultDate = new DateTime($defaultDate);
		}

		list($inputFrom, $inputTo) = explode('/', $input.'/'); // appending extra / to ensure an index exists

		$fromDate = $this->handleFromDate($inputFrom);
		$toDate = $this->handleToDate($inputTo, $defaultDate);

		if ($fromDate instanceof DateInterval and $toDate instanceof DateInterval)
		{
			throw new Exceptions\InvalidIntervalException('wtf mate');
		}

		if ($fromDate instanceof DateInterval)
		{
			$fromDateX = clone $toDate;
			$fromDateX->sub($fromDate);
			$fromDate = $fromDateX;
		}

		if ($toDate instanceof DateInterval)
		{
			$toDateX = clone $fromDate;
			$toDateX->add($toDate);
			$toDate = $toDateX;
		}

		return array($fromDate, $toDate);
	}

	protected function handleToDate($input, DateTime $defaultDate)
	{
		if (preg_match('/^P/', $input))
		{
			return new DateInterval($input);
		}

		return $input ? new DateTime($input) : $defaultDate;
	}

	protected function handleFromDate($input)
	{
		if (preg_match('/^P/', $input))
		{
			return new DateInterval($input);
		}

		return new DateTime($input);
	}

}
