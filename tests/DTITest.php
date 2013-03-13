<?php

use \danharper\DTI\DTI;

class DTITest extends PHPUnit_Framework_TestCase {

	public function setUp()
	{
		$this->dti = new DTI;
	}

	public function tearDown()
	{
	}

	public function testStart()
	{
		$this->assertInstanceOf('\danharper\DTI\DTI', $this->dti);
	}

	public function testParseReturnsTwoDateTimeObjects()
	{
		list($from, $to) = $this->dti->parse('2007-03-01T13:00:00Z');
		$this->assertInstanceOf('DateTime', $from);
		$this->assertInstanceOf('DateTime', $to);
	}

	public function testParseSingleDateTime()
	{
		list($from, $to) = $this->dti->parse('2007-03-01T13:00:00Z');
		$this->assertEquals(new DateTime('2007-03-01T13:00:00Z'), $from);
	}

	public function testParseAcceptsDefaultDatetime()
	{
		$time = new DateTime;
		list($from, $to) = $this->dti->parse('2007-03-01T13:00:00Z', $time);
		$this->assertEquals($time, $to, 'To date does not match the date given as the default time');
	}

	public function testParseSingleDurationShouldSubtractFromCurrentTime()
	{
		$datetime = new DateTime('2007-03-01T14:30:00Z');

		list($from, $to) = $this->dti->parse('P1Y2M10DT2H30M', $datetime);

		$this->assertEquals($from, new DateTime('2005-12-22T12:00:00Z'), 'From date does not match');
		$this->assertEquals($to, $datetime, 'To date does not match');
	}

	public function testParseIntervalWithTwoDateTimes()
	{
		list($from, $to) = $this->dti->parse('2007-03-01T13:00:00Z/2008-05-11T15:30:00Z');

		$this->assertEquals(new DateTime('2007-03-01T13:00:00Z'), $from, 'From date does not match');
		$this->assertEquals(new DateTime('2008-05-11T15:30:00Z'), $to, 'To date does not match');
	}

	public function testParseIntervalWithDurationAndDateTime()
	{
		list($from, $to) = $this->dti->parse('PT2H30M/2007-03-01T13:00:00Z');

		$this->assertEquals(new DateTime('2007-03-01T10:30:00Z'), $from, 'From date does not match');
		$this->assertEquals(new DateTime('2007-03-01T13:00:00Z'), $to, 'To date does not match');
	}

	public function testParseIntervalWithDateTimeAndDuration()
	{
		list($from, $to) = $this->dti->parse('2007-03-01T13:00:00Z/P1Y2M10DT2H30M');

		$this->assertEquals(new DateTime('2007-03-01T13:00:00Z'), $from, 'From date does not match');
		$this->assertEquals(new DateTime('2008-05-11T15:30:00Z'), $to, 'To date does not match');
	}

	/**
	 * @expectedException danharper\DTI\Exceptions\InvalidIntervalException
	 */
	public function testParseIntervalWithTwoDurationsThrowsException()
	{
		$this->dti->parse('P1Y/PT2H30M');
	}

}
