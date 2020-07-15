<?php

// Array of tokens is sent as parameter which is received from SendToJudge
// The function will return the Success / Failure of the code and also the Error messages if any

function getResult($tokens)
{
	$codeJudgeKey = "Enter-Your-Code-Judge-Key-Here"; //Enter Your API key here
	$request_headers = array(
		"x-rapidapi-host: judge0.p.rapidapi.com",
		"x-rapidapi-key: {$codeJudgeKey}"
	);
	$responses = array();
	$allTestEvaluated = true;
	for($i=0;$i<count($tokens);$i++)
	{
		$results = array();
		$result_url = 'https://judge0.p.rapidapi.com/submissions/'.$tokens[$i].'?base64_encoded=true';
		$request = curl_init();
		curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($request, CURLOPT_URL, $result_url);
		curl_setopt($request, CURLOPT_ENCODING, "");
		curl_setopt($request, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($request, CURLOPT_HTTPHEADER, $request_headers);
		$res = curl_exec($request);
		$res = json_decode($res,true);
		$response = array();
		if($res['status']['id'] == 1 || $res['status']['id'] == 2)
		{
			$allTestEvaluated = false;
			array_push($responses,$response);
		}
		else
		{
			$codeOutput = trim(base64_decode($res['stdout']));
			$codeStatus = $res['status']['description'];
			$outputResult['output'] = $codeOutput;
			$outputResult['status'] = $codeStatus;
			array_push($results, $outputResult);
			$response = array();
			$response['result'] = $results;
			$response['message'] = base64_decode($res['message']);
			$response['error'] = base64_decode($res['stderr']);
			$response['output'] = trim(base64_decode($res['stdout']));
			$response['compile_output'] = base64_decode($res['compile_output']);
			array_push($responses,$response);
		}
	}

	if($allTestEvaluated){
		return array('response' => $responses);
	} 
	else {
		return json_encode(array('code' => 400, 'message' => "Code Not Evaluated", 'response' => $responses));
	}
}