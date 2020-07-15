# Submit-and-Get-Results-Using-Code-Judge-Api
Submit a source code / input / output and get code verified by using Judge0 Api

Documentation for codeJudgeApi - `https://api.judge0.com/`

To generate your keys you need to login/signup in rapidApi and subscribe to CodeJudge Api- `https://rapidapi.com/hermanzdosilovic/api/judge0`

(With Free plan you can have upto 10000 calls)

`SendToJudge0.php` - 

Enter the key generated in `$codeJudgeKey`

Send your source code, sample input, sample output and id of language used in source code and get a set of tokens

`ResultsFromJudge0.php` - 

Enter the key generated in `$codeJudgeKey`

Pass the array of tokens and get your results