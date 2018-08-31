<?php
/**
 * Created by PhpStorm.
 * User: bartb
 * Date: 8/31/18
 * Time: 10:38
 */

declare(strict_types=1);

namespace BartB\FilterSorterBundle\Data\Transfer;


use BartB\FilterSorterBundle\Data\Filter\FilterInterface;
use BartB\FilterSorterBundle\Data\Limiter\Limit;
use BartB\FilterSorterBundle\Data\Sorter\Sort;

class QueryAttributesDTO
{
	/** @var FilterInterface */
	private $filter;

	/** @var Sort */
	private $sort;

	/** @var Limit */
	private $limit;

	public function __construct(FilterInterface $filter = null, Sort $sort = null, Limit $limit = null)
	{
		$this->filter = $filter;
		$this->sort   = $sort;
		$this->limit  = $limit;
	}

	/** @return FilterInterface|null */
	public function getFilter()
	{
		return $this->filter;
	}

	/** @return Sort|null */
	public function getSort()
	{
		return $this->sort;
	}

	/** @return Limit|null */
	public function getLimit()
	{
		return $this->limit;
	}
}
