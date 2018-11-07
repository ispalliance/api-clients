<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ispa;

use ISPA\ApiClients\App\Ruian\Entity\Address;
use ISPA\ApiClients\App\Ruian\Entity\ExpandedAddress;

final class AddressCreator
{

	public const COUNTRY = 'CZ';

	/**
	 * @param mixed[] $items
	 * @return Address[]|ExpandedAddress[]
	 */
	public static function toProperAddresses(array $items, bool $expanded = FALSE): array
	{
		if ($expanded) {
			return self::toExpandedAddresses($items);
		}

		return self::toAddresses($items);
	}

	/**
	 * @param mixed[] $fields
	 * @return Address|ExpandedAddress
	 */
	public static function toProperAddress(array $fields, bool $expanded = FALSE): object
	{
		if ($expanded) {
			return self::toExpandedAddress($fields);
		}

		return self::toAddress($fields);
	}

	/**
	 * @param mixed[] $items
	 * @return Address[]
	 */
	public static function toAddresses(array $items): array
	{
		$addresses = [];
		foreach ($items as $item) {
			$addresses[] = self::toAddress($item);
		}

		return $addresses;
	}

	/**
	 * @param mixed[] $fields
	 */
	public static function toAddress(array $fields): Address
	{
		$fields['country'] = self::COUNTRY;
		$address = Address::fromArray($fields);

		return $address;
	}

	/**
	 * @param mixed[] $items
	 * @return Address[]
	 */
	public static function toExpandedAddresses(array $items): array
	{
		$addresses = [];
		foreach ($items as $item) {
			$addresses[] = self::toExpandedAddress($item);
		}

		return $addresses;
	}

	/**
	 * @param mixed[] $fields
	 */
	public static function toExpandedAddress(array $fields): ExpandedAddress
	{
		$fields['country'] = self::COUNTRY;
		$address = ExpandedAddress::fromArray($fields);

		return $address;
	}

}
