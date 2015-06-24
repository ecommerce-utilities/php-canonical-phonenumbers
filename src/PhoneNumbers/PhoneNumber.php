<?php
namespace Kir\CanonicalAddresses\PhoneNumbers;

use Kir\CanonicalAddresses\Common\Culture;

class PhoneNumber {
	/** @var string */
	private $countryCode;
	/** @var string */
	private $areaCode;
	/** @var string[] */
	private $numbers;
	/** @var Culture */
	private $culture;

	/**
	 * @param string $countryCode
	 * @param string $areaCode
	 * @param string[] $numbers
	 */
	public function __construct($countryCode, $areaCode, array $numbers, Culture $culture) {
		$this->countryCode = $countryCode;
		$this->areaCode = $areaCode;
		$this->numbers = $numbers;
		$this->culture = $culture;
	}

	/**
	 * @return string
	 */
	public function getCountryCode() {
		return $this->countryCode;
	}

	/**
	 * @return string
	 */
	public function getAreaCode() {
		return $this->areaCode;
	}

	/**
	 * @return string[]
	 */
	public function getLocalNumbers() {
		return $this->numbers;
	}

	/**
	 * @param Culture $culture
	 * @return string
	 */
	public function toString(Culture $culture) {
		$fn = $this->getFormatter($culture);
		return $fn($this->countryCode, $this->areaCode, $this->numbers);
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->toString($this->culture);
	}

	/**
	 * @param Culture $culture
	 * @return callable
	 */
	private function getFormatter(Culture $culture) {
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
		$filename = __DIR__ . "/formatters/{$type}.php";
		return file_exists($filename);
	}

	/**
	 * @param string $type
	 * @return bool
	 */
	private function incl($type) {
		$filename = __DIR__ . "/formatters/{$type}.php";
		/** @noinspection PhpIncludeInspection */
		return require $filename;
	}
}
