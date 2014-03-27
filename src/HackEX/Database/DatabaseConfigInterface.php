<?hh
namespace HackEX\Database;

interface DatabaseConfigInterface {
    private array $config;
    public function __construct(\array $config);
    public function get(?\string $name = null): mixed;
    public function set(\string $name, \mixed $value): void;
    public function dsn(): string;
}
