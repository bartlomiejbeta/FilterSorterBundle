<?php
/**
 * Created by PhpStorm.
 * User: bartb
 * Date: 30.08.2017
 * Time: 18:02
 */

//@formatter:off
declare(strict_types=1);
//@formatter:on

namespace BartB\FilterSorterBundle\Data\Sorter;


class Sort
{
	/** @var SortDirectionType */
	private $sortDirectionType;

	/** @var SortableEnum */
	private $sortableEnum;

	public function __construct(SortDirectionType $sortDirectionType, SortableEnum $sortable)
	{
		$this->sortDirectionType = $sortDirectionType;
		$this->sortableEnum      = $sortable;
	}

	public function getSortDirection(): SortDirectionType
	{
		return $this->sortDirectionType;
	}

	public function getSortableEnum(): SortableEnum
	{
		return $this->sortableEnum;
	}
}