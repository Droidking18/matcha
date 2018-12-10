<?php

function checkSearch($agemin, $agemax, $far, $gen, &$pedoswitch) {
	$re = "/^[0-9]+$/";
        if(!preg_match($re, $agemin))
		return "Your minimum age is not a number";
        if(!preg_match($re, $agemax))
		return "Your maximum age is not a number";
	if(!preg_match($re, $far))
		return "Your distance is not a number";
	if ($agemin < 18) {
		return " <img onclick=' play()'src='https://i.ytimg.com/vi/rEtg64jHERE/maxresdefault.jpg' width=100% height=100%><audio src='http://soundbible.com/mp3/BOMB_SIREN-BOMB_SIREN-247265934.mp3' id='my_audio' loop='loop' autoplay='autoplay'></audio><script type='text/javascript'>function play(){document.getElementById('my_audio').play();}</script>";
		$pedoswitch = "switch";
	}
	if ($agemin > $agemax)
		return "Min must be less than max";
	if ($agemax > 120)
		return "Seriously bro? Go visit an old aged home.";
	if ($far > 1000)
		return "Your search is too broad. Try searching for people closer to you.";
	if ($far < 0)
		return "Bad distance value. Do you even math?";
	if ($gen != "O" && $gen != "M" && $gen != "F")
		return "You need to enter correct gender. F, M or O. Like I said. JESUS.";
	return true;
}


