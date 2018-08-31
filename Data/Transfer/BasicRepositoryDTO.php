<?php
/**
 * Created by PhpStorm.
 * User: bartb
 * Date: 8/31/18
 * Time: 10:32
 */

declare(strict_types=1);

namespace BartB\FilterSorterBundle\Data\Transfer;


use BartB\FilterSorterBundle\Data\Filter\Context\DefaultFilterContext;
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
		$this->filterContext                              = $filterContext ?? new DefaultFilterContext();
	}

	public function getAbstractEntitySpecificationAwareRepository(): AbstractEntitySpecificationAwareRepository
	{
		return $this->abstractEntitySpecificationAwareRepository;
	}

	public function getFilterContext(): FilterContextInterface
	{
		return $this->filterContext;
	}
}
