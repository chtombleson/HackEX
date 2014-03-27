<?hh
namespace HackEX\Database;

interface DatabaseConfigInterface {
    private array $config;
    private array $options = null;
    public function __construct(\array $config, ?\array $options = null);
    public function get(?\string $name = null): mixed;
    public function set(\string $name, \mixed $value): void;
    public function dsn(): string;
    public function getOptions(): array;
}
