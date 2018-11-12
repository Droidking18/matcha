<?php

session_start();

include ("header.php");
include ("merge.php");

if (!isset($_SESSION['login'])){
    echo "<meta http-equiv='refresh' content='0;url=login.php' />";
}
else
    getLoggedHead();

?>


<html lang="PR-BR">
<head>
<meta charset="UTF-8">
</head>
<body background = "https://wallpapertag.com/wallpaper/full/a/d/8/8613-amazing-dark-background-2560x1600-download-free.jpg" style="background-size: cover;">
<center>
<div style="position: relative; text-align: center; color: white;">
        <video poster="https://nestify.io/wp-content/uploads/2016/06/php-sucks.png" autoplay="true" style="width:70%;" id="video">Failure</video>
</div>
<select id="filter">
    <option value="../img/none.png">NONE</option>
    <option value="../img/frame.png">Frame 1</option>
    <option value="../img/frame2.png">Frame 2</option>
    <option value="../img/frame3.png">Frame 3</option>
    <option value="../img/smiley.png">Smiley</option>
    <option value="../img/harryPotter.png">Harry Potter</option>
</select>
<div style="position: relative; text-align: center; color: white;">
    <canvas id="canvas" style="width:70%;"></canvas>
    <img id="overlay" src = "../img/none.png" onerror="this.style.display='none'" style="width: 70%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
</div>
<div>
    <div id="photos"> </div>
</div>
</center>
<center>
<button id="capture"> capture </button>
<form action="photo.php" method="POST">
<input type="hidden" name="photo" id="upload" value=""required>
<input type="hidden" name="filter" id="overlaysend" value=""required>
<input type="submit">
</form>



<div id="buttonsDiv" >
<input type="file" multiple="false" accept="image/png"  id="files"/>
</div>


</center>
<script type="text/javascript">
 let width = 500,
     height = 0,
     streaming = false;

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const photos = document.getElementById('photos');
const photoButton = document.getElementById('capture');
const photoFilter = document.getElementById('filter');


if (window.File && window.FileReader && window.FileList && window.Blob) {
  document.getElementById('files').addEventListener('change', handleFileSelect, false);
} else {
  alert('The File APIs are not fully supported in this browser.');
}

function handleFileSelect(evt) {
  var arr = (document.getElementById('files').value).split(".");
  var ext = arr[arr.length - 1];
  var f = evt.target.files[0];
  var reader = new FileReader();
  reader.onload = (function(theFile) {
    return function(e) {
      var binaryData = e.target.result;
      var base64String = (window.btoa(binaryData));
      document.getElementById('upload').value = base64String;
    };
  })(f);
  reader.readAsBinaryString(f);
}

navigator.getUserMedia = navigator.getUserMedia ||navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUsermedia || navigator.oGetUserMedia;
if(navigator.getUserMedia){
    navigator.mediaDevices.getUserMedia({video: true, audio: false})
        .then(function (stream) { video.srcObject = stream; video.play(); })
        .catch(function (err) { console.log(`error: ${$err} `); } )
}


video.addEventListener('canplay', function (e) { if(!streaming) { height = video.videoHeight / (video.videoWidth / width); video.setAttribute('width', width); video.setAttribute('height', height); canvas.setAttribute('width', width); canvas.setAttribute('height', height); streaming = true;}}, false);

photoButton.addEventListener('click', function(e) { takePicture(); e.preventDefault(); } , false);


photoFilter.addEventListener('change', function(e) { 
    filter =  e.target.value;
    document.getElementById("overlay").src = filter;
    document.getElementById("overlaysend").value = document.getElementById("filter").value;
}
);


function takePicture () { const context = canvas.getContext('2d');  if (width && height) { canvas.width = width; canvas.height = height; } context.drawImage(video, 0, 0, width, height); 

const imgURL = canvas.toDataURL('image/png');

toString(imgURL);

img = imgURL.split(",")[1];
document.getElementById("upload").value = img;
}



</script>
</body>
<footer style ="color: gray; text-align: center; margin-top: 10em;"><hr style="border: 2px solid gray;" />dkaplanⓒ</footer>
</html>
