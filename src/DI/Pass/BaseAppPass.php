<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use Nette\Schema\Expect;
use Nette\Schema\Schema;

abstract class BaseAppPass extends AbstractPass
{

	public static function getConfigSchema(): Schema
	{
		return Expect::structure([
			'http' => Expect::arrayOf('mixed'),
			'config' => Expect::arrayOf('mixed'),
		])->castTo('array');
	}

}
