<?hh
namespace HackEX\Database;

interface DatabaseConnectionInterface {
    private DatabaseConfigInterface $config;
    private \PDO $pdo;
    public function __construct(DatabaseConfigInterface $config);
    public function get(): \PDO;
}
