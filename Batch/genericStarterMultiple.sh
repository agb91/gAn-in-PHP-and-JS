#!/bin/bash

#source /home/andrea/Downloads/buildRoot/bin/thisroot.sh

cd $4

root -l -b rungAn.C\($1\,$2\,\"$3\"\,true\)
