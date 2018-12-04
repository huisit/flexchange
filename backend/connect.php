<?php
  $host = '127.0.0.1';
  $user = 'root';
  $pass = '';
  $db = 'flexchange';

  try {
     $dbh = new PDO("mysql:host=$host;dbname=$db;", $user, $pass);
  } catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
  }
?>
