<?php
namespace Kir\CanonicalAddresses\PhoneNumbers;

use Kir\CanonicalAddresses\Common\Culture;

class CanonicalPhoneNumberService {
	/**
	 * @param string $phoneNumber
	 * @param Culture $culture
	 * @return PhoneNumber
	 */
	public function getCanonicalPhoneNumber($phoneNumber, Culture $culture) {
		$phoneNumber = trim($phoneNumber);
		$fn = $this->getParser($culture);
		$pn = call_user_func($fn, $phoneNumber);
		return $pn;
	}

	/**
	 * @param Culture $culture
	 * @return array
	 */
	private function getParser(Culture $culture) {
		static $cache = array();
		if(!array_key_exists((string) $culture, $cache)) {
			$cache[(string) $culture] = require __DIR__."/parsers/{$culture}.php";
		}
		return $cache[(string) $culture];
	}
}
