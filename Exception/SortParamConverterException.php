<?php
/**
 * Created by PhpStorm.
 * User: bartb
 * Date: 30.08.2017
 * Time: 18:31
 */

//@formatter:off
declare(strict_types=1);
//@formatter:on

namespace BartB\FilterSorterBundle\Exception;


use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SortParamConverterException extends BadRequestHttpException
{
	public static function fromWrongParameter(string $paramName, $paramValue): self
	{
		$msg = sprintf(
			'Unexpected sort value \'%s\' (%s) or field \'%s\'',
			$paramValue,
			is_object($paramValue) ? get_class($paramValue) : gettype($paramValue),
			$paramName
		);

		return new static($msg);
	}

	public static function fromTooManyParameters(int $paramsCount): self
	{
		$msg = sprintf('Currently, only one sort parameter is allowed, %d passed', $paramsCount);

		return new static($msg);
	}

	public static function fromNotSetOption(string $optionName, string $desc): self
	{
		$msg = sprintf('Please set option `%s` %s', $optionName, $desc);

		return new static($msg);
	}

	public static function fromNotImplementedInterface(string $interfaceName): self
	{
		$msg = sprintf('Sort Enum should implement interface `%s`', $interfaceName);

		return new static($msg);
	}
}