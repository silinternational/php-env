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
