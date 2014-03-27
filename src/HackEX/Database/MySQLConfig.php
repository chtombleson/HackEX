<?hh
namespace HackEX\Database;

class MySQLConfig implements DatabaseConfigInterface {
    private array $config;

    public function __construct(\array $config) {
        if (empty($config['host']) || empty($config['database']) || empty($config['username']) || empty($config['password'])) {
            throw new MySQLConfigException("The following is required: host, database, username, password.");
        }

        $this->config = $config;
    }

    public function get(?\string $name = null): mixed {
        if (!empty($name) && isset($this->config[$name])) {
            return $this->config[$name];
        }

        return $this->config;
    }

    public function set(\string $name, \mixed $value): void {
        $this->config[$name] = $value;
    }

    public function dsn(): string {
        $dsn = 'mysql:host=' . $this->get('host') . ';dbname=' . $this->get('database');

        if (!empty($this->config['port'])) {
            $dsn .= ';port=' . $this->get('port');
        }

        return $dsn;
    }
}

class MySQLConfigException extends \Exception {}
