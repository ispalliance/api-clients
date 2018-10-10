<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ares\Utils;

class IdNumberUtils
{

	public static function normalize(string $idNumber): string
	{
		$idNumber = preg_replace('/\s+/', '', $idNumber);

		return str_pad($idNumber, 8, '0', STR_PAD_LEFT);
	}

	public static function validate(string $idNumber): bool
	{
		if (!(bool) preg_match('/^\d{8}$/', $idNumber)) {
			return FALSE;
		}

		$sum = 0;

		for ($i = 0; $i < 7; $i++) {
			$sum += (int) $idNumber[$i] * (8 - $i);
		}

		$num = (11 - ($sum % 11)) % 10;

		return $num === (int) $idNumber[7];
	}

}
