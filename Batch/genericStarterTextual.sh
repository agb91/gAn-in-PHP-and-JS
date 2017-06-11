#!/bin/bash

source /home/andrea/Downloads/buildRoot/bin/thisroot.sh

cd $2

root -l -b rungAn.C\(\"textArea.txt\"\,\"$1\"\,true\)
