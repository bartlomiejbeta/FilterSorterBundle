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

namespace BartB\Repository;


use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\EntitySpecificationRepository;

class AbstractEntitySpecificationAwareRepository extends EntitySpecificationRepository
{
	public function applySpecificationToQueryBuilder(QueryBuilder $queryBuilder, $specification = null, $alias = null)
	{
		$this->applySpecification($queryBuilder, $specification, $alias);
	}
}