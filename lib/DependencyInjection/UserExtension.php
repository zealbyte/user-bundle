<?php
namespace ZealByte\Bundle\UserBundle\DependencyInjection
{
	use ReflectionClass;
	use RuntimeException;
	use Symfony\Component\Config\FileLocator;
	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\DependencyInjection\Loader;
	use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
	use Symfony\Component\HttpKernel\DependencyInjection\Extension;
	use Symfony\Component\HttpFoundation\RequestMatcher;

	class UserExtension extends Extension implements PrependExtensionInterface
	{
		/**
		 * {@inheritdoc}
		 */
		public function load (array $configs, ContainerBuilder $container)
		{
			$loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
			$loader->load('services.xml');

			$configuration = new Configuration();
			$config = $this->processConfiguration($configuration, $configs);
		}

		public function prepend (ContainerBuilder $container) : void
		{
			$this->prependDoctrine($container);
		}

		private function prependDoctrine (ContainerBuilder $container) : void
		{
			if (!$container->hasExtension('doctrine'))
				return;

			$config = [
				'orm' => [
					'mappings' => [
						'UserBundle' => [
							'is_bundle' => true,
						],
					],
				],
			];

			$container->prependExtensionConfig('doctrine', $config);
		}

	}
}
