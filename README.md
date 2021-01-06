# DigitalScreenServer
A containered Server for Serving random Images, Newsfeeds and Time for a digital Screen / digital Signage - in use espacialy with pisignage.

This repository consists of two tools; 

## rename and resize
This is a wrapper to convert pictures to the target screensize. It makes use of "exiftool" https://exiftool.org/.

##  Server (php:apache)

The Server setup is done by docker-compose or docker commandline. 
By default port 8087 is exposed;

The following 3 Files are part of this repository:
http://localhost:8087/clock.html -- shows the actual Time in full-screen
http://localhost:8087/DigitalSignageReader.php -- potential updates are needed within - shows some Newsfeeds; by default my local news (usinger anzeiger, german news -tagesschau and faz)
http://localhost:8087/show_random_images.php -- shows the images that where stored into the folder 'html/pics' - by default some example sunsets of my library (files __*.png )

