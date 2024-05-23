<?php
class Database
{
  /*public static $host = getenv('DB_HOST');
  public static $dbName = getenv('DB_DATABASE');
  public static $userName = getenv('DB_USERNAME');
  public static $password = getenv('DB_PASSWORD');*/

  public static $host = 'localhost';
  public static $dbName = 'oysconme_examentrance';
  public static $userName = 'root';
  public static $password = '';

  private static function connect() {

    $pdo = new PDO('mysql:host='.self::$host.';dbname='.self::$dbName.';charset=utf8', self::$userName, self::$password);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
  }

  public static function query($query, $params = array()) {
    $stmt = self::connect()->prepare($query);
    $stmt->execute($params);
    $data = $stmt->fetchAll();
    return $data;
  }

}
 ?>
