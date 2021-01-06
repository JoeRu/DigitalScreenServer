#!/bin/bash
for filename in input/*; do
    [ -e "$filename" ] || continue
    exiftool -P -d '%Y-%m-%d_%H.%M.%S' '-filename<${CreateDate}_${Model;}.%e' '-filename<${DateTimeOriginal}_${Make;}.%e' '-filename<${DateTimeOriginal}_${Make;}_${Model;}.%e' input/$filename
done

for filename in input/*; do
  [ -e "$filename" ] || continue
  convert input/$filename -resize 1920x1080> output/$filename.png
done
