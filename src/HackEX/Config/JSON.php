<?hh
namespace HackEX\Config;

class JSON implements ConfigInterface {
    private string $file;
    private array  $data = null;

    public function __construct(\string $file) {
        if (file_exists($file)) {
            $this->file = $file;
        } else {
            throw new JSONException("JSON file: " . $file . " does not exist.");
        }
    }

    public function readConfig(): bool {
        $json = file_get_contents($this->file);

        if ($json === false) {
            return false;
        }

        $this->data = json_decode($json);
        return true;
    }

    public function writeConfig(): bool {
        $json = json_encode($this->data);

        if (file_put_contents($this->file, $json) === false) {
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

class JSONException extends \Exception {}
