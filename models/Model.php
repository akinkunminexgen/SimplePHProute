<?php
/*
*
*
*/
class Model extends Database
{
    protected $tableName;

    public function __construct($name)
    {
        if (empty($name)) {
            throw new Exception("Table name cannot be empty.");
        }
        $this->tableName = 'dbo.'.$name;
    }

    public function all()
    {
        return self::query("SELECT * FROM {$this->tableName}");
    }

    public function find(int $id)
    {
        $query = "SELECT * FROM {$this->tableName} WHERE id = :id";
        $result = self::query($query, ['id' => $id]);
        return $result ? $result[0] : null;
    }

    public function where(array $condition)
    {
        if (count($condition) !== 2) {
            throw new Exception("Where condition must have exactly two elements: [column, value].");
        }
        [$column, $value] = $condition;
        $query = "SELECT * FROM {$this->tableName} WHERE $column = :value";
        return self::query($query, ['value' => $value]);
    }

    // Insert a new record
    public function insert(array $data)
    {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO {$this->tableName} ($columns) VALUES ($placeholders)";
        self::query($query, $data);
        return self::connect()->lastInsertId();
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
        return self::query($query, $data);
    }

    // Delete a record by ID
    public function delete(int $id)
    {
        $query = "DELETE FROM {$this->tableName} WHERE id = :id";
        return self::query($query, ['id' => $id]);
    }
}
?>
