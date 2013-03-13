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
		$this->assertEquals($time, $to);
	}

	public function testParseSingleDurationShouldSubtractFromCurrentTime()
	{
		$baseTime = time();

		$datetime = new DateTime;
		$datetime->setTimestamp($baseTime);

		$expected = new DateTime;
		$expected->setTimestamp($baseTime);

		list($from, $to) = $this->dti->parse('P1Y2M10DT2H30M', $datetime);
		$expected->sub(new DateInterval('P1Y2M10DT2H30M'));

		$this->assertEquals($from, $expected);
		$this->assertEquals($to, $datetime);
	}

	public function testParseIntervalWithTwoDateTimes()
	{
		$datetime = new DateTime;

		list($from, $to) = $this->dti->parse('2007-03-01T13:00:00Z/2008-05-11T15:30:00Z');

		$this->assertEquals(new DateTime('2007-03-01T13:00:00Z'), $from, 'From date does not match');
		$this->assertEquals(new DateTime('2008-05-11T15:30:00Z'), $to, 'To date does not match');
	}

}
