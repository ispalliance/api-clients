<?php declare(strict_types = 1);

namespace Tests\Cases\App\Crm\Utils;

use ISPA\ApiClients\App\Adminus\Crm\Utils\Filter;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{

	public function testIsValid(): void
	{
		$item = ['is_active' => 1, 'secondOne' => 2, 'thirdOne' => 3];

		$this->assertTrue(Filter::isValid($item, []));
		$this->assertTrue(Filter::isValid($item, ['is_active' => 1]));
		$this->assertTrue(Filter::isValid($item, ['is_active' => 1, 'secondOne' => 2]));
		$this->assertTrue(Filter::isValid($item, ['is_active' => 1, 'thirdOne' => 3]));
		$this->assertTrue(Filter::isValid($item, ['is_active' => 1, 'secondOne' => 2, 'thirdOne' => 3]));

		$this->assertFalse(Filter::isValid($item, ['is_active' => TRUE]));
		$this->assertFalse(Filter::isValid($item, ['nonExistingKey' => TRUE]));
		$this->assertFalse(Filter::isValid($item, ['is_active' => 1, 'secondOne' => 3]));
		$this->assertFalse(Filter::isValid($item, ['is_active' => 1, 'nonExistingKey' => 3]));
		$this->assertFalse(Filter::isValid($item, ['is_active' => 1, 'secondOne' => 2, 'nonExistingKey' => 3]));
		$this->assertFalse(Filter::isValid($item, ['is_active' => 1, 'secondOne' => 2, 'thirdOne' => 3, 'nonExistingKey' => FALSE]));
	}

	public function testGetValid(): void
	{
		$item1 = ['is_active' => 0];
		$item2 = ['is_active' => 1];
		$item3 = ['is_active' => TRUE];
		$item4 = ['nonExistingKey' => 0];
		$item5 = ['is_active' => 1, 'secondOne' => 2, 'thirdOne' => 3];
		$items = [$item1, $item2, $item3, $item4, $item5];

		$this->assertEquals([$item2, $item5], Filter::getValid($items, ['is_active' => 1]));
		$this->assertEquals([$item3], Filter::getValid($items, ['is_active' => TRUE]));
		$this->assertEquals([$item5], Filter::getValid($items, ['is_active' => 1, 'thirdOne' => 3]));
		$this->assertEquals($items, Filter::getValid($items, []));
		$this->assertEquals([], Filter::getValid($items, ['is_active' => 1, 'thirdOne' => 3, 'nonExistingKey' => 0]));
		$this->assertEquals([], Filter::getValid($items, ['non' => FALSE]));
		$this->assertEquals([], Filter::getValid($items, ['is_active' => 1, 'thirdOne' => 2]));
	}

}
