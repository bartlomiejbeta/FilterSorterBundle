<?php
/**
 * Created by PhpStorm.
 * User: bartb
 * Date: 30.08.2017
 * Time: 12:43
 */

//@formatter:off
declare(strict_types=1);
//@formatter:on

namespace BartB\FilterSorterBundle\Filter;


use BartB\Data\Filter\FilterAdapterInterface;
use BartB\Data\Filter\FilterInterface;
use BartB\Data\Sorter\Sort;
use BartB\Exception\FilterQueryManagerException;
use BartB\Repository\AbstractEntitySpecificationAwareRepository;
use Doctrine\ORM\QueryBuilder;

class FilterQueryManager
{
	/** @var FilterAdapterInterface[] */
	private $filterAdapters;

	public function registerFilterAdapter(FilterAdapterInterface $filterAdapter)
	{
		$this->filterAdapters[] = $filterAdapter;
	}

	public function getQuery(AbstractEntitySpecificationAwareRepository $entitySpecificationRepository, FilterInterface $filter = null, Sort $sort = null): QueryBuilder
	{
		$adapter = $this->getSupportedAdapter($entitySpecificationRepository);
		$query   = $adapter->getQueryBuilder($entitySpecificationRepository);

		if ($filter instanceof FilterInterface)
		{
			$specification = $adapter->getSpecification($filter);

			$entitySpecificationRepository->applySpecificationToQueryBuilder($query, $specification);
		}

		if ($sort instanceof Sort)
		{
			$orderSpecification = $adapter->getOrderSpecification($sort);

			$entitySpecificationRepository->applySpecificationToQueryBuilder($query, $orderSpecification);
		}

		return $query;
	}

	private function getSupportedAdapter(AbstractEntitySpecificationAwareRepository $entityRepository): FilterAdapterInterface
	{
		foreach ($this->filterAdapters as $adapter)
		{
			if ($adapter->supports($entityRepository))
			{
				return $adapter;
			}
		}
		throw FilterQueryManagerException::fromUnsupportedEntityRepository($entityRepository->getClassName());
	}
}