<?php
namespace Kir\CanonicalAddresses\PhoneNumbers\Parsers;

use Kir\CanonicalAddresses\PhoneNumbers\Parser;
use Kir\CanonicalAddresses\PhoneNumbers\Parsing\CountryPhoneCodeParserAware;

class PhoneNumberParserUnitedStates implements Parser {
	use CountryPhoneCodeParserAware;

	/**
	 * @return string
	 */
	public function getDefaultCountryPhoneCode() {
		return '1';
	}

	/**
	 * @param string $countryPhoneCode
	 * @param string $phoneNumber
	 * @return array
	 */
	public function parsePhoneNumber($countryPhoneCode, $phoneNumber) {
		$phoneNumber = preg_replace('/[^\\d+]/', '', $phoneNumber);
		if(preg_match('/^(\\d*)(\\d{3})(\\d{3})(\\d{4})/', $phoneNumber, $matches)) {
			$matches[1] = $matches[1] ?: '1';
			return array_slice($matches, 1);
		}
		return array($countryPhoneCode, null, $phoneNumber);
	}
}
