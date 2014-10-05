<?php

	function generateUrl($base, $employer) {
		return $base . $employer;
	}

	$URL_BASE = "http://dolstats.com/searchAjax?&case-types=PERM&state=ANY&status=Any&employer-name=";
	$DEFAULT_EMPLOYER_NAME = "AKAMAI+TECHNOLOGIES%2C+INC.";

	header('Content-type: application/json');

	$employerName = $DEFAULT_EMPLOYER_NAME;
	if (isset($_GET['name']) && (!empty($_GET['name']))) {
		$employerName = urlencode($_GET['name']);
	}

	$response = file_get_contents(generateUrl($URL_BASE, $employerName));
	echo $response;
?>