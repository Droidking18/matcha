<?php

function makeImage($add, $src) {
    file_put_contents("user.png", base64_decode($src));
    $png = imagecreatefrompng("user.png");
    $png2 = imagecreatefrompng($add);
    imagealphablending($png2, false);
    imagesavealpha($png2, true);
    $sizex = imagesx($png2);
    $sizey = imagesy($png2);
    imagecopyresampled( $png, $png2, 0, 0, 0, 0, $sizex, $sizey, $sizex, $sizey);
    imagepng($png, "result.png");
    $data = file_get_contents("result.png");
    $base64 = 'data:image/png;base64,' . base64_encode($data);
    unlink("result.png");
    unlink("user.png");
    return $base64;
}
