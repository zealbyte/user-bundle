<?php
namespace ZealByte\Bundle\UserBundle\User
{
	use DateTimeInterface;
	use ZealByte\Identity\User\IdentityUserInterface;

	class User implements IdentityUserInterface
	{
		/**
		 * @var string
		 */
		private $id;

		/**
		 * @var string
		 */
		private $password;

		/**
		 * @var string
		 */
		private $salt;

		/**
		 * @var string
		 */
		private $username;

		/**
		 * @var bool
		 */
		protected $is_enabled;

		/**
		 * @var string
		 */
		protected $name;

		/**
		 * @var array (Role|string)[]
		 */
		private $roles = [];

		/**
		 * @var DateTimeInterface
		 */
		protected $time_created;

		/**
		 * @var string
		 */
		protected $email;


		/**
		 * Constructor
		 */
		public function __construct (?string $username = null, ?string $password = null, ?string $salt = null, ?array $roles = [])
		{
			$this->username = $username;
			$this->password = $password;
			$this->salt = $salt;
			$this->roles = $roles;
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
				$this->name,
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
				$this->name,
			) = unserialize($serialized);
		}

		/**
		 * {@inheritdoc}
		 *
		 * @return string The unique identifier
		 */
		public function getId () : string
		{
			return $this->id;
		}

		/**
		 * {@inheritdoc}
		 *
		 * @return (Role|string)[] The user roles
		 */
		public function getRoles () : ?array
		{
			$roles = $this->roles;

			$roles[] = 'ROLE_USER';

			return $roles;
		}

		/**
		 * {@inheritdoc}
		 *
		 * @return string The encoded password
		 */
		public function getPassword () : ?string
		{
			return $this->password;
		}

		/**
		 * {@inheritdoc}
		 *
		 * @return string|null The salt
		 */
		public function getSalt () : ?string
		{
			return $this->salt;
		}

		/**
		 * {@inheritdoc}
		 *
		 * @return string The username
		 */
		public function getUsername () : ?string
		{
			return $this->username;
		}

		/**
		 * @return string
		 */
		public function getName () : string
		{
			return (string) $this->name;
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
			return $this->is_enabled ? true : false;
		}

		/**
		 * {@inheritdoc}
		 */
		public function eraseCredentials () : self
		{
			$this->password = null;
			$this->salt = null;

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

			if ($role === 'ROLE_USER')
				return $this;

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
		 * @param string $name
		 */
		public function setName (string $name) : self
		{
			$this->name = $name;

			return $this;
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
		 * @param string $email
		 */
		public function setEmail (string $email) : self
		{
			$this->email = $email;

			return $this;
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
		 * Set the time the user was originally created.
		 *
		 * @param int $timeCreated A timestamp value.
		 */
		public function getTimeCreated () : ?DateTimeInterface
		{
			return $this->time_created;
		}

		/**
		 * Set the time the user was originally created.
		 *
		 * @param int $timeCreated A timestamp value.
		 */
		public function setTimeCreated (DateTimeInterface $timeCreated) : self
		{
			$this->time_created = $timeCreated;

			return $this;
		}

		/**
		 * Set emailCanonical.
		 *
		 * @param string $emailCanonical
		 *
		 * @return PamUser
		 */
		public function setEmailCanonical($emailCanonical) : self
		{
			$this->emailCanonical = $emailCanonical;

			return $this;
		}

		/**
		 * Set usernameCanonical.
		 *
		 * @param string $usernameCanonical
		 *
		 * @return PamUser
		 */
		public function setUsernameCanonical($usernameCanonical) : self
		{
			$this->usernameCanonical = $usernameCanonical;

			return $this;
		}

		/**
		 * Set whether the user is enabled.
		 *
		 * @param bool $isEnabled
		 */
		public function setEnabled (bool $isEnabled) : self
		{
			$this->is_enabled = $isEnabled;

			return $this;
		}

	}
}
