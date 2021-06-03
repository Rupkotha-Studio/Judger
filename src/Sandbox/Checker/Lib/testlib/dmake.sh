RED='\033[1;31m'
YELLOW='\033[1;33m'
GREEN='\033[1;32m'
BLUE='\033[1;35m'
WHITE='\033[1;37m'

printf "Enter checker name ${RED}(can not use .cpp)${WHITE}: "
read checkerName



msg1(){
	printf " ${WHITE} - ${WHITE}$1 ${YELLOW}$2${WHITE}:"
}

msg2(){
	printf " ${GREEN}Success($1/9)\n"
}


printf "\n${GREEN}Starting Creating Default Checker\n\n"

msg1 "Creating" "Temp Dir."
mkdir -m 777 -p temp
msg2 1

msg1 "Coping" "testlib.h -> temp/testlib.h"
cp testlib.h temp/testlib.h
msg2 2

msg1 "Coping" "checker/$checkerName.cpp -> temp/$checkerName.cpp"
cp checker/$checkerName.cpp temp/$checkerName.cpp
msg2 3

msg1 "Going" "Temp Dir."
cd temp
msg2 4

msg1 "Compiling" "$checkerName.cpp"
g++ --std=c++11 $checkerName.cpp -o $checkerName
msg2 5

msg1 "Giving" "Temp Permission"
chmod -R 777 .
msg2 6

msg1 "Going" "Previous Path"
cd ..
msg2 7

msg1 "Coping" "temp/$checkerName -> default_checker/$checkerName"
cp temp/$checkerName default_checker/$checkerName
msg2 8

msg1 "Removing" "Temp Dir."
rm -r temp
msg2 9

printf "\n${GREEN}Successfully Created Default Checker\n\n"