<?php
/*
*
*
*/
class Model extends Database
{
    protected $tableName, $alias;
    protected  bool $chainingResult = false;
    protected string $queryStarter = "";
    public ?string $querySelect = null, $queryWhere = null, $queryJoin = null;

    public function __construct($name, array $data = [])
    {
        if (empty($name)) {
            throw new Exception("Table name cannot be empty.");
        }
        
        $this->tableName = $name;
        $this->alias = $name; 
    }

    public function all()
    {
        return $this->toList();
    }

    public function toList() : array
    {
        $this->buildQuery();
        var_dump($this->queryStarter);
        $data = $this->chainingResult ? [$this] : (self::query("Select", $this->queryStarter) ?? []);
        $this->chainingResult = false;
        return $data;
    }

    //to map result to object
    public function mapper($data): void
    {
        $this->chainingResult = true;
        $newKeys = array_keys($data);
        $objectKeys = array_keys(get_class_vars(get_class($this)));

        $objectKeysMap = array_flip($objectKeys);
    
        foreach ($newKeys as $value) {
            if (isset($objectKeysMap[$value])) {
                $this->{$value} = $data[$value];
            }
        }
    }

    // Method to rebuild the query
    private function buildQuery(): void
    {
        $this->queryStarter = "SELECT " . ($this->querySelect ?? '*') . 
                              " FROM {$this->tableName} as {$this->alias} " . 
                              ($this->queryJoin ?? '') . 
                              "" . 
                              ($this->queryWhere ?? '');
    }

    public function find(int $id)
    {
        $this->querySelect = "TOP 1 *";
        $this->queryWhere = "WHERE id = {$id}";
        $this->buildQuery();
        $result = self::query("Select", $this->queryStarter);
        $result = $result ? $result[0] : null;        

        if ($result) {
            $this->mapper($result);
            return  $this;
        }
        return null;
    }

    public function firstOrDefault(array $condition)
    {
        if (count($condition) !== 2) {
            throw new Exception("Where condition must have exactly two elements: [column, value].");
        }
        [$column, $value] = $condition;
        $query = "SELECT TOP 1 * FROM {$this->tableName} WHERE $column = :value";
        $result = self::query("Select", $query, ['value' => $value]);
        $result = $result ? $result[0] : null;
        if ($result) {
            $this->mapper($result);
            return  $this;
        }
        return null;
    }

    public function where(array $condition)
    {
        if (count($condition) !== 2) {
            throw new Exception("Where condition must have exactly two elements: [column, value].");
        }
        [$column, $value] = $condition;
        //$query = "SELECT * FROM {$this->tableName} WHERE $column = :value";
        if (is_string($value)) {
            $value = "'{$value}'"; // Quote the string value
        }
        $this->queryWhere = "WHERE {$this->tableName}.{$column} = {$value}";
        return $this; //self::query("Select", $query, ['value' => $value]);
    }

    public function select(string ...$select)
    {
        $selectWithAlias = array_map(function ($item) {
            return "{$this->alias}.{$item}";
        }, $select);
        
        $this->querySelect = implode(', ', $selectWithAlias);
        return $this;
    }

    public function join(object $join)
    {
        if (!isset($join->tableName) || !isset($join->alias)) {
            throw new Exception("The join object must have both 'tableName' and 'alias' properties.");
        }

        $this->queryJoin = "INNER JOIN {$join->tableName} as {$join->alias} ON {$this->alias}.{$this->foreignKey} = {$join->alias}.Id ";
        //var_dump("this category", $join);
        return $this;
    }

    // Insert a new record
    public function insert(Object $dataObj)
    {
        //$data = get_class_vars(get_class($dataObj)); //just use this if error
        $data = get_object_vars($dataObj);
        unset($data['tableName']); // to always ensure removal of table name from the properties
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO {$this->tableName} ($columns) VALUES ($placeholders)";        
        return self::query("Insert", $query, $data);
    }

    // Update a record by ID
    public function update(int $id, array $data)
    {
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ', ');
        $data['id'] = $id;
        $query = "UPDATE {$this->tableName} SET $fields WHERE id = :id";
        return self::query("Update", $query, $data);
    }

    // Delete a record by ID
    public function delete(int $id)
    {
        $query = "DELETE FROM {$this->tableName} WHERE id = :id";
        return self::query("Delete", $this->$queryType, $query, ['id' => $id]);
    }
}
?>
