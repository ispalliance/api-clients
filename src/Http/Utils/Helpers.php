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

		$parameters = array_filter($parameters, static function ($value) {
			return $value !== NULL && $value !== '';
		});

		return http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
	}

}
