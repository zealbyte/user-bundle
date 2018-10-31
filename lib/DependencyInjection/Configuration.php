<?php
namespace ZealByte\Bundle\UserBundle\DependencyInjection
{
	use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
	use Symfony\Component\Config\Definition\Builder\TreeBuilder;
	use Symfony\Component\Config\Definition\ConfigurationInterface;

	class Configuration implements ConfigurationInterface
	{
		public function getConfigTreeBuilder ()
		{
			$treeBuilder = new TreeBuilder();
			$rootNode = $treeBuilder->root('user');

			$rootNode
				->children()
					->scalarNode('email_domain')->defaultValue('example.com')->end()
				->end();

			return $treeBuilder;
		}

	}
}
