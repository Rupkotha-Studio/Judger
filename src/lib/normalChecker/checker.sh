
outputFile="temp/output.txt"
expectedOutputFile="temp/expected_output.txt"
diffFile="temp/compare.txt"

compress () {
	line=$1
	lineLength=${#line}
	if (( $lineLength > 64 ))
	then
		prefixFix=${line:0:30}
		dot="....."
		postFix=${line: -30}
    	line="$prefixFix$dot$postFix"
	fi
	local  retval=$line
  	echo $retval
}
getTotalLine(){
	file=$1
	totalLine=$(wc -l "$file")
	totalLine=${totalLine%% *}
	let "totalLine++"
	local  retval=$totalLine
  	echo $retval
}
#end compress function

diff "$outputFile" "$expectedOutputFile" > "$diffFile"

if [ -s "$diffFile" ]
then
	echo "wrong answer ouput can not match expected answer"
else 
	totalLine=$(getTotalLine "$outputFile");
	if [ $totalLine != 1 ]
	then 
		echo "ok $totalLine lines"
	else 
		lineTxt=$(<$outputFile)
		lineTxt=$(compress "$lineTxt");
		echo "ok single line: '$lineTxt'"
	fi
fi
