
<?php

class Model extends Database
{
    protected static $tableName, $alias, $primaryKey;
    protected static bool $chainingResult = false;
    protected static string $queryStarter = "";
    public static ?string $querySelect = null;
    public static ?string $queryWhere = null;
    public static ?string $queryJoin = null;

    public function __construct(?string $tableName = null)
    {
        $className = (new ReflectionClass(static::class))->getShortName();

        static::$tableName = $tableName ?? self::getTableNameFor(static::class);
        static::$alias = $className;
        static::$primaryKey = 'Id';
    }

    public function __set(string $property, mixed $value): void //to ensure only property of the model can be called
    {
        throw new \InvalidArgumentException(
            "Unknown property: " . static::class . "::$property"
        );
    }

    protected static function getTableNameFor(string $class): string
    {
        $name = (new ReflectionClass($class))->getShortName();

        if (str_ends_with($name, 'y')) {
            return substr($name, 0, -1) . 'ies';
        }

        return $name . 's';
    }

    protected static function configureModel(): void
    {
        $className = (new ReflectionClass(static::class))->getShortName();

        static::$tableName = self::getTableNameFor(static::class);
        static::$alias = $className;
        static::$primaryKey = 'Id';
    }

    

    public static function all()
    {
        return self::toList();
    }

    public static function toList(): array
    {
        static::configureModel();    
        self::buildQuery();

        $data = self::$chainingResult
            ? [static::class]
            : (self::query("Select", self::$queryStarter) ?? []);

        self::$chainingResult = false;
        return $data;
    }

    public static function mapper($data): void
    {
        self::$chainingResult = true;
    }

    private static function buildQuery(): void
    {
        self::$queryStarter =
            "SELECT " . (self::$querySelect ?? '*') .
            " FROM " . static::$tableName . " as " . static::$alias . " " .
            (self::$queryJoin ?? '') .
            (self::$queryWhere ?? '');
            //echo self::$queryStarter;
    }

    public static function find(int $id)
    {
        static::configureModel();
        self::$querySelect = "TOP 1 *";
        self::$queryWhere = "WHERE id = {$id}";

        self::buildQuery();

        return self::query("Select", self::$queryStarter);
    }

    public static function firstOrDefault(array $condition)
    {
        static::configureModel();
        if (count($condition) !== 2) {
            throw new Exception(
                "Where condition must have exactly two elements: [column, value]."
            );
        }

        [$column, $value] = $condition;

        $query = "SELECT TOP 1 * FROM " . static::$tableName .
                 " WHERE $column = :value";

        return self::query("Select", $query, ['value' => $value]);
    }

    public static function where(array $condition)
    {
        static::configureModel();
        if (count($condition) !== 2) {
            throw new Exception(
                "Where condition must have exactly two elements: [column, value]."
            );
        }

        [$column, $value] = $condition;

        if (is_string($value)) {
            $value = "'{$value}'";
        }

        self::$queryWhere =
            " WHERE " . static::$alias . ".{$column} = {$value}";
        
        return new static();
    }

    public static function select(string ...$select)
    {
        static::configureModel();
        $selectWithAlias = array_map(function ($item) {
            return str_contains($item, '.')
                ? $item
                : static::$alias . "." . $item;
        }, $select);

        self::$querySelect = implode(', ', $selectWithAlias);

        return new static();
    }

    public static function join(string $join)
    {
        $currentClass = static::class;
        $currentAlias = (new ReflectionClass($currentClass))->getShortName();

        $joinClass = $join;

        $joinAlias = (new ReflectionClass($joinClass))->getShortName();
        $tableName = self::getTableNameFor($joinClass);
        $primaryKey = 'Id';

        self::$queryJoin = "INNER JOIN {$tableName} AS {$joinAlias} ON " .
            "{$currentAlias}.{$joinAlias}Id = {$joinAlias}.{$primaryKey} ";

        return new static();
    }

    public static function insert(object $dataObj)
    {
        static::configureModel();
        $data = get_object_vars($dataObj);

        unset($data['tableName']);

        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO " . static::$tableName .
                 " ($columns) VALUES ($placeholders)";

        return self::query("Insert", $query, $data);
    }

    public static function update(int $id, array $data)
    {
        static::configureModel();
        $fields = '';

        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }

        $fields = rtrim($fields, ', ');
        $data['id'] = $id;

        $query = "UPDATE " . static::$tableName .
                 " SET $fields WHERE id = :id";

        return self::query("Update", $query, $data);
    }

    public static function delete(int $id)
    {
        static::configureModel();
        $query = "DELETE FROM " . static::$tableName .
                 " WHERE id = :id";

        return self::query("Delete", $query, ['id' => $id]);
    }
}
?>
