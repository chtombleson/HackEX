# HackEX

Framework for Hack http://hacklang.org/

## Seting up framework

You can do this in 2 ways via composer of directly from git.

### Composer

    $ composer require chtombleson/hack-ex

### Git

    $ git clone https://github.com/chtombleson/HackEX.git

### Initializing the framework

If you got the code from Git add the following to you app:

    require_once(__DIR__ . '/HackEX/src/HackEX/Bootstrap.php');
    HackEX\Bootstrap::init();

If you used composer add the following to your app:

    require_once(__DIR__ . '/vendor/autoload.php');
    HackEX\Bootstrap::init();

# License

See: LICENSE
