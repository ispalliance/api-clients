<?php declare(strict_types = 1);

namespace Tests\Toolkit;

use PHPUnit\Framework\TestCase as PUTestCase;

abstract class TestCase extends PUTestCase
{

	protected const TEMP_DIR = __DIR__ . '/../tmp';

}
