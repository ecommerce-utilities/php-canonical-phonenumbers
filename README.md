# php-canonical-phonenumbers

Example

```PHP
$culture = new Culture('DE', 'de');
$service = new CanonicalPhoneNumberService(new PhoneNumberCountryCodes());
$phoneNumber = $service->getCanonicalPhoneNumber('+49 30 12345678', $culture);
echo (string) $phoneNumber;
```