<?php

use \danharper\DTI\DTI;
use \Mockery as m;

class DTITest extends PHPUnit_Framework_TestCase {

	public function setUp()
	{
		$this->dti = new DTI;
	}

	public function tearDown()
	{
		m::close();
	}

	public function testStart()
	{
		$this->assertInstanceOf('\danharper\DTI\DTI', $this->dti);
	}


}
