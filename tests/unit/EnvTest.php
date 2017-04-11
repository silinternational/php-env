<?php
namespace Sil\PhpEnv\tests;

use PHPUnit\Framework\TestCase;
use Sil\PhpEnv\Env;
use Sil\PhpEnv\EnvVarNotFoundException;

class EnvTest extends TestCase
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
    
    public function testGet_notFoundNull()
    {
        // Arrange
        $name = 'TESTGET_NOTFOUNDNULL';
        $expected = null;
        
        // Act
        $actual = Env::get($name);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGet_emptyString()
    {
        // Arrange
        $name = 'TESTGET_EMPTYSTRING';
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
        $name = 'TESTGET_FALSE';
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
        $name = 'TESTGET_FALSETITLECASE';
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
        $name = 'TESTGET_FALSEUPPERCASE';
        $this->putEnv($name . '=FALSE');
        $expected = false;
        
        // Act
        $actual = Env::get($name);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGet_nonEmptyLowercaseString()
    {
        // Arrange
        $name = 'TESTGET_NONEMPTYLOWERCASESTRING';
        $this->putEnv($name . '=abc123');
        $expected = 'abc123';
        
        // Act
        $actual = Env::get($name);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGet_nonEmptyMixedCaseString()
    {
        // Arrange
        $name = 'TESTGET_NONEMPTYMIXEDCASESTRING';
        $this->putEnv($name . '=aBc123');
        $expected = 'aBc123';
        
        // Act
        $actual = Env::get($name);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGet_nonEmptyUppercaseString()
    {
        // Arrange
        $name = 'TESTGET_NONEMPTYUPPERCASESTRING';
        $this->putEnv($name . '=ABC123');
        $expected = 'ABC123';
        
        // Act
        $actual = Env::get($name);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGet_notSetHasDefault()
    {
        // Arrange
        $name = 'TESTGET_NOTSETHASDEFAULT';
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
        $name = 'TESTGET_NOTSETNODEFAULT';
        $expected = null;
        
        // Act
        $actual = Env::get($name);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGet_null()
    {
        // Arrange
        $name = 'TESTGET_NULL';
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
        $name = 'TESTGET_NULLTITLECASE';
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
        $name = 'TESTGET_NULLUPPERCASE';
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
        $name = 'TESTGET_TRUE';
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
        $name = 'TESTGET_TRUETITLECASE';
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
        $name = 'TESTGET_TRUEUPPERCASE';
        $this->putEnv($name . '=TRUE');
        $expected = true;
        
        // Act
        $actual = Env::get($name);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testRequireEnv_exists()
    {
        // Arrange
        $varname = 'TESTREQUIREENV_EXISTS';
        $this->putEnv($varname . '=exists');
        $expected = 'exists';
        
        // Actual
        $actual = Env::requireEnv($varname);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testRequireEnv_notfound()
    {
        // Arrange
        $varname = 'TESTREQUIREENV_NOTFOUND';
        
        // Actual
        $this->expectException(EnvVarNotFoundException::class);
        Env::requireEnv($varname);

        // Assert
        $this->fail("Should have thrown EnvVarNotFoundException.");
    }
    
    public function testRequireEnv_empty()
    {
        // Arrange
        $varname = 'TESTREQUIREENV_EMPTY';
        $this->putEnv($varname . '=');
        
        // Actual
        $this->expectException(EnvVarNotFoundException::class);

        Env::requireEnv($varname);

        // Assert
        $this->fail("Should have thrown EnvVarNotFoundException.");
    }
   
    public function testGetArray_notFoundExists()
    {
        // Arrange
        $varname = 'TESTGETARRAY_NOTFOUNDEXISTS';
        $expected = [];
        
        // Actual
        $actual = Env::getArray($varname);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGetArray_0exists()
    {
        // Arrange
        $varname = 'TESTGETARRAY_0EXISTS';
        $this->putEnv($varname . '=');
        $expected = [''];
        
        // Actual
        $actual = Env::getArray($varname);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGetArray_1exists()
    {
        // Arrange
        $varname = 'TESTGETARRAY_1EXISTS';
        $this->putEnv($varname . '=a');
        $expected = ['a'];
        
        // Actual
        $actual = Env::getArray($varname);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGetArray_multiExists()
    {
        // Arrange
        $varname = 'TESTGETARRAY_MULTIEXISTS';
        $this->putEnv($varname . '=a,b,c');
        $expected = ['a', 'b', 'c'];
        
        // Actual
        $actual = Env::getArray($varname);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGetArray_multiEmptyExists()
    {
        // Arrange
        $varname = 'TESTGETARRAY_MULTIEMPTYEXISTS';
        $this->putEnv($varname . '=a,b,,,c');
        $expected = ['a', 'b', '', '', 'c'];
        
        // Actual
        $actual = Env::getArray($varname);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGetArray_existsWithDefault()
    {
        // Arrange
        $varname = 'TESTGETARRAY_EXISTSWITHDEFAULT';
        $this->putEnv($varname . '=a,b,c');
        $default = ['x', 'y', 'z'];
        $expected = ['a', 'b', 'c'];
        
        // Actual
        $actual = Env::getArray($varname, $default);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGetArray_notFoundWithDefault()
    {
        // Arrange
        $varname = 'TESTGETARRAY_NOTFOUNDWITHDEFAULT';
        $default = ['x', 'y', 'z'];
        $expected = ['x', 'y', 'z'];
        
        // Actual
        $actual = Env::getArray($varname, $default);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testGetArray_existsWithInvalidDefaultType()
    {
        // Arrange
        $varname = 'TESTGETARRAY_EXISTSWITHINVALIDDEFAULTTYPE';
        $this->putEnv($varname . '=a,b,c');
        $default = 'x,y,z';
        
        // Actual
        $this->expectException(\TypeError::class);
        Env::getArray($varname, $default);

        // Assert
        $this->fail("Should have thrown TypeError on default array.");
    }
    
    public function testGetArray_notFoundWithInvalidDefaultType()
    {
        // Arrange
        $varname = 'TESTGETARRAY_EXISTSWITHINVALIDDEFAULTTYPE';
        $default = 'x,y,z';
        
        // Actual
        $this->expectException(\TypeError::class);
        Env::getArray($varname, $default);

        // Assert
        $this->fail("Should have thrown TypeError on default array.");
    }
    
    public function testRequireArray_exists()
    {
        // Arrange
        $varname = 'TESTREQUIREARRAY_EXISTS';
        $this->putEnv($varname . '=a,b,c');
        $expected = ['a', 'b', 'c'];
        
        // Actual
        $actual = Env::requireArray($varname);

        // Assert
        $this->assertSame($expected, $actual);
    }
    
    public function testRequireArray_notfound()
    {
        // Arrange
        $varname = 'TESTREQUIREARRAY_NOTFOUND';
        
        // Actual
        $this->expectException(EnvVarNotFoundException::class);
        Env::requireEnv($varname);

        // Assert
        $this->fail("Should have thrown EnvVarNotFoundException.");
    }
    
    public function testRequireArray_empty()
    {
        // Arrange
        $varname = 'TESTREQUIREARRAY_EMPTY';
        $this->putEnv($varname . '=');
        
        // Actual
        $this->expectException(EnvVarNotFoundException::class);
        Env::requireArray($varname);

        // Assert
        $this->fail("Should have thrown EnvVarNotFoundException.");
    }
}
