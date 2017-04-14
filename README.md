# Sil/PhpEnv/

PHP utility class `Env` plus `EnvVarNotFoundException` for working with environment variables that handles 
<<<<<<< HEAD
'true', 'false', and 'null' more intelligently, required variable names, and returning a list of values as a php array.
=======
'true', 'false', and 'null' more intelligently, required variable names, and converting a list of values into a php array.
>>>>>>> 769f692aeb8f10e8bba1a70d52a43eeac945f59f

## Build Status

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/silinternational/php-env/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/silinternational/php-env/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/silinternational/php-env/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/silinternational/php-env/build-status/master)

## Dev Requirements

1. php >= 5.3.3
1. phpunit ^6.1

## Setup

1. Clone this repo
1. Copy `local.env.dist` to `local.env` and update github.com token as appropriate
1. Run `make test` to install dependencies and run phpunit tests
   
### Makefile script
<<<<<<< HEAD
There is a Makefile.
=======
There is a Makefile in place.
>>>>>>> 769f692aeb8f10e8bba1a70d52a43eeac945f59f

- `make test` - does `composer install` and runs phpunit tests

## Classes in Sil/PhpEnv namespace

<<<<<<< HEAD
1. __Env__ `use Sil\PhpEnv\Env;`
1. __EnvVarNotFoundException__ `use Sil\PhpEnv\EnvVarNotFoundException;`

### Class `Env` summary of functions

1. __get__ `public static function get($varname, $default = null)`
    * searches the local environment for `$varname` and returns the corresponding value string
    * if `$varname` is not set or the value is empty (only whitespace), `get` returns `$default` parameter
    * if the value string corresponding to `$varname` is 'true', 'false' or 'null', `get` returns 
php values of `true`, `false`, or `null` respectively
    * NOTE: Any value string containing 'true' with any combination of case and/or leading/trailing whitespace still returns php `true`. 
`false` and `null` are handled similarly.

1. __getArray__ `public static function getArray($varname, array $default = [])`
    * searches the local environment for `$varname` and returns the corresponding value string with comma separated elements as a php array
    * if `$varname` is not set or the value is empty (only whitespace), `getArray` returns `$default` parameter which must be an array

1. __requireEnv__ `public static function requireEnv($varname)`
    * throws `EnvVarNotFoundException` if `$varname` is not set or corresponding value string is empty (only whitespace)
    * //TODO//

1. __requireArray__ `public static function requireArray($varname)`
    * throws `EnvVarNotFoundException` if `$varname` is not set or corresponding value string is empty (only whitespace)

### Class `EnvVarNotFoundException`

`class EnvVarNotFoundException extends \Exception`

`EnvVarNotFoundException` is thrown by `requireEnv()` and `requireArray()` when `$varname` is not found in the local
environment or the corresponding value string is empty (only whitespace).

## `Env` example function calls

### Example local.env file

### Example function calls
=======
1. Env - `use Sil\PhpEnv\Env;`
1. EnvVarNotFoundException - `use Sil\PhpEnv\EnvVarNotFoundException;`

### Summary of `Env` functions

1. `public static function *get*($varname, $default = null)`
..* searches the local environment for `$varname` and returns the corresponding value string
..* if `$varname` is not set or the value is empty (only whitespace), `get returns `$default` parameter
..* if the value string corresponding to `$varname` is 'true', 'false' or 'null', `get` returns php values of `true`, `false`, or `null`
..* NOTE: Any value string containing 'true' with any combination of case and/or leading/trailing whitespace still returns php `true`.  
`false` and `null` are handled similarly.

1. `public static function *requireEnv*($varname)`

1. `public static function *getArray*($varname, array $default = [])`

1. `public static function *requireArray*($varname)`
>>>>>>> 769f692aeb8f10e8bba1a70d52a43eeac945f59f

