<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\DI\ApiClientsExtension;
use Nette\PhpGenerator\ClassType;

abstract class AbstractPass
{

	/** @var ApiClientsExtension */
	protected $extension;

	public function __construct(ApiClientsExtension $extension)
	{
		$this->extension = $extension;
	}

	public function loadPassConfiguration(): void
	{
	}

	public function beforePassCompile(): void
	{
	}

	public function afterPassCompile(ClassType $class): void
	{
	}

}
