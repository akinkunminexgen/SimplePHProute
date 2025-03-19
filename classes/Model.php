<?php
/*
*
*
*/
class Model extends Database
{
    public $tableName;
    public $chainingResult;

    public function __construct($name, array $data = [])
    {
        if (empty($name)) {
            throw new Exception("Table name cannot be empty.");
        }
        
        $this->tableName = 'dbo.'.$name;
        if(count($data))
        {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }
        
    }

    public function all()
    {
        return self::query("Select", "SELECT * FROM {$this->tableName}");
    }

    public function toList() : array
    {
        return !empty($this->chainingResult) ? [$this->chainingResult] : [];
    }

    public function find(int $id)
    {
        $query = "SELECT TOP 1 * FROM {$this->tableName} WHERE id = :id";
        $result = self::query("Select", $query, ['id' => $id]);
        $this->chainingResult = $result ? $result[0] : null;

        if ($result) {
            return debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['function'] === '__call' 
            ? $this
            : $this->chainingResult;
        }
        return null;
    }

    public function firstOrDefault(array $condition)
    {
        if (count($condition) !== 2) {
            throw new Exception("Where condition must have exactly two elements: [column, value].");
        }
        [$column, $value] = $condition;
        $query = "SELECT * FROM {$this->tableName} WHERE $column = :value LIMIT 1";
        return self::query("Select", $query, ['value' => $value]);
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
