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
* HackEX\Config\JSON
*
* Example useage:
*   $config = new HackEX\Config\JSON('config.json');
*   $config->readConfig();
*   $test = $config->get('test');
*/
namespace HackEX\Config;

class JSON implements ConfigInterface {
    /**
    * String path to file
    */
    private string $file;

    /**
    * Array to hold config vars
    */
    private array  $data = null;

    /**
    * __construct
    *
    * Create a new instance of HackEX\Config\JSON
    * @param string $file   Path to json to load
    */
    public function __construct(\string $file) {
        if (file_exists($file)) {
            $this->file = $file;
        } else {
            throw new JSONException("JSON file: " . $file . " does not exist.");
        }
    }

    /**
    * readConfig
    *
    * Read the json file into a array
    * @return bool based on success
    */
    public function readConfig(): bool {
        $json = file_get_contents($this->file);

        if ($json === false) {
            return false;
        }

        $this->data = json_decode($json);
        return true;
    }

    /**
    * writeConfig
    *
    * Write the array back out to the json file
    * @return bool based on success
    */
    public function writeConfig(): bool {
        $json = json_encode($this->data);

        if (file_put_contents($this->file, $json) === false) {
            return false;
        }

        return true;
    }

    /**
    * get
    *
    * Get a variable from the array
    * @param string $name   Name of variable to get
    * @return mixed variable value of null
    */
    public function get(\string $name): mixed {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }

        return null;
    }

    /**
    * set
    *
    * Set / add a value in the array
    * @param string $name   Name of variable to set / add
    * @param mixed  $value  Value to set variable to
    * @return bool based on success
    */
    public function set(\string $name, \mixed $value): bool {
        $this->data[$name] = $value;
        return true;
    }
}

/**
* JSONException
* @author Christopher Tombleson
*/
class JSONException extends \Exception {}
