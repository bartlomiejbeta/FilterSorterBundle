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

namespace BartB\FilterSorterBundle\Data\Filter;


use BartB\FilterSorterBundle\Data\Sorter\Sort;
use BartB\FilterSorterBundle\Repository\AbstractEntitySpecificationAwareRepository;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Specification\Specification;

interface FilterAdapterInterface
{
	public function supports(AbstractEntitySpecificationAwareRepository $entityRepository, FilterContextInterface $filterContext): bool;

	public function getQueryBuilder(AbstractEntitySpecificationAwareRepository $entityRepository): QueryBuilder;

	public function getSpecification(FilterInterface $filter): Specification;

	public function getOrderSpecification(Sort $sort): Specification;
}
