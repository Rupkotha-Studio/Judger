
timeLimit=$1
runFile=$2" "$3

isolate --cleanup
workdir="$(isolate --init)"
boxdir=$workdir/box
cd box
cp -r . $boxdir
cd ..

isolate -p60 -d tmp -M meta  -t $timeLimit -x 0.2 -f 40000  --run  -- $runFile < input 2> error > output

isolate --cleanup
