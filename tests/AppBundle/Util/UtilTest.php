<?php
namespace tests\AppBundle\Util;


use AppBundle\Util\Util;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class UtilTest extends WebTestCase
{
	public function testvalidateDate()
	{
		$this->assertEquals(true, Util::validateDate('2015-01-12'));
		$this->assertEquals(false, Util::validateDate('2015-01-1z'));
		$this->assertEquals(false, Util::validateDate('10-01-1994'));
	}
}