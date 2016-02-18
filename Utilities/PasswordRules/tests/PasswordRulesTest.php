<?php
/**
 * Copyright (c) 2016 Ronald Dobley.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once('../src/PasswordRules.php');
use Curiosa\Utilities\PasswordRules\PasswordRules;

class PasswordRulesTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPassword()
    {
        $password = 'Qw34er56ty!';
        $validPass = new PasswordRules($password);

        // Assert
        $this->assertEquals($password, $validPass->getPassword());
    }

    /**
     * NOTE: if the default settings in PasswordRules.php are changed
     * the tests for settings may fail because he tests depend on setting
     * the value to a non-default value.
     */

    public function testSetGetMinLength()
    {
        $password = 'Qw34er56ty!';
        $settings = array('minLength' => 9);
        $validPass = new PasswordRules($password, $settings);

        // Assert
        $this->assertEquals(9, $validPass->getMinLength());
    }

    public function testSetGetMaxLength()
    {
        $password = 'Qw34er56ty!';
        $settings = array('maxLength' => 200);
        $validPass = new PasswordRules($password, $settings);

        // Assert
        $this->assertEquals(200, $validPass->getMaxLength());
    }

    public function testSetGetRequireAlpha()
    {
        $password = 'Qw34er56ty!';
        $settings = array('requireAlpha' => true);
        $validPass = new PasswordRules($password, $settings);

        // Assert
        $this->assertTrue($validPass->getRequireAlpha());
    }

    public function testSetGetRequireLowercase()
    {
        $password = 'Qw34er56ty!';
        $settings = array('requireLowercase' => true);
        $validPass = new PasswordRules($password, $settings);

        // Assert
        $this->assertTrue($validPass->getRequireLowercase());
    }

    public function testSetGetRequireUppercase()
    {
        $password = 'Qw34er56ty!';
        $settings = array('requireUppercase' => true);
        $validPass = new PasswordRules($password, $settings);

        // Assert
        $this->assertTrue($validPass->getRequireUppercase());
    }

    public function testSetGetRequireNumber()
    {
        $password = 'Qw34er56ty!';
        $settings = array('requireNumber' => true);
        $validPass = new PasswordRules($password, $settings);

        // Assert
        $this->assertTrue($validPass->getRequireNumber());
    }

    public function testSetGetRequireSpecialChar()
    {
        $password = 'Qw34er56ty!';
        $settings = array('requireSpecialChar' => true);
        $validPass = new PasswordRules($password, $settings);

        // Assert
        $this->assertTrue($validPass->getRequireSpecialChar());
    }

    public function testSetGetRequireNumberOrSpecialChar()
    {
        $password = 'Qw34er56ty!';
        $settings = array('requireNumberOrSpecialChar' => true);
        $validPass = new PasswordRules($password, $settings);

        // Assert
        $this->assertTrue($validPass->getRequireNumberOrSpecialChar());
    }

    public function testIsMinLength()
    {
        $password = 'Qw34er56ty!';
        $validPass = new PasswordRules($password);

        // Assert
        $this->assertTrue($validPass->getIsMinLength());
    }

    public function testIsNotMinLength()
    {
        $password = 'Qw34er!';
        $validPass = new PasswordRules($password);

        // Assert
        $this->assertFalse($validPass->getIsMinLength());
    }

    public function testIsMaxLength()
    {
        $password = 'Qw34er56ty!';
        $validPass = new PasswordRules($password);

        // Assert
        $this->assertTrue($validPass->getIsMaxLength());
    }

    public function testIsNotMaxLength()
    {
        $password = 'Qw34er56ty!';
        $settings = array('maxLength' => 6);
        $validPass = new PasswordRules($password, $settings);

        // Assert
        $this->assertFalse($validPass->getIsMaxLength());
    }

    public function testHasValidChars()
    {
        $password = 'Qw34er56ty !"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~';
        $validPass = new PasswordRules($password);

        // Assert
        $this->assertTrue($validPass->getHasVaildChars());
    }

    public function testNotHasValidChars()
    {
        $password = 'Qw34er56ty!123∆¨˚45678©';
        $validPass = new PasswordRules($password);

        // Assert
        $this->assertFalse($validPass->getHasVaildChars());
    }

    public function testHasAlpha()
    {
        $password = 'Qw34er56ty';
        $validPass = new PasswordRules($password);

        // Assert
        $this->assertTrue($validPass->getHasAlpha());
    }

    public function testNotHasAlpha()
    {
        $password = '12345678!';
        $validPass = new PasswordRules($password);

        // Assert
        $this->assertFalse($validPass->getHasAlpha());
    }

    public function testHasLowercase()
    {
        $password = 'Qw34er56ty!';
        $validPass = new PasswordRules($password);

        // Assert
        $this->assertTrue($validPass->getHasLowercase());
    }

    public function testNotHasLowercase()
    {
        $password = 'QW34ER56TY!';
        $validPass = new PasswordRules($password);

        // Assert
        $this->assertFalse($validPass->getHasLowercase());
    }

    public function testHasUppercase()
    {
        $password = 'Qw34er56ty!';
        $validPass = new PasswordRules($password);

        // Assert
        $this->assertTrue($validPass->getHasUppercase());
    }

    public function testNotHasUppercase()
    {
        $password = 'qw34er56ty!';
        $validPass = new PasswordRules($password);

        // Assert
        $this->assertFalse($validPass->getHasUppercase());
    }

    /* Tests for isValid() */
    public function testIsValidMinLength()
    {
        $password = 'Qw34er56ty!';
        $validPass = new PasswordRules($password);

        // Assert
        $this->assertTrue($validPass->getIsValid());
    }

    public function testIsValidNotMinLength()
    {
        $password = 'Qw34er!';
        $validPass = new PasswordRules($password);

        // Assert
        $this->assertFalse($validPass->getIsValid());
    }

    public function testIsValidMaxLength()
    {
        $password = 'Qw34er56ty!';
        $validPass = new PasswordRules($password);

        // Assert
        $this->assertTrue($validPass->getIsValid());
    }

    public function testIsValidNotMaxLength()
    {
        $password = 'Qw34er56ty!';
        $settings = array('maxLength' => 6);
        $validPass = new PasswordRules($password, $settings);

        // Assert
        $this->assertFalse($validPass->getIsValid());
    }

    public function testIsValidValidChars()
    {
        $password = 'Qw34er56ty !"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~';
        $validPass = new PasswordRules($password);

        // Assert
        $this->assertTrue($validPass->getIsValid());
    }

    public function testIsValidNotValidChars()
    {
        $password = 'Qw34er56ty!123∆¨˚45678©';
        $validPass = new PasswordRules($password);

        // Assert
        $this->assertFalse($validPass->getIsValid());
    }

    public function testIsValidHasAlpha()
    {
        $password = 'Qw34er56ty';
        $settings = array('requireAlpha' => true);
        $validPass = new PasswordRules($password, $settings);

        // Assert
        $this->assertTrue($validPass->getIsValid());
    }

    public function testIsValidNotHasAlpha()
    {
        $password = '12345678!';
        $settings = array('requireAlpha' => true);
        $validPass = new PasswordRules($password, $settings);

        // Assert
        $this->assertFalse($validPass->getIsValid());
    }

    public function testIsValidHasLowercase()
    {
        $password = 'Qw34er56ty!';
        $settings = array('requireLowercase' => true);
        $validPass = new PasswordRules($password, $settings);

        // Assert
        $this->assertTrue($validPass->getIsValid());
    }

    public function testIsValidNotHasLowercase()
    {
        $password = 'QW34ER56TY!';
        $settings = array('requireLowercase' => true);
        $validPass = new PasswordRules($password, $settings);

        // Assert
        $this->assertFalse($validPass->getIsValid());
    }

    public function testIsValidHasUppercase()
    {
        $password = 'Qw34er56ty!';
        $settings = array('requireUppercase' => true);
        $validPass = new PasswordRules($password, $settings);

        // Assert
        $this->assertTrue($validPass->getIsValid());
    }

    public function testIsValidNotHasUppercase()
    {
        $password = 'qw34er56ty!';
        $settings = array('requireUppercase' => true);
        $validPass = new PasswordRules($password, $settings);

        // Assert
        $this->assertFalse($validPass->getIsValid());
    }

    /* Test getErrors() */
    public function testGetErrors()
    {
        $password = 'qw34er56ty!';
        $settings = array('requireUppercase' => true);
        $validPass = new PasswordRules($password, $settings);
        $errors = $validPass->getErrors();

        // Assert
        $this->assertArrayHasKey('noUppercase', $errors[0]);
    }
}