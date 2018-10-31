<?php
namespace ZealByte\Bundle\UserBundle
{
	use Symfony\Component\HttpKernel\Bundle\Bundle;
	use Symfony\Component\DependencyInjection\ContainerBuilder;

	class UserBundle extends Bundle
	{
    /**
     * Builds the bundle.
     *
     * It is only ever called once when the cache is empty.
     *
     * This method can be overridden to register compilation passes,
     * other extensions, ...
     */
		public function build (ContainerBuilder $container)
		{
		}

	}
}
