
TIME_LIMIT=$1
EXTRA_TIME=$2
WALL_TIME=$3
RUN_FILE=$4" "$5

#create random box id
BOX_ID=$(shuf -i 0-999 -n 1)
#initial isolate box using BOX_ID
WORK_DIR=$(isolate --cg -b $BOX_ID --init)

#if box id is already created then return empty WorkDir and again check create box id and Work dir and check box id is already created or not
while [ -z "$WORK_DIR" ]
do
   	BOX_ID=$(shuf -i 0-999 -n 1)
    WORK_DIR=$(isolate --cg -b $BOX_ID --init)
done

BOX_DIR=$WORK_DIR/box
cd box
cp -r . $BOX_DIR
cd ..

chmod -w $BOX_DIR

isolate --cg -b $BOX_ID  -p32 --cg-timing --cg-mem=512000 -M meta  -t $TIME_LIMIT -x $EXTRA_TIME -w $WALL_TIME -k 64000  -f 40000  --run  -- $RUN_FILE < input 2> error > output

isolate --cg -b $BOX_ID --cleanup
