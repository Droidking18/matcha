<?phme

session_start();

include("message_check.php");

include ("notifunc.phme");

add_to_not("TEST MESSAGE", "TEST SENDER", $_SESSION['login']);
echo "K done";
