<?php
/**
 * PasswordRules.php
 *
 * Copyright (c) 2016 Ronald Dobley
 *
 * For the full copyright and license information, please view the
 * LICENSE.txt file that was distributed with this source code.
 */
namespace Curiosa\Utilities\PasswordRules;

class PasswordRules
{

	/**
	 * Errors and messages
	 */
	const MIN_LENGTH = 'minLength';
	const MAX_LENGTH = 'maxLength';
	const INVALID_CHARS = 'invalidChars';
	const NO_LETTER = 'noLetter';
	const NO_UPPERCASE = 'noUppercase';
	const NO_LOWERCASE = 'noLowercase';
	const NO_NUMBER = 'noNumber';
	const NO_SPECIAL_CHAR = 'noSpecialChar';
	const NO_NUMBER_OR_SPECIAL_CHAR = 'noNumberOrSpecialChar';

	/**
	 * The byte values of allowed special characters
	 *
	 * @var array
	 */
	static $allowedSpecialCharBytes = array(
		32, 33, 34, 35, 36, 37, 38, 39,
		40, 41, 42, 43, 44, 45, 46, 47,
		58, 59, 60, 61, 62, 63, 64, 91,
		92, 93, 94, 95, 96, 123, 124, 125, 126
		);

	/**
	 * Password
	 *
	 * @access protected
	 * @var string
	 */
	protected $password;

	/**
	 * The minimum length of the password
	 *
	 * Default value = 8
	 *
	 * @access protected
	 * @var integer
	 */
	protected $minLength = 8;

	/**
	 * The maximum length of the password
	 *
	 * Default value = 255
	 *
	 * @access protected
	 * @var integer
	 */
	protected $maxLength = 255;

	/**
	 * Require Alpha
	 *
	 * Default value = false
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $requireAlpha = false;

	/**
	 * Require Lowercase
	 *
	 * Default value = false
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $requireLowercase = false;

	/**
	 * Require Uppercase
	 *
	 * Default value = false
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $requireUppercase = false;

	/**
	 * Require Number
	 *
	 * Default value = false
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $requireNumber = false;

	/**
	 * Require SpecialChar
	 *
	 * Default value = false
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $requireSpecialChar = false;

	/**
	 * Require Number OR SpecialChar
	 * Only one case needs to be met
	 *
	 * Default value = false
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $requireNumberOrSpecialChar = false;

	/**
	 * The valid state of the password
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $isValid;

	/**
	 * Is minimum length
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $isMinLength;

	/**
	 * Is maximum length
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $isMaxLength;

	/**
	 * Has valid characters
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $hasValidChars;

	/**
	 * Has a alpha character
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $hasAlpha;

	/**
	 * Has a lowecase character
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $hasLowercase;

	/**
	 * Has a UPPERCASE character
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $hasUppercase;

	/**
	 * Has a number character
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $hasNumber;

	/**
	 * Has a SpecialChar character
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $hasSpecialChar;

	/**
	 * Array of validation failure errors where
	 * the key is the error and the value is the error message
	 *
	 * @access protected
	 * @var array
	 */
	protected $errors = array();

	/**
	 * Constructor
	 *
	 * @see \Curiosa\Utilities\PasswordRules::setConfig() for configurable settings
	 * @access public
	 * @param string $password
	 * @param array [optional] $config
	 */
	public function __construct($password, array $config = array())
	{
		if($config) $this->setConfig($config);

		/*
		 * Run all of the checks, then run isValid() to see if the
		 * password meets the rules
		 */
		$this->password = $password;
		$this->isMinLength = $this->checkMinLength();
		$this->isMaxLength = $this->checkMaxLength();
		$this->hasValidChars = $this->hasValidChars();
		$this->hasAlpha = $this->hasAlpha();
		$this->hasLowercase = $this->hasLowercase();
		$this->hasUppercase = $this->hasUppercase();
		$this->hasNumber = $this->hasNumber();
		$this->hasSpecialChar = $this->hasSpecialChar();

		$this->isValid();
	}

	/**
	 * SetConfig
	 *
	 * Pass an array with the setting as the key
	 *
	 * Configurable settings are:
	 *
	 * minLength
	 * maxLength
	 * requireAlpha
	 * requireLowercase
	 * requireUppercase
	 * requireNumber
	 * requireSpecialChar
	 * requireNumberOrSpecialChar
	 *
	 * @access protected
	 * @param array $config
	 * @return void
	 */
	protected function setConfig($config)
	{
		if(array_key_exists('minLength', $config))
		{
			$this->minLength = intval($config['minLength']);
		}

		if(array_key_exists('maxLength', $config))
		{
			$this->maxLength = intval($config['maxLength']);
		}

		if(array_key_exists('requireAlpha', $config))
		{
			$this->requireAlpha = (bool) $config['requireAlpha'];
		}

		if(array_key_exists('requireLowercase', $config))
		{
			$this->requireLowercase = (bool) $config['requireLowercase'];
		}

		if(array_key_exists('requireUppercase', $config))
		{
			$this->requireUppercase = (bool) $config['requireUppercase'];
		}

		if(array_key_exists('requireNumber', $config))
		{
			$this->requireNumber = (bool) $config['requireNumber'];
		}

		if(array_key_exists('requireSpecialChar', $config))
		{
			$this->requireSpecialChar = (bool) $config['requireSpecialChar'];
		}

		if(array_key_exists('requireNumberOrSpecialChar', $config))
		{
			$this->requireNumberOrSpecialChar = (bool) $config['requireNumberOrSpecialChar'];
		}
	}

	/**
	 * IsValid
	 *
	 * Will check the password for min and max length as well as valid characters.
	 *
	 * Then, based on the config options, it will check the other rules.
	 *
	 * If a check fails the error is appended to the $errors
	 * To get the errors call getErrors().
	 *
	 * @access protected
	 * @return void
	 */
	protected function isValid()
	{
		$isValid = true;

		/* These have to be meet to be valid */
		if($this->isMinLength === false)
		{
			$isValid = false;
			$this->addError(self::MIN_LENGTH, 'Password must be at least ' . $this->minLength . ' characters long');
		}

		if($this->isMaxLength === false)
		{
			$isValid = false;
			$this->addError(self::MAX_LENGTH, 'Password must be less than ' . $this->maxLength . ' characters long');
		}

		if($this->hasValidChars === false)
		{
			$isValid = false;
			$this->addError(self::INVALID_CHARS, 'Password contains invalid characters: ' . $this->findInvalidChars());
		}

		/* These are checked based on the config options */
		if($this->requireAlpha && $this->hasAlpha === false)
		{
			$isValid = false;
			$this->addError(self::NO_LETTER, 'Password does not have a letter');
		}

		if($this->requireLowercase && $this->hasLowercase === false)
		{
			$isValid = false;
			$this->addError(self::NO_LOWERCASE, 'Password does not have a lowercase letter');
		}

		if($this->requireUppercase && $this->hasUppercase === false)
		{
			$isValid = false;
			$this->addError(self::NO_UPPERCASE, 'Password does not have an UPPERCASE letter');
		}

		if($this->requireNumber && $this->hasNumber === false)
		{
			$isValid = false;
			$this->addError(self::NO_NUMBER, 'Password does not have a number');
		}

		if($this->requireSpecialChar && $this->hasSpecialChar === false)
		{
			$isValid = false;
			$this->addError(self::NO_SPECIAL_CHAR, 'Password does not have a special character');
		}

		if($this->requireNumberOrSpecialChar)
		{
			/* Only one of these needs to be met */
			if($this->hasNumber === false && $this->hasSpecialChar === false)
			{
				$isValid = false;
				$this->addError(self::NO_NUMBER_OR_SPECIAL_CHAR, 'Password must have a number or a special character');
			}
		}

		$this->isValid = $isValid;
	}

	/**
	 * Has Valid Chars
	 *
	 * Valid Chars are ASCII 32 thru 126
	 *
	 * @see http://en.wikipedia.org/wiki/ASCII#ASCII_printable_characters
	 * @access protected
	 * @return bool
	 */
	protected function hasValidChars()
	{
		$res = filter_var($this->password, FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
		if($res == $this->password) {
			return true;
		}
		return false;
	}

	protected function findInvalidChars()
	{
		$badChars = '';
		// get the password into an array
		$arrPassword = str_split($this->password);
		// loop through each char and see if it is an allowed char
		foreach($arrPassword as $key => $val)
		{
			// we only care about chars above 126, as anything below 32 is a control char
			if(ord($val) > 126)
			{
				$badChars .= $val;
			}
		}
		return $badChars;
	}

	/**
	 * Check Min Length
	 *
	 * @access protected
	 * @return boolean
	 */
	protected function checkMinLength()
	{
		if(strlen($this->password) < $this->minLength)
		{
			return false;
		}
		return true;
	}

	/**
	 * Check Max Length
	 *
	 * @access protected
	 * @return boolean
	 */
	protected function checkMaxLength()
	{
		if(strlen($this->password) > $this->maxLength)
		{
			return false;
		}
		return true;
	}

	/**
	 * Check for a letter
	 *
	 * @protected
	 * @return boolean
	 */
	protected function hasAlpha()
	{
		return (bool) preg_match('~[a-zA-Z]~', $this->password);
	}

	/**
	 * Check for a lowercase letter
	 *
	 * @access protected
	 * @return boolean
	 */
	protected function hasLowercase()
	{
		return (bool) preg_match('~[a-z]~', $this->password);
	}

	/**
	 * Checks for an UPPERCASE letter
	 *
	 * @access protected
	 * @return boolean
	 */
	protected function hasUppercase()
	{
		return (bool) preg_match('~[A-Z]~', $this->password);
	}

	/**
	 * Check for a number
	 *
	 * @access protected
	 * @return boolean
	 */
	protected function hasNumber()
	{
		return (bool) preg_match('~[0-9]~', $this->password);
	}

	/**
	 * Check to for a SpecialChar
	 *
	 * @access protected
	 * @return boolean
	 */
	protected function hasSpecialChar()
	{
		// Get the bytes vals for all of the chars
		$charsBytes = count_chars($this->password, 1);
		// The byte vals are set as keys, we just want the key values
		$charsBytesKeys = array_keys($charsBytes);
		// Compare the values of the SpecialChars array to our values
		// If they intersect we have a SpecialChar in the password
		return (bool) array_intersect(self::$allowedSpecialCharBytes, $charsBytesKeys);
	}

	/**
	 * Adds a validation failure error
	 *
	 * @access protected
	 * @param const $error one of the class error constants
	 * @param string $message
	 */
	protected function addError($error, $message)
	{
		array_push($this->errors, array($error => $message));
	}

	/**
	 * Gets the errors from the last call to isValid()
	 *
	 * If called and the password is valid this will return and empty array
	 *
	 * @access public
	 * @return array the errors from the last call to isValid()
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 * Get password
	 *
	 * @access public
	 * @return string $this->password
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Get minLength
	 *
	 * @access public
	 * @return int $this->minLength
	 */
	public function getMinLength()
	{
		return $this->minLength;
	}

	/**
	 * Get maxLength
	 *
	 * @access public
	 * @return int $this->maxLength
	 */
	public function getMaxLength()
	{
		return $this->maxLength;
	}

	/**
	 * Get requireAlpha
	 *
	 * @access public
	 * @return bool $this->requireAlpha
	 */
	public function getRequireAlpha()
	{
		return $this->requireAlpha;
	}

	/**
	 * Get requireLowercase
	 *
	 * @access public
	 * @return bool $this->requireLowercase
	 */
	public function getRequireLowercase()
	{
		return $this->requireLowercase;
	}

	/**
	 * Get requireUppercase
	 *
	 * @access public
	 * @return bool $this->requireUppercase
	 */
	public function getRequireUppercase()
	{
		return $this->requireUppercase;
	}

	/**
	 * Get requireNumber
	 *
	 * @access public
	 * @return bool $this->requireNumber
	 */
	public function getRequireNumber()
	{
		return $this->requireNumber;
	}

	/**
	 * Get requireSpecialChar
	 *
	 * @access public
	 * @return bool $this->requireSpecialChar
	 */
	public function getRequireSpecialChar()
	{
		return $this->requireSpecialChar;
	}

	/**
	 * Get requireNumberOrSpecialChar
	 *
	 * @access public
	 * @return bool $this->requireNumberOrSpecialChar
	 */
	public function getRequireNumberOrSpecialChar()
	{
		return $this->requireNumberOrSpecialChar;
	}

	/**
	 * Get isValid
	 *
	 * @access public
	 * @return bool $this->isValid
	 */
	public function getIsValid()
	{
		return $this->isValid;
	}

	/**
	 * Get isMaxLength
	 *
	 * @access public
	 * @return bool $this->isMaxLength
	 */
	public function getIsMaxLength()
	{
		return $this->isMaxLength;
	}

	/**
	 * Get isMinLength
	 *
	 * @access public
	 * @return bool $this->isMinLength
	 */
	public function getIsMinLength()
	{
		return $this->isMinLength;
	}

	/**
	 * Get hasValidChars
	 *
	 * @access public
	 * @return bool $this->hasValidChars
	 */
	public function getHasVaildChars()
	{
		return $this->hasValidChars;
	}

	/**
	 * Get hasAlpha
	 *
	 * @access public
	 * @return bool $this->hasAlpha
	 */
	public function getHasAlpha()
	{
		return $this->hasAlpha;
	}

	/**
	 * Get hasLowercase
	 *
	 * @access public
	 * @return bool $this->hasLowercase
	 */
	public function getHasLowercase()
	{
		return $this->hasLowercase;
	}

	/**
	 * Get hasUppercase
	 *
	 * @access public
	 * @return bool $this->hasUppercase
	 */
	public function getHasUppercase()
	{
		return $this->hasUppercase;
	}

	/**
	 * Get hasNumber
	 *
	 * @access public
	 * @return bool $this->hasNumber
	 */
	public function getHasNumber()
	{
		return $this->hasNumber;
	}

	/**
	 * Get getHasSpecialChar
	 *
	 * @access public
	 * @return bool $this->getHasSpecialChar
	 */
	public function getHasSpecialChar()
	{
		return $this->hasSpecialChar;
	}
}