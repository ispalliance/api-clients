<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Crm\Utils;

class Filter
{

	/**
	 * @param mixed[] $items
	 * @param mixed[] $filters
	 * @return mixed[]
	 */
	public static function getValid(array $items, array $filters): array
	{
		if (count($filters) === 0) {
			return $items;
		}

		$resultData = [];

		foreach ($items as $item) {
			if (self::isValid($item, $filters)) {
				$resultData[] = $item;
			}
		}

		return $resultData;
	}

	/**
	 * @param mixed[] $item
	 * @param mixed[] $filters
	 */
	public static function isValid(array $item, array $filters): bool
	{
		if (count($filters) === 0) {
			return TRUE;
		}

		foreach ($filters as $key => $value) {
			if (isset($item[$key]) === FALSE) {
				continue;
			}

			if ($item[$key] === $value) {
				return TRUE;
			}
		}

		return FALSE;
	}

}
