<?hh
namespace HackEX\Database;

class SQLite3Config implements DatabaseConfigInterface {
    private array $config;

    public function __construct(\array $config) {
        if (empty($config['database'])) {
            throw new SQLite3Exception("The following is required: database.");
        }

        $this->config = $config;
    }

    public function get(?\string $name = null): mixed {
        if (isset($this->config[$name])) {
            return $this->config[$name];
        }

        return $this->config;
    }

    public function set(\string $name, \mixed $value): void {
        $this->config[$name] = $value;
    }

    public function dsn(): string {
        $dsn = 'sqlite:';

        if ($this->get('database') == 'memory') {
            $dsn .= ':memory:';
        } else {
            $dsn .= $this->get('database');
        }

        return $dsn;
    }
}

class SQLite3Exception extends \Exception {}
