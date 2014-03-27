<?hh
namespace HackEX\Database;

class SQLite3Connection implements DatabaseConnectionInterface {
    private SQLite3Config $config;
    private \PDO $pdo;

    public function __construct(SQLite3Config $config) {
        $this->config = $config;

        try {
            $this->pdo = new \PDO($this->config->dsn(), null, null, $this->config->getOptions());
        } catch (\PDOException $e) {
            throw new SQLite3ConnectionException($e->getMessage());
        }
    }

    public function get(): \PDO {
        return $this->pdo;
    }
}

class SQLite3ConnectionException extends \Exception {}
