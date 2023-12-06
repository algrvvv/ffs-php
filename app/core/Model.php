<?php

trait Model
{
    use Database;

    protected int $limit = 10;
    protected int $offset = 0;

    /**
     * @param array $data
     * @return bool|array
     */
    public function select(array $data): bool|array
    {
        $query = "SELECT " . implode(', ', $data) . " FROM " . $this->table;
        if (count($this->query($query)))
            return $this->query($query);

        return false;
    }

    /**
     * @param array $data
     * @param array $data_not
     * @return array|bool
     */
    public function where(array $data, array $data_not = []): array|bool
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "SELECT * FROM " . $this->table . " WHERE ";

        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . " AND ";
        }

        foreach ($keys_not as $key) {
            $query .= $key . " != :" . $key . " AND ";
        }

        $query = trim($query, ' AND '); //удаляет в конце AND
        $query .= " LIMIT " . $this->limit . " OFFSET " . $this->offset;

        return $this->query($query, array_merge($data, $data_not));
    }

    /**
     * @param array $data
     * @return bool
     */
    public function insert(array $data): bool
    {
        $data = $this->check_allowed_columns($data);
        $keys = array_keys($data);
        $query = "INSERT INTO " . $this->table . " (" . implode(',', $keys) . ") VALUES (:" . implode(', :', $keys) . ")";
        $this->query($query, $data);

        return true;
    }

    /**
     * @param mixed $id
     * @param array $data
     * @param string|int $id_column
     * @return bool
     */
    public function update(mixed $id, array $data, string|int $id_column = 'id'): bool
    {
        $data = $this->check_allowed_columns($data);
        $query = "UPDATE " . $this->table . " SET ";
        foreach ($data as $key => $val) {
            $query .= "`$key` = :$key, ";
        }
        $query = trim($query, ', ') . " WHERE `$id_column` = :$id_column";
        $this->query($query, array_merge(["id" => $id], $data));
        return true;
    }

    /**
     * @param mixed $id
     * @param string|int $id_column
     * @return bool
     */
    public function delete(mixed $id, string|int $id_column = 'id'): bool
    {
        $query = "DELETE FROM " . $this->table . " WHERE $id_column = :$id_column";
        $this->query($query, ['id' => $id]);

        return true;
    }

    /**
     * @param array $data
     * @return array
     */
    private function check_allowed_columns(array $data): array
    {
        $out = [];
        if(isset($this->allowedColumns)){
            foreach ($data as $k => $v){
                if(in_array($k, $this->allowedColumns))
                    $out[$k] = $v;
            }
        }

        return $out;
    }
}