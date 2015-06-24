<?php
namespace Kir\CanonicalAddresses\PhoneNumbers;

use Kir\CanonicalAddresses\Common\Culture;

class CanonicalPhoneNumberServiceTest extends \PHPUnit_Framework_TestCase {
	/**
	 */
	public function testGetCanonicalPhoneNumber() {
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
	}
}
