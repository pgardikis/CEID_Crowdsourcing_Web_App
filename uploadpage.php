<?php
session_start();
require('./header.php');
set_time_limit(0);

if ( isset($_POST['submit']) ) {
 
    if ( !file_exists('documents') ) {
        mkdir('documents', 0777);
    }
 
    $tmpfile = $_FILES['file']['tmp_name'];
    $orig_file_size = filesize($tmpfile);
    $target_file = 'documents/'. $_FILES['file']['name'];
 
    $chunk_size = 256; // chunk in bytes
    $upload_start = 0;
 
    $handle = fopen($tmpfile, "rb");
 
    $fp = fopen($target_file, 'w');
 
    while($upload_start < $orig_file_size) {
 
        $contents = fread($handle, $chunk_size);
        fwrite($fp, $contents);
 
        $upload_start += strlen($contents);
        fseek($handle, $upload_start);
    }
 
    fclose($handle);
    fclose($fp);
    unlink($_FILES['file']['tmp_name']);
 
    echo "File uploaded successfully.";
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Patras Hottest Spots</title>
  <link rel="stylesheet" href="css/main.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="js/main.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/heatmapjs@2.0.2/heatmap.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/leaflet-heatmap@1.0.0/leaflet-heatmap.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.css"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script>

</head>
<style type="text/css">#mapid { height: 100%; }</style>
<body>



  
<div class="uploadForm">
  <form action="locationdb.php" method="post" enctype="multipart/form-data">
      Select json file to upload:
      <input type="file" name="fileToUpload"  id="fileToUpload">
      <input type="text" id="x" name="x" style="display:none; width=400px;">
      <input type="text" id="y" name="y" style="display:none; width=400px;">
      <input type="submit" value="Upload file" class="button" name="submit" id="uploadSubmit" >  

  </form>
</div>
<div class="uploadForm container" id="note">
  <h5>Note: You can select regions to exclude from your upload using the rectangle or polygon from the left bar! </h5>
</div>

<div class="map">
    <div class="map-content container" id="map-content-upload">
       <?php echo '<div id="mapid"></div>'; ?>
    </div>
</div>

<script src="js/map.js"></script>

</body>
</html>
