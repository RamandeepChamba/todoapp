<?php
echo $msg .
  '<br> You are being redirected...';
isset($url)
  ? header('Refresh: 2;url=' . $url)
  : header('Refresh: 2;url=/todoapp');
