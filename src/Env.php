<?php
namespace Sil\PhpEnv;

class Env
{
    public static function assertEnvListAvailable()
    {
        if (empty($_ENV)) {
            $variablesOrder = \ini_get('variables_order');
            if (strpos($variablesOrder, 'E') === false) {
                throw new \Exception(
                    'Cannot get a list of the current environment variables. '
                    . 'Make sure the `variables_order` variable in php.ini '
                    . 'contains the letter "E".',
                    1496164061
                );
            }
        }
    }
    
    /**
     * Retrieve the value of the specified environment variable, translating
     * values of 'true', 'false', and 'null' (case-insensitive) to their actual
     * non-string values.
     * 
     * PHP's built-in "getenv()" function returns a string (or false, if the
     * environment variable is not set). If the value is 'false', then it will
     * be returned as the string "false", which evaluates to true. This function
     * is to check for that kind of string value and return the actual value
     * that it refers to.
     * 
     * NOTE:
     * - If no value is available for the specified environment variable and
     *   no default value was provided, this function returns null (rather than
     *   returning false the way getenv() does).
     * - At version 2.0.0, this method was changed to return the given default
     *   value even if the environment variable exists but has no value (or a
     *   value that only contains whitespace).
     * 
     * @param string $varname The name of the desired environment variable.
     * @param mixed $default The default value to return if the environment
     *     variable is not set or its value only contains whitespace.
     * @return mixed The resulting value (if set to more than whitespace), or
     *     the given default value (if any, otherwise null).
     */
    public static function get($varname, $default = null)
    {
        $originalValue = \getenv($varname);
        
        if ($originalValue === false) {
            return $default;
        }
        
        $trimmedValue = \trim($originalValue);
        
        if ($trimmedValue === '') {
            return $default;
        }
        
        $lowercasedTrimmedValue = \strtolower($trimmedValue);
        
        if ($lowercasedTrimmedValue === 'false') {
            return false;
        } elseif ($lowercasedTrimmedValue === 'true') {
            return true;
        } elseif ($lowercasedTrimmedValue === 'null') {
            return null;
        }
        
        return $trimmedValue;
    }
    
    /**
     * 
     * @param string $varname
     * @return string
     * @throws EnvVarNotFoundException
     */
    public static function requireEnv($varname)
    {
        $value = self::get($varname);
        
        if ($value === null) {
            $message = 'Required environment variable: ' . $varname . ', not found.';
            throw new EnvVarNotFoundException($message);
        }
        
        return $value;
    }
    
    /**
     * 
     * @param string $varname
     * @param array $default
     * @return array
     */
    public static function getArray($varname, array $default = [])
    {
        $value = self::get($varname);
        
        if ($value === null) {
            return $default;
        }
        
        return explode(',', $value);
    }
    
    /**
     * Get an associative array of data, built from environment variables whose
     * names begin with the specified prefix (such as 'MY_DATA_'). If none are
     * found, an empty array will be returned.
     *
     * Note that the prefix will NOT be included in the resulting array's key
     * names. See the tests for details.
     *
     * The values 'true', 'false', and 'null' (case-insensitive) will be
     * converted to their non-string values. See Env::get().
     *
     * @param string $prefix The prefix to look for, in the list of defined
     *     environment variables' names.
     * @return array
     */
    public static function getArrayFromPrefix($prefix)
    {
        self::assertEnvListAvailable();
        
        if (empty($prefix)) {
            throw new \Exception(
                'You must provide a non-empty prefix to search for.',
                1496164608
            );
        }
        
        $results = [];
        
        foreach (array_keys($_ENV) as $name) {
            if (self::startsWith($name, $prefix)) {
                $nameAfterPrefix = substr($name, strlen($prefix));
                $results[$nameAfterPrefix] = self::get($name);
            }
        }
        
        return $results;
    }
    
    /**
     * 
     * @param string $varname
     * @return array
     */
    public static function requireArray($varname)
    {
        self::requireEnv($varname);
        
        return self::getArray($varname);
    }
    
    /**
     * See if the given string (the haystack) starts with other given string
     * (the needle).
     *
     * Thanks to MrHus on StackOverflow for this:
     * https://stackoverflow.com/a/834355/3813891
     *
     * @param string $haystack The string to search in.
     * @param string $needle The string to search for.
     * @return bool
     */
    protected static function startsWith($haystack, $needle)
    {
         $length = strlen($needle);
         return (substr($haystack, 0, $length) === $needle);
    }
}
