<?hh
namespace HackEX\Database;

class SQLite3Config implements DatabaseConfigInterface {
    private array $config;
    private array $options = null;

    public function __construct(\array $config, ?\array $options = null) {
        if (empty($config['database'])) {
            throw new SQLite3Exception("The following is required: database.");
        }

        $this->config = $config;
        $this->options = $options;
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

    public function getOptions(): array {
        return $this->options;
    }
}

class SQLite3Exception extends \Exception {}
