<?hh
namespace HackEX\Database;

class MySQLConfig implements DatabaseConfigInterface {
    private array $config;
    private array $options = null;

    public function __construct(\array $config, ?\array $options = null) {
        if (empty($config['host']) || empty($config['database']) || empty($config['username']) || empty($config['password'])) {
            throw new MySQLConfigException("The following is required: host, database, username, password.");
        }

        $this->config = $config;
        $this->options = $options;
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

    public function getOptions(): array {
        return $this->options;
    }
}

class MySQLConfigException extends \Exception {}
