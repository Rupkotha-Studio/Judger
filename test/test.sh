apiUrl=$1
echo "Testing Start";
curl -X POST -F 'language=java' -F 'memory_limit=submission' -F 'expected_output=submission' -F 'language=submission' -F 'time_limit=submission' -F 'input=submission' -F  'api_type=submission' -F 'source_code=sdafe' "$apiUrl"
echo "\n";