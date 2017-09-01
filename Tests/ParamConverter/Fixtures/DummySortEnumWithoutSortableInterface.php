<?php
/**
 * Created by PhpStorm.
 * User: bartb
 * Date: 01.09.2017
 * Time: 10:54
 */

//@formatter:off
declare(strict_types=1);
//@formatter:on

namespace BartB\FilterSorterBundle\Tests\ParamConverter\Fixtures;


use BartB\FilterSorterBundle\Data\Sorter\SortableEnum;
use MyCLabs\Enum\Enum;


class DummySortEnumWithoutSortableInterface extends Enum
{
	const FIRST_SORT_FIELD  = 'firstSortField';
	const SECOND_SORT_FIELD = 'secondSortField';
}