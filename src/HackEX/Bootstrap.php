<?hh
namespace HackEX;

class Bootstrap {
    public static function init(): void {
        if (!file_exists(dirname(dirname(__DIR__)) . "/vendor/autoload.php")) {
            throw new BootstrapException("Please run composer install in: " . dirname(dirname(__DIR__)) . "/");
        }

        require_once(dirname(dirname(__DIR__)) . "/vendor/autoload.php");

        require_once(__DIR__ . "/Autoloader/Autoloader.php");
        require_once(__DIR__ . "/Autoloader/AutoloaderYaml.php");

        $yamlAutoloader = new \HackEX\Autoloader\AutoloaderYaml(__DIR__ . "/__namespaces.yml");
    }
}

class BootstrapException extends \Exception {}
