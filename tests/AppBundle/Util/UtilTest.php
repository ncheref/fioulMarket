<?php
namespace tests\AppBundle\Util;

require __DIR__ . '/../../../src/AppBundle/Util/Util.php';
use AppBundle\Util\Util;



class UtilTest extends \PHPUnit_Framework_TestCase
{
	public function testvalidateDate()
	{
		$this->assertEquals(5, 5);
		$this->assertEquals(5, 5);
		$this->assertEquals(5, 5);
		$this->assertEquals(5, 6);
// 		$this->assertEquals(5, 56);
// 		$this->assertEquals(5, 565);
// 		$this->assertEquals(true, Util::validateDate('2015-01-12'));
// 		$this->assertEquals(true, Util::validateDate('2015-01-1z'));
// 		$this->assertEquals(true, Util::validateDate('10-01-1994'));
	}
}