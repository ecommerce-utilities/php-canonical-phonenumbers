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
		if($fn === null) {
			return new PhoneNumber(null, null, $phoneNumber, $culture);
		}
		$pn = call_user_func($fn, $phoneNumber);
		return new PhoneNumber($pn[0], $pn[1], array_slice($pn, 2), $culture);
	}

	/**
	 * @param Culture $culture
	 * @return array
	 */
	private function getParser(Culture $culture) {
		static $cache = array();
		if(!array_key_exists((string) $culture, $cache)) {
			if($this->hasFile((string) $culture)) {
				$cache[(string) $culture] = $this->incl((string)$culture);
			} elseif($this->hasFile('fallback')) {
				$cache[(string) $culture] = $this->incl('fallback');
			} else {
				$cache[(string) $culture] = null;
			}
		}
		return $cache[(string) $culture];
	}

	/**
	 * @param string $type
	 * @return bool
	 */
	private function hasFile($type) {
		$filename = __DIR__ . "/parsers/{$type}.php";
		return file_exists($filename);
	}

	/**
	 * @param string $type
	 * @return bool
	 */
	private function incl($type) {
		$filename = __DIR__ . "/parsers/{$type}.php";
		/** @noinspection PhpIncludeInspection */
		return require $filename;
	}
}
