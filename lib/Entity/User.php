<?php

namespace ZealByte\Bundle\UserBundle\Entity;

use ZealByte\Identity\User\IdentityUserInterface;

/**
 * PamUser
 */
class User implements IdentityUserInterface
{
	private $id;
	protected $name;
	protected $time_created;
	protected $confirmation_token;
	protected $timePasswordResetRequested;

	/**
	 * @var string
	 */
	private $userSpace;

	/**
	 * @var string
	 */
	private $username;

	/**
	 * @var string
	 */
	private $usernameCanonical;

	/**
	 * @var string
	 */
	private $email;

	/**
	 * @var string
	 */
	private $emailCanonical;

	/**
	 * @var string|null
	 */
	private $firstname;

	/**
	 * @var string|null
	 */
	private $lastname;

	/**
	 * @var bool
	 */
	private $isBanned = '0';

	/**
	 * @var bool
	 */
	private $isApproved = '0';

	/**
	 * @var \DateTime
	 */
	private $dateExpired = '0000-00-00 00:00:00';

	/**
	 * @var \DateTime
	 */
	private $dateUnlocked = '0000-00-00 00:00:00';

	/**
	 * @var \DateTime
	 */
	private $dateAdded = '0000-00-00 00:00:00';

	/**
	 * @var \DateTime
	 */
	private $dateModified = '0000-00-00 00:00:00';

	/**
	 * @var bool
	 */
	private $enabled;

	/**
	 * @var string
	 */
	private $salt;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * @var \DateTime|null
	 */
	private $lastLogin;

	/**
	 * @var bool
	 */
	private $locked;

	/**
	 * @var bool
	 */
	private $expired;

	/**
	 * @var \DateTime|null
	 */
	private $expiresAt;

	/**
	 * @var string|null
	 */
	private $confirmationToken;

	/**
	 * @var \DateTime|null
	 */
	private $passwordRequestedAt;

	/**
	 * @var array
	 */
	private $roles = [];

	/**
	 * @var bool
	 */
	private $credentialsExpired;

	/**
	 * @var \DateTime|null
	 */
	private $credentialsExpireAt;

	/**
	 * @var \DateTime|null
	 */
	private $dateOfBirth;

	/**
	 * @var string|null
	 */
	private $website;

	/**
	 * @var string|null
	 */
	private $biography;

	/**
	 * @var string|null
	 */
	private $gender;

	/**
	 * @var string|null
	 */
	private $locale;

	/**
	 * @var string|null
	 */
	private $timezone;

	/**
	 * @var string|null
	 */
	private $phone;

	/**
	 * @var string|null
	 */
	private $token;

	/**
	 * @var string|null
	 */
	private $twoStepCode;

	/**
	 * @var int
	 */
	private $pamId;


	/**
	 * Constructor.
	 *
	 * @param string $email
	 */
	public function __construct ()
	{
		$this->timeCreated = time();
		$this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
	}

	/**
	 * Set userSpace.
	 *
	 * @param string $userSpace
	 *
	 * @return PamUser
	 */
	public function setUserSpace($userSpace)
	{
		$this->userSpace = $userSpace;

		return $this;
	}

	/**
	 * Get userSpace.
	 *
	 * @return string
	 */
	public function getUserSpace()
	{
		return $this->userSpace;
	}

	/**
	 * Set usernameCanonical.
	 *
	 * @param string $usernameCanonical
	 *
	 * @return PamUser
	 */
	public function setUsernameCanonical($usernameCanonical)
	{
		$this->usernameCanonical = $usernameCanonical;

		return $this;
	}

	/**
	 * Get usernameCanonical.
	 *
	 * @return string
	 */
	public function getUsernameCanonical()
	{
		return $this->usernameCanonical;
	}

	/**
	 * Set emailCanonical.
	 *
	 * @param string $emailCanonical
	 *
	 * @return PamUser
	 */
	public function setEmailCanonical($emailCanonical)
	{
		$this->emailCanonical = $emailCanonical;

		return $this;
	}

	/**
	 * Get emailCanonical.
	 *
	 * @return string
	 */
	public function getEmailCanonical()
	{
		return $this->emailCanonical;
	}

	/**
	 * Set firstname.
	 *
	 * @param string|null $firstname
	 *
	 * @return PamUser
	 */
	public function setFirstname($firstname = null)
	{
		$this->firstname = $firstname;

		return $this;
	}

	/**
	 * Get firstname.
	 *
	 * @return string|null
	 */
	public function getFirstname()
	{
		return $this->firstname;
	}

	/**
	 * Set lastname.
	 *
	 * @param string|null $lastname
	 *
	 * @return PamUser
	 */
	public function setLastname($lastname = null)
	{
		$this->lastname = $lastname;

		return $this;
	}

	/**
	 * Get lastname.
	 *
	 * @return string|null
	 */
	public function getLastname()
	{
		return $this->lastname;
	}

	/**
	 * Set isBanned.
	 *
	 * @param bool $isBanned
	 *
	 * @return PamUser
	 */
	public function setIsBanned($isBanned)
	{
		$this->isBanned = $isBanned;

		return $this;
	}

	/**
	 * Get isBanned.
	 *
	 * @return bool
	 */
	public function getIsBanned()
	{
		return $this->isBanned;
	}

	/**
	 * Set isApproved.
	 *
	 * @param bool $isApproved
	 *
	 * @return PamUser
	 */
	public function setIsApproved($isApproved)
	{
		$this->isApproved = $isApproved;

		return $this;
	}

	/**
	 * Get isApproved.
	 *
	 * @return bool
	 */
	public function getIsApproved()
	{
		return $this->isApproved;
	}

	/**
	 * Set dateExpired.
	 *
	 * @param \DateTime $dateExpired
	 *
	 * @return PamUser
	 */
	public function setDateExpired($dateExpired)
	{
		$this->dateExpired = $dateExpired;

		return $this;
	}

	/**
	 * Get dateExpired.
	 *
	 * @return \DateTime
	 */
	public function getDateExpired()
	{
		return $this->dateExpired;
	}

	/**
	 * Set dateUnlocked.
	 *
	 * @param \DateTime $dateUnlocked
	 *
	 * @return PamUser
	 */
	public function setDateUnlocked($dateUnlocked)
	{
		$this->dateUnlocked = $dateUnlocked;

		return $this;
	}

	/**
	 * Get dateUnlocked.
	 *
	 * @return \DateTime
	 */
	public function getDateUnlocked()
	{
		return $this->dateUnlocked;
	}

	/**
	 * Set dateAdded.
	 *
	 * @param \DateTime $dateAdded
	 *
	 * @return PamUser
	 */
	public function setDateAdded($dateAdded)
	{
		$this->dateAdded = $dateAdded;

		return $this;
	}

	/**
	 * Get dateAdded.
	 *
	 * @return \DateTime
	 */
	public function getDateAdded()
	{
		return $this->dateAdded;
	}

	/**
	 * Set dateModified.
	 *
	 * @param \DateTime $dateModified
	 *
	 * @return PamUser
	 */
	public function setDateModified($dateModified)
	{
		$this->dateModified = $dateModified;

		return $this;
	}

	/**
	 * Get dateModified.
	 *
	 * @return \DateTime
	 */
	public function getDateModified()
	{
		return $this->dateModified;
	}

	/**
	 * Get enabled.
	 *
	 * @return bool
	 */
	public function getEnabled()
	{
		return $this->enabled;
	}

	/**
	 * Set lastLogin.
	 *
	 * @param \DateTime|null $lastLogin
	 *
	 * @return PamUser
	 */
	public function setLastLogin($lastLogin = null)
	{
		$this->lastLogin = $lastLogin;

		return $this;
	}

	/**
	 * Get lastLogin.
	 *
	 * @return \DateTime|null
	 */
	public function getLastLogin()
	{
		return $this->lastLogin;
	}

	/**
	 * Set locked.
	 *
	 * @param bool $locked
	 *
	 * @return PamUser
	 */
	public function setLocked($locked)
	{
		$this->locked = $locked;

		return $this;
	}

	/**
	 * Get locked.
	 *
	 * @return bool
	 */
	public function getLocked()
	{
		return $this->locked;
	}

	/**
	 * Set expired.
	 *
	 * @param bool $expired
	 *
	 * @return PamUser
	 */
	public function setExpired($expired)
	{
		$this->expired = $expired;

		return $this;
	}

	/**
	 * Get expired.
	 *
	 * @return bool
	 */
	public function getExpired()
	{
		return $this->expired;
	}

	/**
	 * Set expiresAt.
	 *
	 * @param \DateTime|null $expiresAt
	 *
	 * @return PamUser
	 */
	public function setExpiresAt($expiresAt = null)
	{
		$this->expiresAt = $expiresAt;

		return $this;
	}

	/**
	 * Get expiresAt.
	 *
	 * @return \DateTime|null
	 */
	public function getExpiresAt()
	{
		return $this->expiresAt;
	}

	/**
	 * Set passwordRequestedAt.
	 *
	 * @param \DateTime|null $passwordRequestedAt
	 *
	 * @return PamUser
	 */
	public function setPasswordRequestedAt($passwordRequestedAt = null)
	{
		$this->passwordRequestedAt = $passwordRequestedAt;

		return $this;
	}

	/**
	 * Get passwordRequestedAt.
	 *
	 * @return \DateTime|null
	 */
	public function getPasswordRequestedAt()
	{
		return $this->passwordRequestedAt;
	}

	/**
	 * Set credentialsExpired.
	 *
	 * @param bool $credentialsExpired
	 *
	 * @return PamUser
	 */
	public function setCredentialsExpired($credentialsExpired)
	{
		$this->credentialsExpired = $credentialsExpired;

		return $this;
	}

	/**
	 * Get credentialsExpired.
	 *
	 * @return bool
	 */
	public function getCredentialsExpired()
	{
		return $this->credentialsExpired;
	}

	/**
	 * Set credentialsExpireAt.
	 *
	 * @param \DateTime|null $credentialsExpireAt
	 *
	 * @return PamUser
	 */
	public function setCredentialsExpireAt($credentialsExpireAt = null)
	{
		$this->credentialsExpireAt = $credentialsExpireAt;

		return $this;
	}

	/**
	 * Get credentialsExpireAt.
	 *
	 * @return \DateTime|null
	 */
	public function getCredentialsExpireAt()
	{
		return $this->credentialsExpireAt;
	}

	/**
	 * Set dateOfBirth.
	 *
	 * @param \DateTime|null $dateOfBirth
	 *
	 * @return PamUser
	 */
	public function setDateOfBirth($dateOfBirth = null)
	{
		$this->dateOfBirth = $dateOfBirth;

		return $this;
	}

	/**
	 * Get dateOfBirth.
	 *
	 * @return \DateTime|null
	 */
	public function getDateOfBirth()
	{
		return $this->dateOfBirth;
	}

	/**
	 * Set website.
	 *
	 * @param string|null $website
	 *
	 * @return PamUser
	 */
	public function setWebsite($website = null)
	{
		$this->website = $website;

		return $this;
	}

	/**
	 * Get website.
	 *
	 * @return string|null
	 */
	public function getWebsite()
	{
		return $this->website;
	}

	/**
	 * Set biography.
	 *
	 * @param string|null $biography
	 *
	 * @return PamUser
	 */
	public function setBiography($biography = null)
	{
		$this->biography = $biography;

		return $this;
	}

	/**
	 * Get biography.
	 *
	 * @return string|null
	 */
	public function getBiography()
	{
		return $this->biography;
	}

	/**
	 * Set gender.
	 *
	 * @param string|null $gender
	 *
	 * @return PamUser
	 */
	public function setGender($gender = null)
	{
		$this->gender = $gender;

		return $this;
	}

	/**
	 * Get gender.
	 *
	 * @return string|null
	 */
	public function getGender()
	{
		return $this->gender;
	}

	/**
	 * Set locale.
	 *
	 * @param string|null $locale
	 *
	 * @return PamUser
	 */
	public function setLocale($locale = null)
	{
		$this->locale = $locale;

		return $this;
	}

	/**
	 * Get locale.
	 *
	 * @return string|null
	 */
	public function getLocale()
	{
		return $this->locale;
	}

	/**
	 * Set timezone.
	 *
	 * @param string|null $timezone
	 *
	 * @return PamUser
	 */
	public function setTimezone($timezone = null)
	{
		$this->timezone = $timezone;

		return $this;
	}

	/**
	 * Get timezone.
	 *
	 * @return string|null
	 */
	public function getTimezone()
	{
		return $this->timezone;
	}

	/**
	 * Set phone.
	 *
	 * @param string|null $phone
	 *
	 * @return PamUser
	 */
	public function setPhone($phone = null)
	{
		$this->phone = $phone;

		return $this;
	}

	/**
	 * Get phone.
	 *
	 * @return string|null
	 */
	public function getPhone()
	{
		return $this->phone;
	}

	/**
	 * Set token.
	 *
	 * @param string|null $token
	 *
	 * @return PamUser
	 */
	public function setToken($token = null)
	{
		$this->token = $token;

		return $this;
	}

	/**
	 * Get token.
	 *
	 * @return string|null
	 */
	public function getToken()
	{
		return $this->token;
	}

	/**
	 * Set twoStepCode.
	 *
	 * @param string|null $twoStepCode
	 *
	 * @return PamUser
	 */
	public function setTwoStepCode($twoStepCode = null)
	{
		$this->twoStepCode = $twoStepCode;

		return $this;
	}

	/**
	 * Get twoStepCode.
	 *
	 * @return string|null
	 */
	public function getTwoStepCode()
	{
		return $this->twoStepCode;
	}

	/**
	 * Get pamId.
	 *
	 * @return int
	 */
	public function getPamId()
	{
		return $this->pamId;
	}

	public function __toString ()
	{
		return $this->getUsername();
	}

	/**
	 * Returns the roles granted to the user.
	 *
	 * @return array A list of the user's roles.
	 */
	public function getRoles () : array
	{
		$roles = $this->roles;

		return array_unique($roles);
	}

	/**
	 * Set the user's roles to the given list.
	 *
	 * @param array $roles
	 */
	public function setRoles (array $roles) : self
	{
		$this->roles = [];

		foreach ($roles as $role)
			$this->addRole($role);

		return $this;
	}

	/**
	 * Test whether the user has the given role.
	 *
	 * @param string $role
	 * @return bool
	 */
	public function hasRole ($role) : bool
	{
		return in_array(strtoupper($role), $this->getRoles(), true);
	}

	/**
	 * Add the given role to the user.
	 *
	 * @param string $role
	 */
	public function addRole ($role) : self
	{
		$role = strtoupper($role);

		if (!$this->hasRole($role))
			$this->roles[] = $role;

		return $this;
	}

	/**
	 * Remove the given role from the user.
	 *
	 * @param string $role
	 */
	public function removeRole ($role) : self
	{
		if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
			unset($this->roles[$key]);
			$this->roles = array_values($this->roles);
		}

		return $this;
	}

	/**
	 * Set the user ID.
	 *
	 * @param int $id
	 */
	public function setId ($id) : self
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * Get the user ID.
	 *
	 * @return int
	 */
	public function getId ()
	{
		return $this->id;
	}

	/**
	 * Get the encoded password used to authenticate the user.
	 *
	 * On authentication, a plain-text password will be salted,
	 * encoded, and then compared to this value.
	 *
	 * @return string The encoded password.
	 */
	public function getPassword () : string
	{
		return (string) $this->password;
	}

	/**
	 * Set the encoded password.
	 *
	 * @param string $password
	 */
	public function setPassword (string $password) : self
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * Set the salt that should be used to encode the password.
	 *
	 * @param string $salt
	 */
	public function setSalt (string $salt) : self
	{
		$this->salt = $salt;

		return $this;
	}

	/**
	 * Returns the salt that was originally used to encode the password.
	 *
	 * This can return null if the password was not encoded using a salt.
	 *
	 * @return string The salt
	 */
	public function getSalt() : string
	{
		return (string) $this->salt;
	}

	/**
	 * Returns the username, if not empty, otherwise the email address.
	 *
	 * Email is returned as a fallback because username is optional,
	 * but the Symfony Security system depends on getUsername() returning a value.
	 * Use getRealUsername() to get the actual username value.
	 *
	 * This method is required by the UserInterface.
	 *
	 * @see getRealUsername
	 * @return string The username, if not empty, otherwise the email.
	 */
	public function getUsername () : string
	{
		return (string) ($this->username ?: $this->email);
	}

	/**
	 * Get the actual username value that was set,
	 * or null if no username has been set.
	 * Compare to getUsername, which returns the email if username is not set.
	 *
	 * @see getUsername
	 * @return string|null
	 */
	public function getRealUsername () : string
	{
		return (string) $this->username;
	}

	/**
	 * Test whether username has ever been set (even if it's currently empty).
	 *
	 * @return bool
	 */
	public function hasRealUsername () : bool
	{
		return !is_null($this->username);
	}

	/**
	 * @param string $username
	 */
	public function setUsername ($username) : self
	{
		$this->username = $username;

		return $this;
	}

	/**
	 * @return string The user's email address.
	 */
	public function getEmail () : string
	{
		return (string) $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail (string $email) : self
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * @param string $name
	 */
	public function setName (string $name) : self
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getName () : string
	{
		return (string) $this->name;
	}

	/**
	 * Returns the name, if set, or else "Anonymous {id}".
	 *
	 * @return string
	 */
	public function getDisplayName () : string
	{
		return (string) ($this->name ?: 'Anonymous ' . $this->id);
	}

	/**
	 * Set the time the user was originally created.
	 *
	 * @param int $timeCreated A timestamp value.
	 */
	public function setTimeCreated ($timeCreated) : self
	{
		$this->time_created = $timeCreated;

		return $this;
	}

	/**
	 * Set the time the user was originally created.
	 *
	 * @return int
	 */
	public function getTimeCreated ()
	{
		return $this->time_created;
	}

	/**
	 * Removes sensitive data from the user.
	 *
	 * This is a no-op, since we never store the plain text credentials in this object.
	 * It's required by UserInterface.
	 *
	 * @return void
	 */
	public function eraseCredentials () : void
	{
	}

	/**
	 * The Symfony Security component stores a serialized User object in the session.
	 * We only need it to store the user ID, because the user provider's refreshUser() method is called on each request
	 * and reloads the user by its ID.
	 *
	 * @see \Serializable::serialize()
	 */
	public function serialize ()
	{
		return serialize([
			$this->id,
			$this->username,
			$this->email,
		]);
	}

	/**
	 * @see \Serializable::unserialize()
	 */
	public function unserialize ($serialized)
	{
		list (
			$this->id,
			$this->username,
			$this->email,
		) = unserialize($serialized);
	}

	/**
	 * Validate the user object.
	 *
	 * @return array An array of error messages, or an empty array if there were no errors.
	 */
	public function validate ()
	{
		$errors = [];

		if (!$this->getEmail())
			$errors['email'] = 'Email address is required.';
		else if (!strpos($this->getEmail(), '@'))
			$errors['email'] = 'Email address appears to be invalid.';
		else if (strlen($this->getEmail()) > 100)
			$errors['email'] = 'Email address can\'t be longer than 100 characters.';


		if (!$this->getPassword())
			$errors['password'] = 'Password is required.';
		else if (strlen($this->getPassword()) > 255)
			$errors['password'] = 'Password can\'t be longer than 255 characters.';

		if (strlen($this->getName()) > 100)
			$errors['name'] = 'Name can\'t be longer than 100 characters.';

		// Username can't contain "@",
		// because that's how we distinguish between email and username when signing in.
		// (It's possible to sign in by providing either one.)
		if ($this->getRealUsername() && strpos($this->getRealUsername(), '@') !== false)
			$errors['username'] = 'Username cannot contain the "@" symbol.';

		return $errors;
	}

	/**
	 * Checks whether the user's account has expired.
	 *
	 * Internally, if this method returns false, the authentication system
	 * will throw an AccountExpiredException and prevent login.
	 *
	 * @return bool    true if the user's account is non expired, false otherwise
	 *
	 * @see AccountExpiredException
	 */
	public function isAccountNonExpired () : bool
	{
		return true;
	}

	/**
	 * Checks whether the user is locked.
	 *
	 * Internally, if this method returns false, the authentication system
	 * will throw a LockedException and prevent login.
	 *
	 * @see LockedException
	 *
	 * @return bool    true if the user is not locked, false otherwise
	 */
	public function isAccountNonLocked () : bool
	{
		return true;
	}

	/**
	 * Checks whether the user's credentials (password) has expired.
	 *
	 * Internally, if this method returns false, the authentication system
	 * will throw a CredentialsExpiredException and prevent login.
	 *
	 * @see CredentialsExpiredException
	 *
	 * @return bool    true if the user's credentials are non expired, false otherwise
	 */
	public function isCredentialsNonExpired () : bool
	{
		return true;
	}

	/**
	 * Checks whether the user is enabled.
	 *
	 * Internally, if this method returns false, the authentication system
	 * will throw a DisabledException and prevent login.
	 *
	 * Users are enabled by default.
	 *
	 * @return bool    true if the user is enabled, false otherwise
	 *
	 * @see DisabledException
	 */
	public function isEnabled () : bool
	{
		return $this->enabled ? true : false;
	}

	/**
	 * Set whether the user is enabled.
	 *
	 * @param bool $isEnabled
	 */
	public function setEnabled (bool $enabled) : self
	{
		$this->enabled = $enabled;

		return $this;
	}

	/**
	 * Set confirmationToken.
	 *
	 * @param string|null $confirmationToken
	 *
	 * @return PamUser
	 */
	public function setConfirmationToken (string $confirmationToken) : self
	{
		$this->confirmation_token = $confirmationToken;

		return $this;
	}

	/**
	 * Get confirmationToken.
	 *
	 * @return string|null
	 */
	public function getConfirmationToken () : string
	{
		return (string) $this->confirmation_token;
	}

	/**
	 * @param int|null $timestamp
	 */
	public function setTimePasswordResetRequested ($timestamp) : self
	{
		$this->timePasswordResetRequested = $timestamp ?: null;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getTimePasswordResetRequested ()
	{
		return $this->timePasswordResetRequested;
	}

	/**
	 * @param int $ttl Password reset request TTL, in seconds.
	 * @return bool
	 */
	public function isPasswordResetRequestExpired ($ttl)
	{
		$timeRequested = $this->getTimePasswordResetRequested();

		if (!$timeRequested)
			return true;

		return $timeRequested + $ttl < time();
	}
}
