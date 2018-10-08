<?php declare(strict_types = 1);

namespace Tests\Toolkit\Listeners;

use Contributte\Utils\FileSystem;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use PHPUnit\Framework\TestSuite;

final class CleanerListener implements TestListener
{

	use TestListenerDefaultImplementation;

	public function endTestSuite(TestSuite $suite): void
	{
		FileSystem::purge(__DIR__ . '/../../tmp');
	}

}
