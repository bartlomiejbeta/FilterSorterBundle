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


use BartB\FilterSorterBundle\Data\Filter\FilterAdapterInterface;
use BartB\FilterSorterBundle\Data\Filter\FilterInterface;
use BartB\FilterSorterBundle\Data\Limiter\Limit;
use BartB\FilterSorterBundle\Data\Sorter\Sort;
use BartB\FilterSorterBundle\Data\Transfer\BasicRepositoryDTO;
use BartB\FilterSorterBundle\Data\Transfer\QueryAttributesDTO;
use BartB\FilterSorterBundle\Exception\FilterQueryManagerException;
use BartB\FilterSorterBundle\Repository\AbstractEntitySpecificationAwareRepository;
use Doctrine\ORM\QueryBuilder;

class FilterQueryManager
{
	/** @var FilterAdapterInterface[] */
	private $filterAdapters;

	public function registerFilterAdapter(FilterAdapterInterface $filterAdapter)
	{
		$this->filterAdapters[] = $filterAdapter;
	}

	public function getQueryBuilder(BasicRepositoryDTO $basicRepositoryDTO, QueryAttributesDTO $queryAttributesDTO = null): QueryBuilder
	{
		$adapter                       = $this->getSupportedAdapter($basicRepositoryDTO);
		$entitySpecificationRepository = $basicRepositoryDTO->getAbstractEntitySpecificationAwareRepository();
		$query                         = $adapter->getQueryBuilder($entitySpecificationRepository);

		if ($queryAttributesDTO instanceof QueryAttributesDTO)
		{
			$this->applyQueryAttributes($query, $queryAttributesDTO, $adapter, $entitySpecificationRepository);
		}

		return $query;
	}

	private function getSupportedAdapter(BasicRepositoryDTO $basicRepositoryDTO): FilterAdapterInterface
	{
		$entityRepository = $basicRepositoryDTO->getAbstractEntitySpecificationAwareRepository();

		foreach ($this->filterAdapters as $adapter)
		{
			if ($adapter->supports($entityRepository, $basicRepositoryDTO->getFilterContext()))
			{
				return $adapter;
			}
		}
		throw FilterQueryManagerException::fromUnsupportedEntityRepository($entityRepository->getClassName());
	}

	private function applyQueryAttributes(QueryBuilder $query, QueryAttributesDTO $queryAttributesDTO, FilterAdapterInterface $adapter, AbstractEntitySpecificationAwareRepository $entitySpecificationRepository)
	{
		$filter = $queryAttributesDTO->getFilter();
		$sort   = $queryAttributesDTO->getSort();
		$limit  = $queryAttributesDTO->getLimit();

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

		if ($limit instanceof Limit)
		{
			$query->setMaxResults($limit->getLimit());
		}
	}
}
