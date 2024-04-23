<?php
require __DIR__ . '/../config/config.php';
class Connection
{
    protected $db;
    protected $host;
    protected $dbname;
    protected $username;
    protected $password;

    public function __construct()
    {
        $config = getDbConfig();

        $this->host = $config["host"];
        $this->dbname = $config["dbname"];
        $this->username = $config["username"];
        $this->password = $config["password"];
        $this->make();
    }


    private function make()
    {

        try {
            $this->db = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->username, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function run(string $sql, iterable $data = [], bool $fetchall = true)
    {
        try {

            $stmt = $this->db->prepare($sql);
            $res =  $stmt->execute($data);

            if ($stmt->columnCount() > 0) {

                if ($fetchall) {
                    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $res = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (!is_array($res)) {
                        $res = [];
                    }
                }
            } else {
                if (!$res) {
                    return ["status" => "fail", "message" => "Something went wrong "];
                }
            }


            return ["status" => "success", "data" => $res];
        } catch (PDOException $e) {

            return ["status" => "fail", "message" => $e->getMessage()];
        }
    }
    public function getConnection()
    {
        return $this->db;
    }
}
