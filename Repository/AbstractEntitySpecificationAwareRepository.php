<?php
/**
 * Created by PhpStorm.
 * User: bartb
 * Date: 30.08.2017
 * Time: 12:49
 */

//@formatter:off
declare(strict_types=1);
//@formatter:on

namespace BartB\FilterSorterBundle\Repository;


use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\EntitySpecificationRepository;
use Happyr\DoctrineSpecification\Specification\Specification;

class AbstractEntitySpecificationAwareRepository extends EntitySpecificationRepository
{
	public function applySpecificationToQueryBuilder(QueryBuilder $queryBuilder, Specification $specification = null, string $alias = null)
	{
		$this->applySpecification($queryBuilder, $specification, $alias);
	}
}