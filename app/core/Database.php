<?php

Trait Database
{
    private object $con;

    public function __construct()
    {
        $settings = DB_DRIVER . ":hostname=" . DB_HOST . ";dbname=" . DB_NAME;
        $this->con = new PDO($settings, DB_USERNAME, DB_PASSWORD);
    }

    public function query(string $query, array $data = []): array|bool
    {
        $stm = $this->con->prepare($query);
        $check = $stm->execute($data);

        if ($check) {
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            if (is_array($result) && count($result)) {
                return $result;
            }

        }

        return false;
    }
}
