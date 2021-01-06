Write-Output "---- Script Startet ------"
Write-Output "Benenne Files in Input und Subfolder um"
exiftool -P -d '%Y-%m-%d_%H.%M.%S' '-filename<${CreateDate}_${Model;}.%e' '-filename<${DateTimeOriginal}_${Make;}.%e' '-filename<${DateTimeOriginal}_${Make;}_${Model;}.%e' .\input

$subdirs = Get-ChildItem -path ".\input" -Recurse -Directory
foreach($dir in $subdirs){
    $fullname = $dir.FullName
     Write-Output "Benenne files in $fullname um ...."
    exiftool -P -d '%Y-%m-%d_%H.%M.%S' '-filename<${CreateDate}_${Model;}.%e' '-filename<${DateTimeOriginal}_${Make;}.%e' '-filename<${DateTimeOriginal}_${Make;}_${Model;}.%e' $fullName
}
$files = Get-ChildItem -Path ".\input" -Recurse -Include *.jpg, *.jpeg, *.png, *.HEIC
$counter = 1
$maxper = $files.count
Write-Output "Konveriere $maxper Dateien..."
foreach ($file in $files){
   $fullname = $file.FullName
   $name = $file.Name
   $output = "output\$name.png"
   if( -not (Test-Path $output -PathType Leaf)){
       #Write-Output "Konvertiere $name nach png..."
       #Write-Output "convert.ps1 $fullname -resize 1920x1080^> output\$name.png"
       convert.ps1 $fullname -auto-orient -resize '1920x1080>' $output
   }
   $counter++
   Write-Progress -Activity “Collecting files” -status “Konvertiere $name Nu $counter nach png” -percentComplete ($counter / $maxper)
   
}



