#!/bin/bash

# basic informations start:
#whoami
#pwd
#ls
# basic informations end;

#following the tests of the worst possible errors:
#cd testIfCrash
#./abort.out
#echo "alive after abort"
#./float.out
#echo "alive after float"
#./illegal.out
#echo "alive after illegal"
#./segFail.out
#echo "alive after segmentation fail"
#./termination.out
#echo "alive after termination"
#./nothing.out
#echo "alive after unexisting"
#./theWorst.out
#echo "alive after general disaster"
#./loop.out
#echo "alive after eternal loop"
#./loop2.out
#echo "alive after second eternal loop"
#echo "all is ok?"

#echo /home/andrea/Downloads/buildRoot/bin/thisroot.sh

source /home/aegis/src/root/bin/thisroot.sh
#source /home/andrea/Downloads/buildRoot/bin/thisroot.sh #questo pc
#source /usr/local/root/bin/thisroot.sh # altra

cd $2
#echo $1
#echo $2
#cd gAn/gAn-updated/ #questo pc
#cd /home/aegis/aegis-offline/gAn # altra
pwd
#echo 'run ls'
#ls


#next row will be a good solution for the shift of today, after it will be changed 
#root -l -b rungAn.C\($1\)


#next row will be the definitive command 
root -l -b rungAn.C\(\"runSheet.txt\",\"$1\"\,true\)
