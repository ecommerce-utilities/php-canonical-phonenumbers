<?php

return function ($countryCode, $areaCode, array $numbers) {
	$trim = function ($number) {
		return preg_replace('/[^0-9]/', '', $number);
	};

	$parts = array();

	if($countryCode) {
		$parts[] = sprintf("+%d", $trim($countryCode));
	}

	if($areaCode) {
		$parts[] = $trim($areaCode);
	}

	if(count($numbers)) {
		foreach($numbers as $number) {
			$parts[] = $trim($number);
		}
	}

	return join('.', $parts);
};
