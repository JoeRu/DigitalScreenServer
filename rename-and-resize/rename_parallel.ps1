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


$block = {
    Param($file)
   $fullname = $file.FullName
   $name = $file.Name
   $output = "C:\Users\johan\OneDrive\Dokumente\programmieren\rename-for-pictur\output\$name.png"
   if( -not (Test-Path $output -PathType Leaf)){
       Write-Output "Konvertiere $name nach png..."
       #Write-Output "convert.ps1 $fullname -resize 1920x1080^> output\$name.png"
       convert.ps1 $fullname  -auto-orient -colorspace sRGB -resize 1920x1080> $output
   }
}
#Remove all jobs
Get-Job | Remove-Job
$MaxThreads = 10

#Start the jobs. Max 4 jobs running simultaneously.
foreach($file in $files){
    $fullname = $file.FullName
    $name = $file.Name
    
    Write-Progress -Activity “Collecting files” -status “Konvertiere $name Nummer $counter von $maxper nach png” -percentComplete (($counter / $maxper)*100)
  
    While ($(Get-Job -state running).count -ge $MaxThreads){
        Start-Sleep -Milliseconds 20
    }
    Start-Job -Scriptblock $Block -ArgumentList $file
    $counter++
}
#Wait for all jobs to finish.
While ($(Get-Job -State Running).count -gt 0){
    start-sleep 1
}
#Get information from each job.
foreach($job in Get-Job){
    $info= Receive-Job -Id ($job.Id)
}
#Remove all jobs created.
Get-Job | Remove-Job

