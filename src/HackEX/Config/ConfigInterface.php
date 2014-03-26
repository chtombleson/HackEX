<?hh
namespace HackEX\Config;

interface ConfigInterface {
    public function readConfig(): bool;
    public function writeConfig(): bool;
    public function get(\string $name): mixed;
    public function set(\string $name, \mixed $value): bool;
}
