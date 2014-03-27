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
* HackEX\Autoloader\AutoloaderYAML
*
* Example useage:
*   $autoloader = new HackEX\Autloader\AutoloaderYAML('namespaces.yml');
*   $config = new Test\Core\Config();
*
* Example namespace.yml:
*   namespaces:
*       Test\Core: __DIR__/Test/Core
*
* The __DIR__ in the json will be replaced with the
* full path to the directory that the file lives in.
*
* @author Christopher Tombleson
*/
namespace HackEX\Autoloader;

class AutoloaderYAML {
    /**
    * HackEX\Autoloader\Autoloader object
    */
    private Autoloader $autoloader;

    /**
    * __construct
    *
    * Create a new instance of AutoloaderYAML
    * @param string $file   Path to yaml file with namespace paths
    */
    public function __construct(\string $file) {
        if (!file_exists($file)) {
            throw new AutoloaderYAMLException("Yaml file: " . $file . " does not exist.");
        }

        require_once(dirname(__DIR__) . '/Config/ConfigInterface.php');
        require_once(dirname(__DIR__) . '/Config/YAML.php');

        $config = new \HackEX\Config\Yaml($file);
        $config->readConfig();

        $namespaces = $config->get('namespaces');

        if (empty($namespaces)) {
            throw new AutoloaderYAMLException("No namespaces element found in yaml file.");
        }

        $this->autoloader = new Autoloader();

        foreach ($namespaces as $namespace => $path) {
            $fullpath = str_replace('__DIR__', realpath(dirname($file)), $path);
            $this->autoloader->addNamespace($namespace, $fullpath);
        }

        $this->autoloader->register();
    }

    /**
    * getAutoloader
    *
    * Returns the Autoloader object
    * @retrun HackEX\Autoloader\Autoloader
    */
    public function getAutoloader(): Autoloader {
        return $this->autoloader;
    }
}

/**
* AutoloaderYamlException
* @author Christopher Tombleson
*/
class AutoloaderYAMLException extends \Exception {}
