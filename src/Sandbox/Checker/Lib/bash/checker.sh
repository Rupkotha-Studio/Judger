
outputFile=$1
expectedOutputFile=$2
diffFile=$3

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
	mapfile -t outputList < "$outputFile"
	mapfile -t expectedList < "$expectedOutputFile"
	# all lines
	lenOutFile=${#outputList[@]}
	lenExpFile=${#expectedList[@]}

	if [ $lenOutFile -gt $lenExpFile ]
	then
    	mxLen=$lenOutFile
	else
    	mxLen=$lenExpFile
	fi

	for ((i=0; i<$mxLen; i++))
	do
 		st1=${outputList[$i]}
 		st2=${expectedList[$i]}
 		if [ "$st1" != "$st2" ]; 
 		then
 			diffLineNo=$(($i + 1 ))
 			pExpected=$st2
 			pFound=$st1
    		break
		fi
	done
	pExpected=$(compress "$pExpected");
	pFound=$(compress "$pFound");

	echo "wrong answer $diffLineNo""th line differ - expected: '$pExpected', found: '$pFound'"
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
