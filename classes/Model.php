<?php
/*
*
*
*/
class Model extends Database
{
    protected $tableName;
    protected  bool $chainingResult = false;

    public function __construct($name, array $data = [])
    {
        if (empty($name)) {
            throw new Exception("Table name cannot be empty.");
        }
        
        $this->tableName = $name;        
    }

    public function all()
    {
        return self::query("Select", "SELECT * FROM {$this->tableName}");
    }

    public function toList() : array
    {
        return $this->chainingResult ? [$this] : [];
    }

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

    public function find(int $id)
    {
        $query = "SELECT TOP 1 * FROM {$this->tableName} WHERE id = :id";
        $result = self::query("Select", $query, ['id' => $id]);
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
        $query = "SELECT * FROM {$this->tableName} WHERE $column = :value";
        return self::query("Select", $query, ['value' => $value]);
    }

    public function whereto(Closure $condition)
    {
        if ($condition instanceof Closure) {
            $query = new static(); // or $this if chaining
            $condition($query);
            var_dump($query);
            var_dump($condition);
        }
        // Handle array conditions as usual
    }

    // Insert a new record
    public function insert(Object $dataObj)
    {
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
