<?php

// Array is sent which should have a node receivedData which will inturn have keys -
// `source` - Source Program
// `language` - Language Id
// `sampleInput - Sample Input Array
// `sampleOutput` - Sample Output Array

function runCode($arraySent)
{
	$programData = $arraySent['receivedData'];
	$source = $programData['source'];

	$codeJudgeKey = "Enter-Your-Code-Judge-Key-Here"; //Enter Your API key here

	$sampleInput = isset($programData['sample_input']) ? json_encode($programData['sample_input']) : json_encode(array(""));
	$sampleOutput = isset($programData['sample_output']) ? json_encode($programData['sample_output']) : json_encode(array(""));

	$sampleInput = json_decode($sampleInput,true);
	$sampleOutput = json_decode($sampleOutput,true);

	$request = curl_init("https://judge0.p.rapidapi.com/submissions/");

	$request_headers = array(
		"accept: application/json",
		"content-type: application/json",
		"x-rapidapi-host: judge0.p.rapidapi.com",
		"x-rapidapi-key: {$codeJudgeKey}"
	);

	$tokens = array();
	for($i=0; $i < sizeof($sampleInput); $i++)
	{
		$fields = array(
			'language_id' => $programData['language'],
			'source_code' => $source,
			'stdin' => $sampleInput[$i],
			'expected_output' => $sampleOutput[$i]
		);

		curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($request, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt($request,CURLOPT_POST, count($fields));
		curl_setopt($request,CURLOPT_POSTFIELDS, json_encode($fields));
		curl_setopt($request, CURLOPT_HTTPHEADER, $request_headers);
		$res = curl_exec($request);
		$token = json_decode($res)->token;
		array_push($tokens, $token);
	}
	return $tokens;
}
?>