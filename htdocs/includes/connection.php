<?php

// Establish connection to db
$pdo = new PDO('mysql:host=localhost;
  dbname=tododb;charset=utf8',
  'tododb',
  'tododb');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
