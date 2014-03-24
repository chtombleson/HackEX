<?hh
namespace HackEX;

class Autoloader {
    protected Array<string, string> $paths = null;

    public function __construct(?string $ns, ?string $path) {
        if (!empty($ns) && !empty($path)) {
            $this->add($ns, $path);
        }
    }

    public function add(string $ns, string $path): void {
        if (!file_exists($path)) {
            throw new AutoloaderException("Path must exist for namespace: " . $ns);
        }

        $this->paths[$ns] = $path;
    }

    public function remove(string $ns): void {
        if (isset($this->paths[$ns])) {
            unset($this->paths[$ns]);
        }
    }

    public function register(): void {
        spl_register_autoloader(array(&$this, 'load'));
    }

    protected function load(): void {
        
    }
}

class AutoloaderException extends Exception {}
