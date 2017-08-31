<?php
/**
 * Created by PhpStorm.
 * User: bartb
 * Date: 30.08.2017
 * Time: 18:10
 */

//@formatter:off
declare(strict_types=1);
//@formatter:on

namespace BartB\FilterSorterBundle\Exception;


class FilterQueryManagerException extends \RuntimeException
{
	public static function fromUnsupportedEntityRepository(string $entityName): self
	{
		$message = sprintf('%s entity repository is not supported', $entityName);

		return new static($message);
	}
}