<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Http\Utils;

class Helpers
{

	/**
	 * @param mixed[] $parameters
	 */
	public static function buildQuery(array $parameters): string
	{
		if ($parameters === []) {
			return '';
		}

		return http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
	}

}
