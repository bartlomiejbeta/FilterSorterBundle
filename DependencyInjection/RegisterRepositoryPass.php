<?php
/**
 * Created by PhpStorm.
 * User: bartb
 * Date: 30.08.2017
 * Time: 12:53
 */

//@formatter:off
declare(strict_types=1);
//@formatter:on

namespace BartB\DependencyInjection;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterRepositoryPass implements CompilerPassInterface
{
	/** @var string */
	private $repositoryName;

	/** @var string */
	private $tag;

	/** @var string */
	private $addMethodName;

	public function __construct(string $repositoryName, string $tag, string $addMethodName)
	{
		$this->repositoryName = $repositoryName;
		$this->tag            = $tag;
		$this->addMethodName  = $addMethodName;
	}

	/** {@inheritdoc} */
	public function process(ContainerBuilder $container)
	{
		if (!$container->hasDefinition($this->repositoryName) && !$container->hasAlias($this->repositoryName))
		{
			return;
		}

		$repositoryDefinition = $container->findDefinition($this->repositoryName);
		$argumentsForMethodCalls = new \SplPriorityQueue;

		foreach ($container->findTaggedServiceIds($this->tag) as $id => $tagsCollection)
		{
			foreach ($tagsCollection as $tag)
			{
				$arguments = [
					new Reference($id),
				];
				$priority = isset($tag['priority']) ? (int)$tag['priority'] : 0;
				$argumentsForMethodCalls->insert($arguments, $priority);
			}
		}

		foreach ($argumentsForMethodCalls as $priority => $arguments)
		{
			$repositoryDefinition->addMethodCall($this->addMethodName, $arguments);
		}
	}
}