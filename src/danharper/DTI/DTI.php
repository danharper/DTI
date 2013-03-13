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
		if ($input)
		{
			if (preg_match('/^P/', $input))
			{
				return new DateInterval($input);
			}
			$date = new DateTime($input);
		}
		else
		{
			$date = $defaultDate;
		}



		return $date;
	}

}
