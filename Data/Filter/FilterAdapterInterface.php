<?php
/**
 * Created by PhpStorm.
 * User: bartb
 * Date: 30.08.2017
 * Time: 12:45
 */

//@formatter:off
declare(strict_types=1);
//@formatter:on

namespace BartB\Data\Filter;


use BartB\Data\Sorter\Sort;
use BartB\Repository\AbstractEntitySpecificationAwareRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Specification\Specification;

interface FilterAdapterInterface
{
	public function supports(EntityRepository $entityRepository): bool;

	public function getQueryBuilder(AbstractEntitySpecificationAwareRepository $entityRepository): QueryBuilder;

	public function getSpecification(FilterInterface $filter): Specification;

	public function getOrderSpecification(Sort $sort): Specification;
}