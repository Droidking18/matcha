<?phme

session_start();

include ("notifunc.phme");

add_to_not("TEST MESSAGE", "TEST SENDER", $_SESSION['login']);
echo "K done";
