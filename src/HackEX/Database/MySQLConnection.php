<?hh
namespace HackEX\Database;

class MySQLConnection implements DatabaseConnectionInterface {
    private MySQLConfig $config;
    private \PDO $pdo;

    public function __construct(MySQLConfig $config) {
        $this->config = $config;

        try {
            $this->pdo = new \PDO($this->config->dsn(), $this->config->get('username'), $this->config->get('password'), $this->config->getOptions());
        } catch (\PDOException $e) {
            throw new MySQLConnectionException($e->getMessage());
        }
    }

    public function get(): \PDO {
        return $this->pdo;
    }
}

class MySQLConnectionException extends \Exception {}
