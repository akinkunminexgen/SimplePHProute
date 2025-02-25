<?php
/*
*
*
*/
class Model extends Database
{
    private $tableName;

    public function __construct($name)
    {
        if (empty($name)) {
            throw new Exception("Table name cannot be empty.");
        }
        $this->tableName = 'dbo.'.$name;
    }

    public function all()
    {
        return self::query("Select", "SELECT * FROM {$this->tableName}");
    }

    public function find(int $id)
    {
        $query = "SELECT * FROM {$this->tableName} WHERE id = :id";
        $result = self::query("Select", $query, ['id' => $id]);
        return $result ? $result[0] : null;
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

    // Insert a new record
    public function insert(Object $dataObj)
    {
        $data = get_object_vars($dataObj);
        unset($data['tableName']); // to always ensure removal of table name from the properties
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        var_dump($columns);
        var_dump($placeholders);
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
