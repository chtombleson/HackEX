<?hh
namespace HackEX\Database;

class MySQLConnection implements DatabaseConnectionInterface {
    private MySQLConfig $config;
    private \PDO $pdo;

    public function __construct(MySQLConfig $config) {
        $this->config = $config;

        try {
            $this->pdo = new \PDO($this->config->dsn, $this->get('username'), $this->get('password'));
        } catch (\PDOException $e) {
            throw new MySQLConnectionException($e->getMessage());
        }
    }

    public function get(): \PDO {
        return $this->pdo;
    }
}

class MySQLConnectionException extends \Exception {}
