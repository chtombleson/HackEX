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
* HackEX\Bootstrap
*
* Set up the autoloader for all HackEX namespaces
*
* Example useage
*   require_once('Bootstrap.php');
*   HackEX\Bootstrap::init();
*
* @author Christopher Tombleson
*/
namespace HackEX;

class Bootstrap {
    /**
    * init
    *
    * Initialize framework autoloader
    */
    public static function init(): void {
        if (!file_exists(dirname(dirname(__DIR__)) . "/vendor/autoload.php")) {
            throw new BootstrapException("Please run composer install in: " . dirname(dirname(__DIR__)) . "/");
        }

        require_once(dirname(dirname(__DIR__)) . "/vendor/autoload.php");

        require_once(__DIR__ . "/Autoloader/Autoloader.php");
        require_once(__DIR__ . "/Autoloader/AutoloaderYAML.php");

        $yamlAutoloader = new \HackEX\Autoloader\AutoloaderYAML(__DIR__ . "/__namespaces.yml");
    }
}

/**
* BootstrapException
* @author Christopher Tombleson
*/
class BootstrapException extends \Exception {}
