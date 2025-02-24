<?php
class Database
{

  // Now you can use $dbHost, $dbUser, $dbPassword in your application


  private static $host ;
  private static $dbName;
  private static $userName;
  private static $password;
  private static $databaseType;
  protected static $pdo;

  public static function get_database_info(){

    // Load .env file into $_ENV
    $envFile = __DIR__;
    $parentDirectory = dirname($envFile);
    $envFile = $parentDirectory.'\.env';
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue; // Skip comments
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            if (!array_key_exists($key, $_ENV)) {
                putenv("$key=$value");
                $_ENV[$key] = $value;
            }
        }
    }

    self::$host = getenv('DB_HOST');
    self::$dbName = getenv('DB_DATABASE');
    self::$userName = getenv('DB_USERNAME');
    self::$password = getenv('DB_PASSWORD');
    self::$databaseType = getenv('DB_TYPE');
  }

  protected static function connect() {
        if (!self::$pdo) {
            self::get_database_info();

            try {
                if (self::$databaseType === "sql") {
                    self::$pdo = new PDO(
                        'sqlsrv:Server=' . self::$host . ';Database=' . self::$dbName,
                        self::$userName,
                        self::$password
                    );
                } elseif (self::$databaseType === "mysql") {
                    self::$pdo = new PDO(
                        'mysql:host=' . self::$host . ';dbname=' . self::$dbName . ';charset=utf8',
                        self::$userName,
                        self::$password
                    );
                }

                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            } catch (Exception $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }

        return self::$pdo;
    }
  

  public static function query($queryType, $query, $params = array())
  {
      try {
            $stmt = self::connect()->prepare($query);
            $stmt->execute($params);
            return match ($queryType) {
                'Select' => $stmt->fetchAll(PDO::FETCH_ASSOC),
                'Insert' => self::connect()->lastInsertId(), 
                'Update', 'Delete' => $stmt->rowCount(),
                default => null,                                
            };
          }
     catch (Exception $e) {
            echo "Connection xx failed: " . $e->getMessage();
            }
  }
}

 ?>
