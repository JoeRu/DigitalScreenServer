<?php

// Default Directory is ./pics - to change set line 60 
// by default 4 Images are preloaded - change line 88 by adding or reducing preloading

$imgs_arr = array();
$count_img_index = 0;
$next_img = 0;

function random_img_from_dir($dir)
{
  global $imgs_arr, $next_img, $count_img_index;
  // Initiate array where image name will be put 
  if ( sizeof($imgs_arr) == 0 )
  {

    // Check if our directory exists
    if (file_exists($dir) && is_dir($dir) ) {

        // Get files from the directory as an array
        $dir_arr = scandir($dir);
        $arr_files = array_diff($dir_arr, array('.','..') );

        foreach ($arr_files as $file) {
          //Get the file path
          $file_path = $dir."/".$file;
          // Get the file extension
          $ext = pathinfo($file_path, PATHINFO_EXTENSION);

          if ($ext=="jpg" || $ext=="png" || $ext=="JPG" || $ext=="PNG") {
            array_push($imgs_arr, $file);
          }

        }

    }
    $count_img_index = count($imgs_arr) - 1;
    $next_img = rand( 0, $count_img_index );
  }
  else{
    $next_img = $next_img + 1;
    if($next_img > $count_img_index) 
      $next_img = 0;
  }
  
  return $imgs_arr[$next_img];
}

function data_uri($file)
{
  $mime = mime_content_type($file);
  $contents = file_get_contents($file);
  $base64   = base64_encode($contents); // Alternative - set File to Image-Path on server - but then the server needs to handle 3-4 more requests.
  return ('data:' .$mime . ';base64,' . $base64);
}



  function get_random(){
    $dir = './pics/';
    $img = random_img_from_dir($dir);
    $m_img = $dir . $img;
  return $m_img;
  }
?>
<html>
<style>
#overlay {
  position: fixed; /* Sit on top of the page content */
  display: block; /* Hidden by default */
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
  cursor: pointer; /* Add a pointer on hover */
}
</style>
<body bgcolor="#000000">
<div align="center">
<img height="100%" id="image">
<div>
  <script type = "text/javascript">
      var image = document.getElementById("image");
      var currentPos = 0;
      /* Images are preloaded as PNG Images - complete in the Website - so no further Request to Server is necessary. */
      var images = [
        "<?php echo data_uri(get_random()); ?>",
        "<?php echo data_uri(get_random()); ?>",
        "<?php echo data_uri(get_random()); ?>",
        "<?php echo data_uri(get_random()); ?>"];
      /* Show next Image */
      function folgendefoto() {
          if (++currentPos >= images.length)
              currentPos = 0;

          image.src = images[currentPos];
      }
      folgendefoto();
      /* 30.000 Miliseconds  = 30 Sec. */
      setInterval(folgendefoto, 30000);
  </script>
</body>
</html>
