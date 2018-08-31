<?php
/**
 * Created by PhpStorm.
 * User: bartb
 * Date: 8/31/18
 * Time: 10:36
 */

declare(strict_types=1);

namespace BartB\FilterSorterBundle\Data\Limiter;


class Limit
{
	/** @var int */
	private $limit;

	public function __construct(int $limit)
	{
		$this->limit = $limit;
	}

	public function getLimit(): int
	{
		return $this->limit;
	}

}
