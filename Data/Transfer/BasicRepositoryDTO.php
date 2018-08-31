<?php
/**
 * Created by PhpStorm.
 * User: bartb
 * Date: 8/31/18
 * Time: 10:32
 */

declare(strict_types=1);

namespace BartB\FilterSorterBundle\Data\Transfer;


use BartB\FilterSorterBundle\Data\Filter\FilterContextInterface;
use BartB\FilterSorterBundle\Repository\AbstractEntitySpecificationAwareRepository;

class BasicRepositoryDTO
{
	/** @var AbstractEntitySpecificationAwareRepository */
	private $abstractEntitySpecificationAwareRepository;

	/** @var FilterContextInterface */
	private $filterContext;

	public function __construct(AbstractEntitySpecificationAwareRepository $abstractEntitySpecificationAwareRepository, FilterContextInterface $filterContext = null)
	{
		$this->abstractEntitySpecificationAwareRepository = $abstractEntitySpecificationAwareRepository;
		$this->filterContext                              = $filterContext;
	}

	public function getAbstractEntitySpecificationAwareRepository(): AbstractEntitySpecificationAwareRepository
	{
		return $this->abstractEntitySpecificationAwareRepository;
	}

	/** @return FilterContextInterface|null */
	public function getFilterContext()
	{
		return $this->filterContext;
	}
}
