<?php
namespace Kir\CanonicalAddresses\PhoneNumbers;

interface Parser {
	/**
	 * @param string $phoneNumber
	 * @return string
	 */
	public function parseCountryPhoneCode($phoneNumber);

	/**
	 * @return string
	 */
	public function getDefaultCountryPhoneCode();

	/**
	 * @param string $countryPhoneCode
	 * @param string $phoneNumber
	 * @return array
	 */
	public function parsePhoneNumber($countryPhoneCode, $phoneNumber);
}