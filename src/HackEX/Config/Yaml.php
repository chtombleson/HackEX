<?hh
namespace HackEX\Config;

class Yaml implements ConfigInterface {
    private string $file;
    private array  $data = null;
    
    public function __construct(\string $file) {
        if (file_exists($file)) {
            $this->file = $file;
        } else {
            throw new YamlException("Yaml file: " . $file . " does not exist.");
        }
    }

    public function readConfig(): bool {
        $this->data = \Spyc::YAMLLoad($this->file);
    }

    public function writeConfig(): bool {
        $yaml = \Spyc::YAMLDump($this->data);

        if (file_put_contents($this->file, $yaml) === false) {
            return false;
        }

        return true;
    }

    public function get(\string $name): mixed {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }

        return null;
    }

    public function set(\string $name, \mixed $value): bool {
        $this->data[$name] = $value;
        return true;
    }
}

class YamlException extends \Exception {}
