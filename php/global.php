<?php 
	$URL_BASE = "http://dolstats.com/searchAjax?&case-types=PERM&state=ANY&status=Any&case-number=";
	$DATE_FORMAT = 'm-d-Y';

	function generateUrl($base, $caseNumber) {
		$now = time();
		$fewDaysAgo = $now - (5 * 24 * 60 * 60);

		$endDate = date('m-d-Y', $now);
		$startDate = date('m-d-Y', $fewDaysAgo);

		// echo "endDate=$endDate and startDate=$startDate";
		return $base . $caseNumber . "&from-date=" . $startDate . "&to-date=" . $endDate;
	}
	
	$DEFAULT_CASE_NUMBER = "A-14092";

	header('Content-type: application/json');

	$caseNumber = $DEFAULT_CASE_NUMBER;
	if (isset($_GET['case-number']) && (!empty($_GET['case-number']))) {
		$caseNumber = urlencode($_GET['case-number']);
	}
	
	$response = file_get_contents(generateUrl($URL_BASE, $caseNumber));
	echo $response;
?>