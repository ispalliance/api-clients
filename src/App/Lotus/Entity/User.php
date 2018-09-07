<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Entity;

class User
{

	/** @var int */
	private $id;

	public function __construct(int $id)
	{
		$this->id = $id;
	}

	public function getId(): int
	{
		return $this->id;
	}

}
