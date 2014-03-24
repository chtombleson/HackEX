<?hh
namespace HackEX;

class Autoloader {
    private \string $_fileExtension = '.php';
    private \string $_namespace;
    private \string $_includePath;
    private \string $_namespaceSeparator = '\\';

    public function __construct(?\string $ns = null, ?\string $includePath = null) {
        $this->_namespace = $ns;
        $this->_includePath = $includePath;
    }

    public function setNamespaceSeparator(\string $sep): void {
        $this->_namespaceSeparator = $sep;
    }

    public function getNamespaceSeparator(): \string {
        return $this->_namespaceSeparator;
    }

    public function setIncludePath(\string $includePath): void {
        $this->_includePath = $includePath;
    }

    public function getIncludePath(): \string {
        return $this->_includePath;
    }

    public function setFileExtension(\string $fileExtension): void {
        $this->_fileExtension = $fileExtension;
    }

    public function getFileExtension(): \string{
        return $this->_fileExtension;
    }

    public function register(): void {
        spl_autoload_register(array($this, 'loadClass'));
    }

    public function unregister(): void {
        spl_autoload_unregister(array($this, 'loadClass'));
    }

    public function loadClass(\string $className): void {
        if (null === $this->_namespace || 
            $this->_namespace.$this->_namespaceSeparator === substr($className, 0, strlen($this->_namespace.$this->_namespaceSeparator))) {
    
            $fileName = '';
            $namespace = '';
            if (false !== ($lastNsPos = strripos($className, $this->_namespaceSeparator))) {
                $namespace = substr($className, 0, $lastNsPos);
                $className = substr($className, $lastNsPos + 1);
                $fileName = str_replace($this->_namespaceSeparator, DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
            }
            $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . $this->_fileExtension;

            require_once ($this->_includePath !== null ? $this->_includePath . DIRECTORY_SEPARATOR : '') . $fileName;
        }
    }
}
