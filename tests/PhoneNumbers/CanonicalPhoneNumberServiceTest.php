<?php
namespace Kir\CanonicalAddresses\PhoneNumbers;

use Kir\CanonicalAddresses\Common\Culture;

class CanonicalPhoneNumberServiceTest extends \PHPUnit_Framework_TestCase {
	/**
	 */
	public function testUSNumbers() {
		$service = new CanonicalPhoneNumberService();
		// US phone number 1
		$culture = new Culture('US', 'en');
		$phoneNumber = $service->getCanonicalPhoneNumber('1-222-333-4444', $culture);
		$this->assertEquals('+1.222.333.4444', (string) $phoneNumber);

		// US phone number 2
		$culture = new Culture('US', 'en');
		$phoneNumber = $service->getCanonicalPhoneNumber('222-333-4444', $culture);
		$this->assertEquals('+1.222.333.4444', (string) $phoneNumber);
	}

	/**
	 */
	public function testGermanNumbers() {
		$culture = new Culture('DE', 'de');
		$service = new CanonicalPhoneNumberService(new PhoneNumberCountryCodes());
		$phoneNumber = $service->getCanonicalPhoneNumber('+49 30 12345678', $culture);
		$this->assertEquals('+49.30.12345678', (string) $phoneNumber);
		$phoneNumber = $service->getCanonicalPhoneNumber('030 12345678', $culture);
		$this->assertEquals('+49.30.12345678', (string) $phoneNumber);
		$phoneNumber = $service->getCanonicalPhoneNumber('04122 1234567', $culture);
		$this->assertEquals('+49.4122.1234567', (string) $phoneNumber);
		$phoneNumber = $service->getCanonicalPhoneNumber('04122-12-34-567', $culture);
		$this->assertEquals('+49.4122.1234567', (string) $phoneNumber);
		$phoneNumber = $service->getCanonicalPhoneNumber('+49401234567', $culture);
		$this->assertEquals('+49.40.1234567', (string) $phoneNumber);

		// Non-German number
		$culture = new Culture('DE', 'de');
		$phoneNumber = $service->getCanonicalPhoneNumber('1-222-333-4444', $culture);
		$this->assertEquals('+49.12223334444', (string) $phoneNumber);

		// Non-German number
		$culture = new Culture('DE', 'de');
		$phoneNumber = $service->getCanonicalPhoneNumber('0097150123456', $culture);
		$this->assertEquals('+971.50123456', (string) $phoneNumber);
	}
}
