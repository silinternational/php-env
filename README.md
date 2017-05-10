# Sil/PhpEnv/

Simple PHP library for getting (or requiring) environment variables, designed 
to handle `true`, `false`, and `null` more intelligently. If desired, an 
environment variable's value can be split into an array automatically.

## Build Status

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/silinternational/php-env/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/silinternational/php-env/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/silinternational/php-env/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/silinternational/php-env/build-status/master)

## Setup

1. Clone this repo.
1. Copy `local.env.dist` to `local.env` and update GitHub.com token as 
   appropriate.
1. Run `make test` to install dependencies and run PHPUnit tests.
   
### Makefile script

There is a Makefile in place to simplify common tasks.
- `make test` - does `composer install` and runs phpunit tests

___

## Classes in Sil/PhpEnv namespace

1. __Env__: `use Sil\PhpEnv\Env;`
2. __EnvVarNotFoundException__: `use Sil\PhpEnv\EnvVarNotFoundException;`

### Class `Env` summary of functions

1. __get__ - `public static function get($varname, $default = null)`

    * searches the local environment for `$varname` and returns the corresponding value string
    * if `$varname` is not set or the value is empty (only whitespace), `get` returns `$default` parameter
    * if the value string corresponding to `$varname` is 'true', 'false' or 'null', `get` returns 
php values of `true`, `false`, or `null` respectively
    * NOTE: Any value string containing 'true' with any combination of case and/or leading/trailing whitespace still returns php `true`.  
`false` and `null` are handled similarly.  Other value strings will have leading/trailing whitespace trimmed.

1. __getArray__ - `public static function getArray($varname, array $default = [])`

    * searches the local environment for `$varname` and returns the corresponding value string with comma separated elements as a php array
    * if `$varname` is not set or the value is empty (only whitespace), `getArray` returns `$default` parameter which must be an array
    * if $default is not an array, it throws a `TypeError` exception

1. __requireEnv__ - `public static function requireEnv($varname)`

    * searches the local environment for `$varname` and returns the corresponding value string
    * if `$varname` is not set or the value is empty (only whitespace), it throws `EnvVarNotFoundException`
    * 'true', 'false', and 'null' are handled the same as `get()`

1. __requireArray__ - `public static function requireArray($varname)`

    * searches the local environment for `$varname` and returns the corresponding value string with comma separated elements as a php array
    * if `$varname` is not set or the value is empty (only whitespace), it throws `EnvVarNotFoundException`


### Class `EnvVarNotFoundException`

`class EnvVarNotFoundException extends \Exception`

`EnvVarNotFoundException` is thrown by `requireEnv()` and `requireArray()` when `$varname` is not found in the local
environment or the corresponding value string is empty (only whitespace)


___

## `Env` example function calls

### Assume this `local.env` file

    EMPTY=
    SPACES=      
    WHITESPACE= Some whitespace    
    FALSE=False
    TRUE=TRUE
    NULL=null
    LOWERCASE=abc123
    UPPERCASE=ABC123
    ARRAY0=
    ARRAY1=one
    ARRAY=one,two,,three

### Example function calls and results

* **get** - `public static function get($varname, $default = null)`

    1. `Env::get('NOTFOUND')` - returns `null`
    1. `Env::get('NOTFOUND', 'bad data')` - returns `'bad data'`
    1. `Env::get('EMPTY')` - returns `''`
    1. `Env::get('SPACES')` - returns `''`
    1. `Env::get('WHITESPACE')` - returns `'Some whitespace'`
    1. `Env::get('FALSE')` - returns `false`
    1. `Env::get('TRUE')` - returns `true`
    1. `Env::get('NULL')` - returns `null`
    1. `Env::get('LOWERCASE')` - returns `'abc123'`
    1. `Env::get('UPPERCASE')` - returns `'ABC123'`

* **requireEnv** - `public static function requireEnv($varname)`

    1. `Env::requireEnv('NOTFOUND')` - throws `EnvVarNotFoundException`
    1. `Env::requireEnv('EMPTY')` - throws `EnvVarNotFoundException`
    1. `Env::requireEnv('WHITESPACE')` - returns `'Some whitespace'`
    1. `Env::requireEnv('FALSE')` - returns `false`
    1. `Env::requireEnv('LOWERCASE')` - returns `'abc123'`

* **getArray** - `public static function getArray($varname, array $default = [])`

    1. `Env::getArray('NOTFOUND')` - returns `[]`
    1. `Env::getArray('NOTFOUND', ['one', 'two'])` - returns `['one', 'two']`
    1. `Env::getArray('NOTFOUND', 'one,two,three')` - throws `TypeError` exception
    1. `Env::getArray('ARRAY0')` - returns `['']`
    1. `Env::getArray('ARRAY1')` - returns `['one']`
    1. `Env::getArray('ARRAY')` - returns `['one', 'two', '', 'three']`

* **requireArray** - `public static function requireArray($varname)`

    1. `Env::requireArray('NOTFOUND')` - throws `EnvVarNotFoundException`
    1. `Env::requireArray('EMPTY')` - throws `EnvVarNotFoundException`
    1. `Env::requireArray('ARRAY1')` - returns `['one']`
    1. `Env::requireArray('ARRAY')` - returns `['one', 'two', '', 'three']`

