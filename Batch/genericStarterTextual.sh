#!/bin/bash

#source /home/andrea/Downloads/buildRoot/bin/thisroot.sh

cd $2

root -l -b rungAn.C\(\"/opt/lampp/htdocs/test-interChangeble/afterDegree/workspace/gAn-webFinal/Batch/textArea.txt\"\,\"$1\"\,true\)
