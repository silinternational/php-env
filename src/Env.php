<?php
namespace Sil\PhpEnv;

class Env
{
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
     * NOTE: If the specified environment variable is not set and no default
     * value was provided, this function returns null (rather than returning
     * false the way getenv() does).
     * 
     * @param string $varname The name of the desired environment variable.
     * @param mixed $default The default value to return if no such environment
     *     variable exists.
     * @return mixed The resulting value (if set), or the given default value
     *     (if any, otherwise null).
     */
    public static function get($varname, $default = null)
    {
        $originalValue = \getenv($varname);
        
        if ($originalValue === false) {
            return $default;
        }
        
        $lowercasedValue = strtolower($originalValue);
        
        if ($lowercasedValue === 'false') {
            return false;
        } elseif ($lowercasedValue === 'true') {
            return true;
        } elseif ($lowercasedValue === 'null') {
            return null;
        } else {
            return $originalValue;
        }
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
        } elseif ($value === '') {
            $message = 'Required environment variable: ' . $varname . ', value cannot be empty.';
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
     * 
     * @param string $varname
     * @return array
     */
    public static function requireArray($varname)
    {
        self::requireEnv($varname);
        
        return self::getArray($varname);
    }
}
