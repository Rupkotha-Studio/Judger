
TIME_LIMIT=$1
EXTRA_TIME=$2
WALL_TIME=$3
RUN_FILE=$4" "$5

isolate --cg --cleanup
workdir="$(isolate --cg --init)"
boxdir=$workdir/box
cd box
cp -r . $boxdir
cd ..
cDir=$(pwd)"/box"
rFile=.$cDir"/a.out"

chmod -w $boxdir

isolate --cg  -p32 --cg-timing --cg-mem=512000 -M meta  -t $TIME_LIMIT -x $EXTRA_TIME -w $WALL_TIME -k 64000  -f 40000  --run  -- $RUN_FILE < input 2> error > output

isolate --cg --cleanup
