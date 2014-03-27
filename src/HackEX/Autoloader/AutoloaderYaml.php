<?hh
namespace HackEX\Autoloader;

class AutoloaderYaml {
    private Autoloader $autoloader;

    public function __construct(\string $file) {
        if (!file_exists($file)) {
            throw new AutoloaderYamlException("Yaml file: " . $file . " does not exist.");
        }

        require_once(dirname(__DIR__) . '/Config/ConfigInterface.php');
        require_once(dirname(__DIR__) . '/Config/Yaml.php');

        $config = new \HackEX\Config\Yaml($file);
        $config->readConfig();

        $namespaces = $config->get('namespaces');

        if (empty($namespaces)) {
            throw new AutoloaderYamlException("No namespaces element found in yaml file.");
        }

        $this->autoloader = new Autoloader();

        foreach ($namespaces as $namespace => $path) {
            $fullpath = str_replace('__DIR__', realpath(dirname($file)), $path);
            $this->autoloader->addNamespace($namespace, $fullpath);
        }

        $this->autoloader->register();
    }

    public function getAutoloader(): Autoloader {
        return $this->autoloader;
    }
}

class AutoloaderYamlException extends \Exception {}
