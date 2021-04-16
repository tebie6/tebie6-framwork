#!/bin/bash
DIR=$1

if [ ! -n "$DIR" ] ;then
    echo "you have not choice Application directory !"
    exit
fi

echo $DIR
fswatch $DIR | while read file
do
   result=$(echo $file | grep ".php$")
   if [[ $result != "" ]]
   then
       echo "${file} was modify"
       ssh company php /mnt/hgfs/tebie6/tebie6-framwork/services/website/start.php restart -d
   fi

done
