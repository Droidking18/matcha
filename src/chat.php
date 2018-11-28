<?php

SESSION_START();
include ("header.php");
include ("../config/config.php");
include ("notifunc.php");

if (!isset($_SESSION['login']))
    exit("Go login. exit <meta http-equiv='refresh' content='0;url=login.php'/>");

getLoggedHead();

if (!isset($_GET['id']) && !isset($_POST['message']))
    exit("Bad link. exit <meta http-equiv='refresh' content='0;url=message.php'/>");
$exist = -1;
$conn = getDB();
$sql = "SELECT messages FROM users WHERE login = \"$_SESSION[login]\"";
foreach ($conn->query($sql) as $message) {
         $original = $message['messages'];
}
$new = unserialize($original);
foreach ($new as $key=>$thread) {
    if ($_GET['id'] == $thread['id'])
    {
        $exist = $key;
    }
}
if ($exist == -1)
    exit("Bad link. exit <meta http-equiv='refresh' content='0;url=message.php'/>");

//exit (print_r($new[$exist]['user']));

if (isset($_POST['message']) && isset($_POST['user']) && isset($_POST['id'])) {
    $update = send_message($_POST['user'], $_POST['message'], 0);
    $update_in = send_message($_POST['user'], $_POST['message'], 1);
    $sql = "UPDATE users SET messages = ? WHERE login = ?";
    $statement= $conn->prepare($sql);
    $statement->execute([$update, $_SESSION['login']]);
    $sql = "UPDATE users SET messages = ?, message = ?  WHERE login = ?";
    $statement= $conn->prepare($sql);
    $statement->execute([$update_in, "Y", $_POST['user']]);
    exit ("<meta http-equiv='refresh' content='0;url=chat.php?id="  . $_POST['id']  . "'/>");
}
    
?>

<style>
.box {
  width: 60%;
  margin: 50px auto;
  background: dimgrey;
  padding: 20px;
  text-align: center;
  font-weight: 900;
  color: #fff;
  font-family: arial;
  position:relative;
}
.sb1:before {
  content: "";
  width: 0px;
  height: 0px;
  position: absolute;
  border-left: 10px solid #c19381;
  border-right: 10px solid transparent;
  border-top: 10px solid #c19381;
  border-bottom: 10px solid transparent;
  right: -20px;
  top: 6px;
}


.sb2:before {
  content: "";
  width: 0px;
  height: 0px;
  position: absolute;
  border-left: 10px solid transparent;
  border-right: 10px solid #759a7b;
  border-top: 10px solid #759a7b;
  border-bottom: 10px solid transparent;
  left: -19px;
  top: 6px;
}

</style>

<div class="container">
    <?php
    foreach ($new[$key]['message'] as $key => $text)
    {
        if (preg_match("/sen/", $key))
             echo "<div style=\"position: relative; display: block; float: left; left: 6%;\" class=\"box sb2\">" .  htmlspecialchars($text)  . "</div>";
        if (preg_match("/rec/", $key))
            echo "<div style=\"position: relative; display: block; float: right; right: 6%;\" class=\"box sb1\">" . htmlspecialchars($text) . "</div>"; 
    }?>
    <form onsubmit="document.getElementById('user').value = '<?php echo $new[$exist]['user']; ?>'; document.getElementById('id').value = '<?php echo $_GET['id']; ?>'; " method="POST" style="padding-top: 100%; position: relative; display: block; margin: auto; width: 10%; padding: 10px;">
        <input type="text" name="message" required>
        <input id="user" type="hidden" name="user">
        <input id="id" type="hidden" name="id">
        <input type="submit" value="reply">
    </form>
</div>


<body background = "https://wallpapertag.com/wallpaper/full/a/d/8/8613-amazing-dark-background-2560x1600-download-free.jpg" style="background-size: cover;">
<footer style ="color: gray; text-align: center; margin-top: 10em;"><hr style="border: 2px solid gray;" />dkaplanⓒ</footer>
