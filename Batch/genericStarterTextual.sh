#!/bin/bash

source /home/andrea/Downloads/buildRoot/bin/thisroot.sh

cd $3

root -l -b rungAn.C\(\"$1\"\,\"$2\"\,true\)
