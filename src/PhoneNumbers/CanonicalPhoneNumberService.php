<?php
namespace Kir\CanonicalAddresses\PhoneNumbers;

use Ioc\ObjectFactory;
use Kir\CanonicalAddresses\Common\Culture;

class CanonicalPhoneNumberService {
	/** @var object[] */
	private $objectCache = [];

	/** @var array */
	private $parsers = [
		'DE' => '\\Kir\\CanonicalAddresses\\PhoneNumbers\\Parsers\\PhoneNumberParserGermany',
		'US' => '\\Kir\\CanonicalAddresses\\PhoneNumbers\\Parsers\\PhoneNumberParserUnitedStates',
	];

	private $countryPhoneCodeMap = [
		'1' => 'US',
		'49' => 'DE',
	];

	/**
	 * @param string $phoneNumber
	 * @param Culture $culture
	 * @return PhoneNumber
	 */
	public function getCanonicalPhoneNumber($phoneNumber, Culture $culture) {
		$phoneNumber = trim($phoneNumber);
		list($countryPhoneCode, $phoneNumber) = $this->getCountryPhoneCode($phoneNumber, $culture);
		if(!array_key_exists($countryPhoneCode, $this->countryPhoneCodeMap)) {
			return new PhoneNumber($countryPhoneCode, null, [$phoneNumber], $culture);
		}
		$countryCode = $this->countryPhoneCodeMap[$countryPhoneCode];
		$parser = $this->getParser($countryCode);
		$parts = $parser->parsePhoneNumber($countryPhoneCode, $phoneNumber);
		return new PhoneNumber($parts[0], $parts[1], array_slice($parts, 2), $culture);
	}

	/**
	 * @param string $phoneNumber
	 * @param Culture $culture
	 * @return array
	 */
	protected function getCountryPhoneCode($phoneNumber, Culture $culture) {
		$parser = $this->getParser($culture->getCountryCode());
		list($countryPhoneCode, $phoneNumber) = $parser->parseCountryPhoneCode($phoneNumber);
		if($countryPhoneCode === null) {
			$countryPhoneCode = $parser->getDefaultCountryPhoneCode();
		}
		return [$countryPhoneCode, $phoneNumber];
	}

	/**
	 * @param string $type
	 * @return Parser
	 */
	private function getParser($type) {
		if(array_key_exists($type, $this->parsers)) {
			$className = $this->parsers[$type];
			if(!array_key_exists($className, $this->objectCache)) {
				$this->objectCache[$className] = new $className();
			}
			return $this->objectCache[$className];
		}
		return null;
	}
}
