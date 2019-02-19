<?php

  // COOKIES (c is for cookie!)

  // name
  // value
  // expiration time
  // path
  // domain
  // secure
  // http only

  $expire = time() + 69 * 60 * 24 * 7; // expires in one week
  $path = "/~sfm2686/";
  $domain = "serenity.ist.rit.edu";
  // $secure = false;  // only on HTTPS if it was set to true, secure connections
  // $http = true; // no js can access the cookies

  setcookie("test_cookie", "our first cookie!", $expire, $path, $domain);

?>
