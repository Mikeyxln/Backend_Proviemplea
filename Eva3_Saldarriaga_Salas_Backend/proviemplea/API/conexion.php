<?php
class Conexion {

    private $connection;
    private $host;
    private $username;
    private $password;
    private $db;
    private $port;
    private $server;

    public function __construct() {
        $this->server     = $_SERVER['SERVER_NAME'];
        $this->connection = null;
        $this->host       = '127.0.0.1'; // localhost
        $this->port       = '3306';
        $this->db         = 'proviemplea';
        $this->username   = 'root';
        $this->password   = '';
    }

    public function getConnection() {
        try {
            $this->connection = mysqli_connect(
                $this->host,
                $this->username,
                $this->password,
                $this->db,
                $this->port
            );
            mysqli_set_charset($this->connection, 'utf8');
            if (!$this->connection) {
                echo 'Error de conexion en la BD';
            }
            return $this->connection;
        } catch (Exception $e) {
            error_log($e->getMessage());
            die('Error al conectar a la BD: ' . $e->getMessage());
        }
    }

    public function closeConnection() {
        if ($this->connection) {
            mysqli_close($this->connection);
        }
    }
}
?>
