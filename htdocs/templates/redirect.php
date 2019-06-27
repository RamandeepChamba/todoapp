<?php
http_response_code($errCode ?? 200);
echo $msg .
  '<br> You are being redirected...';
(isset($url) && $url)
  ? header('Refresh: 2;url=' . $url)
  : header('Refresh: 2;url=/todoapp/');
