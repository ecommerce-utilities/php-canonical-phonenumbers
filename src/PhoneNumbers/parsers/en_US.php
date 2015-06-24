<?php
return function ($phoneNumber) {
	$phoneNumber = preg_replace('/[^\\d+]/', '', $phoneNumber);
	if(preg_match('/^(\\d*)(\\d{3})(\\d{3})(\\d{4})/', $phoneNumber, $matches)) {
		$matches[1] = $matches[1] ?: '1';
		return array_slice($matches, 1);
	}
	return array('1', null, $phoneNumber);
};