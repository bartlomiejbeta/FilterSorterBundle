<?php
/**
 * Created by PhpStorm.
 * User: bartb
 * Date: 30.08.2017
 * Time: 18:03
 */

//@formatter:off
declare(strict_types=1);
//@formatter:on

namespace BartB\Data\Sorter;


use MyCLabs\Enum\Enum;

/**
 * @method static SortDirectionType ASC()
 * @method static SortDirectionType DESC()
 */
class SortDirectionType extends Enum
{
	const ASC  = 'asc';
	const DESC = 'desc';
}