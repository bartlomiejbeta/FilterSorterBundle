<?php
/**
 * Created by PhpStorm.
 * User: bartb
 * Date: 30.08.2017
 * Time: 12:33
 */

//@formatter:off
declare(strict_types=1);
//@formatter:on

namespace BartB\FilterSorterBundle;


use BartB\FilterSorterBundle\DependencyInjection\RegisterRepositoryPass;
use BartB\FilterSorterBundle\Filter\FilterQueryManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FilterSorterBundle extends Bundle
{
	const FILTER_MANAGER       = FilterQueryManager::class;
	const FILTER_QUERY_ADAPTER = 'filter.query.adapter';

	/** {@inheritdoc} */
	public function build(ContainerBuilder $container)
	{
		parent::build($container);

		$container->addCompilerPass(new RegisterRepositoryPass(self::FILTER_MANAGER, self::FILTER_QUERY_ADAPTER, 'registerFilterAdapter'));
	}
}