<?php
  session_start();
  $captcha_key = substr(md5(time()), 0, 6);  
  echo $captcha_key;
  $_SESSION['captcha'] = $captcha_key;
  
  $captcha_background = imagecreatefrompng("captcha_background1.png");
  $captcha_font = imageloadfont("anonymous.gdf");
  $captcha_color = imagecolorallocate($captcha_background, 200,0,0);
  imagestring($captcha_background, $captcha_font, 15,5, $captcha_key, $captcha_color);
  imagepng($captcha_background);
  imagedestroy($captcha_background);