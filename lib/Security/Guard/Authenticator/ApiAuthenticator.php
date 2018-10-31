<?php
namespace ZealByte\Bundle\UserBundle\Security\Guard\Authenticator
{
	use Exception;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\Routing\RouterInterface;
	use Symfony\Component\Security\Core\Security;
	use Symfony\Component\Security\Core\User\UserInterface;
	use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
	use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
	use Symfony\Component\Security\Core\User\UserProviderInterface;
	use Symfony\Component\Security\Core\Exception\AuthenticationException;
	use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
	use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
	use Ipd\Api\Api;
	use App\Ipd\Api\ApiConnector;

	class ApiAuthenticator extends AbstractFormLoginAuthenticator
	{
		/**
		 * @var \App\Ipd\Api\ApiConnector;
		 */
		private $apiConnector;

		/**
		 * @var \Symfony\Component\Routing\RouterInterface
		 */
		private $router;

		/**
		 * Creates a new instance of ApiAuthenticator
		 */
		public function __construct (ApiConnector $apiConnector, ?RouterInterface $router = null)
		{
			if ($apiConnector)
				$this->apiConnector = $apiConnector;

			if ($router)
				$this->router = $router;
		}

		/**
		 * {@inheritdoc}
		 */
		public function supports (Request $request)
		{
			if ($request->isMethod('POST') && $request->request->has('_username') && $request->request->has('_password'))
				return true;
		}

		/**
		 * {@inheritdoc}
		 */
		public function getCredentials (Request $request)
		{
			if ($request->getMethod() != 'POST')
				return;

			$username = $request->request->get('_username');
			$password = $request->request->get('_password');

			if ($request->hasSession())
				$request->getSession()->set(Security::LAST_USERNAME, $username);

			return [
				'username' => $username,
				'password' => $password
			];
		}

		/**
		 * {@inheritdoc}
		 */
		public function getUser ($credentials, UserProviderInterface $userProvider)
		{
			if (!array_key_exists('username', $credentials) || empty($credentials['username']))
				return;

			$username = $credentials['username'];

			try {
				return $userProvider->loadUserByUsername($username);
			}
			catch (UsernameNotFoundException $e) {
				throw new AuthenticationException('Username not found!');
			}
		}

		public function checkCredentials ($credentials, UserInterface $user)
		{
			if (!array_key_exists('password', $credentials) || empty($credentials['password']))
				throw new AuthenticationException('No password supplied!');

			$username = $user->getUsername();
			$password = $credentials['password'];

			try {
				return ($this->apiConnector->connect($username, $password)) ? true : false;
			}
			catch (Exception $e) {
				throw new AuthenticationException($e->getmessage());
			}
		}

		public function onAuthenticationFailure (Request $request, AuthenticationException $exception)
		{
			if ($request->isXmlHttpRequest())
				return new JsonResponse([
					'status' => 'error',
					'message' => $exception->getMessageKey()
				], 403);

			//@todo This is bad, we should put this in a configuration yaml somewhere
			$url = $this->router->generate('login');
			$response = new RedirectResponse($url);

			return $response;
		}

		public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
		{
			if ($request->hasSession())
				$request->getSession()->set('ipdapi', $this->apiConnector->getApi());

			if ($request->isXmlHttpRequest())
				return new JsonResponse([
					'status'=>'success',
					'token' => $this->apiConnector->getAuth()->getToken()
				]);

			//@todo This is bad, we should put this in a configuration yaml somewhere
			$url = $this->router->generate('alarmdealer');
			$response = new RedirectResponse($url);

			return $response;
		}

		/**
		 * {@inheritdoc}
		 */
		public function supportsRememberMe ()
		{
			return false;
		}

		/**
		 * {@inheritdoc}
		 */
		protected function getLoginUrl()
		{
			return $this->router
				->generate('login');
		}

		/*
		protected function getDefaultSuccessRedirectUrl()
		{
			return $this->container->get('router')
				->generate('homepage');
		}
		 */
	}
}
