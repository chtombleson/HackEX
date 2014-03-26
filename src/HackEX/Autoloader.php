<?hh
/**
* The MIT License (MIT)
*
* Copyright (c) 2014 Christopher Tombleson
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
*/

/**
* HackEX\Autoloader PHP autoloader ported to Hack
*
* Example useage:
*   $autoloader = new Autoloader();
*   $autoloader->addNamespace('Test\Core', __DIR__ . '/Test/Core');
*   $autoloader->register();
*   $config = new Test\Core\Config();
*
* @author Christopher Tombleson
*/
namespace HackEX;

class Autoloader {
    /**
    * File extension for Hack / PHP files
    */
    private string $extension = ".php";

    /**
    * Namespace separator
    */
    private string $separator = "\\";

    /**
    * Array used to hold namespaces
    * and their paths
    */
    private array<string, string> $namespaces = null;

    /**
    * __construct
    *
    * Create a new instance of Autoloader
    *
    * @param string $ns             Add a namespace when create an instance (Optional)
    * @param string $includePath    Path to where the code is for the namespace (Optional)
    */
    public function __construct(?\string $ns = null, ?\string $includePath = null) {
        if (!empty($ns) && !empty($includePath)) {
            $this->addNamespace($ns, $includePath);
        }
    }

    /**
    * addNamespace
    *
    * Add a namespace to the autoloader
    *
    * @param string $ns             Add a namespace when create an instance
    * @param string $includePath    Path to where the code is for the namespace (Optional)
    * @return void
    */
    public function addNamespace(\string $ns, \string $includePath): void {
        if (!isset($this->namespaces[$ns])) {
            if (file_exists($includePath)) {
                $this->namespaces[$ns] = $includePath;
            } else {
                throw new AutoloaderException("Namespace include path for: " . $ns . " does not exist");
            }
        }
    }

    /**
    * removeNamespace
    *
    * Remove a namespace from the autoloader
    *
    * @param string $ns     Namespace to remove from autoloader
    * @return void
    */
    public function removeNamespace(\string $ns): void {
        if (isset($this->namespaces[$ns])) {
            unset($this->namespaces[$ns]);
        }
    }

    /**
    * register
    *
    * Registers the autoloader function (loadClass)
    * @return void
    */
    public function register(): void {
        spl_autoload_register(array($this, 'loadClass'));
    }

    /**
    * unregister
    *
    * Unregisters the autoloader function (loadClass)
    * @return void
    */
    public function unregister(): void {
        spl_autoload_unregister(array($this, 'loadClass'));
    }

    /**
    * loadClass
    *
    * The autoloader function that will load the classes as needed
    * @return void
    */
    public function loadClass(\string $className): void {
        $namespace = substr($className, 0, strrpos($className, $this->separator));
        $class = substr($className, (strrpos($className, $this->separator) + 1));

        if (!empty($namespace) && !empty($class)) {
            if (!empty($this->namespaces[$namespace])) {
                require_once(realpath($this->namespaces[$namespace]) . DIRECTORY_SEPARATOR . $class . $this->extension);
            }
        }
    }
}

/**
* Autoloader Exception
*
* @author Christopher Tombleson
*/
class AutoloaderException extends \Exception {}
