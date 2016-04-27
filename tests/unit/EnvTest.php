<?php
namespace Sil\PhpEnv\tests;

use Sil\PhpEnv\Env;

class EnvTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set an environment variable using PHP's built-in putenv(), but fail the
     * unit tests if we failed to set the environment variable.
     * 
     * WARNING: Unless PHPUnit is set to run each test isolated in a separate
     * process (such as by using the '--process-isolation' option), any
     * environment variables set in one test will still be set in subsequent
     * tests.
     * 
     * @param string $setting The setting, like "FOO=BAR".
     */
    protected function putEnv($setting)
    {
        $result = \putenv($setting);
        if ($result === false) {
            $this->fail(
                'Failed to put an environment variable required for this '
                . 'test: "' . $setting . '"'
            );
        }
    }
    
    public function testGet_emptyString()
    {
        // Arrange
        $name = 'TEST_EMPTY_STRING';
        $this->putEnv($name . '=');
        $expected = '';
        
        // Act
        $actual = Env::get($name);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGet_false()
    {
        // Arrange
        $name = 'TEST_FALSE';
        $this->putEnv($name . '=false');
        $expected = false;
        
        // Act
        $actual = Env::get($name);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGet_falseTitlecase()
    {
        // Arrange
        $name = 'TEST_FALSE_TITLECASE';
        $this->putEnv($name . '=False');
        $expected = false;
        
        // Act
        $actual = Env::get($name);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGet_falseUppercase()
    {
        // Arrange
        $name = 'TEST_FALSE_UPPERCASE';
        $this->putEnv($name . '=FALSE');
        $expected = false;
        
        // Act
        $actual = Env::get($name);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGet_nonEmptyString()
    {
        // Arrange
        $name = 'TEST_NON_EMPTY_STRING';
        $this->putEnv($name . '=abc123');
        $expected = 'abc123';
        
        // Act
        $actual = Env::get($name);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGet_notSetHasDefault()
    {
        // Arrange
        $name = 'TEST_NOT_SET';
        $default = 'some default value';
        $expected = 'some default value';
        
        // Act
        $actual = Env::get($name, $default);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGet_notSetNoDefault()
    {
        // Arrange
        $name = 'TEST_NOT_SET';
        $expected = null;
        
        // Act
        $actual = Env::get($name);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGet_null()
    {
        // Arrange
        $name = 'TEST_NULL';
        $this->putEnv($name . '=null');
        $expected = null;
        
        // Act
        $actual = Env::get($name);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGet_nullTitlecase()
    {
        // Arrange
        $name = 'TEST_NULL_TITLECASE';
        $this->putEnv($name . '=Null');
        $expected = null;
        
        // Act
        $actual = Env::get($name);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGet_nullUppercase()
    {
        // Arrange
        $name = 'TEST_NULL_UPPERCASE';
        $this->putEnv($name . '=NULL');
        $expected = null;
        
        // Act
        $actual = Env::get($name);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGet_true()
    {
        // Arrange
        $name = 'TEST_TRUE';
        $this->putEnv($name . '=true');
        $expected = true;
        
        // Act
        $actual = Env::get($name);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGet_trueTitlecase()
    {
        // Arrange
        $name = 'TEST_TRUE_TITLECASE';
        $this->putEnv($name . '=True');
        $expected = true;
        
        // Act
        $actual = Env::get($name);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGet_trueUppercase()
    {
        // Arrange
        $name = 'TEST_TRUE_UPPERCASE';
        $this->putEnv($name . '=TRUE');
        $expected = true;
        
        // Act
        $actual = Env::get($name);

        // Assert
        $this->assertSame($expected, $actual);
    }
}
