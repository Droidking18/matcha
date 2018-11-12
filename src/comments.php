 <?php
 
 session_start();
 include ("../config/config.php");
 include ("header.php");
 
 if (isset($_SESSION['login']))
	 getLoggedHead();
 else
	 exit ("Please login <meta http-equiv='refresh' content='3;url=login.php' />");
 if (!isset($_GET['id']))
	exit ("Bad link <meta http-equiv='refresh' content='3;url=index.php' />"); 
 $conn = getDB();
  $sql = "SELECT comments FROM images WHERE id = " . $_GET['id'];
  echo "<H1 style='color: white; margin: auto; width: 50%; text-align:center;'> Comments 🗣</H1>";
  foreach ($conn->query($sql) as $image)
  {
          $comments = unserialize($image['comments']);
  }
 echo "<table style='width:100%'>";
         foreach ($comments as $comment)
                  echo "<tr> <th>" . $comment['login'] . "</th> <th> " . htmlspecialchars($comment['comment']) . " </tr>";
 echo "</table>";
 
 ?>
 
 <body background = "https://wallpapertag.com/wallpaper/full/a/d/8/8613-amazing-dark-background-2560x1600-download-free.jpg"                   style="background-size: cover;">
<footer style ="color: gray; text-align: center; margin-top: 10em;"><hr style="border: 2px solid gray;" />dkaplanⓒ</footer>
