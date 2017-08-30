<?php
/**
 * Created by PhpStorm.
 * User: bartb
 * Date: 30.08.2017
 * Time: 18:28
 */

//@formatter:off
declare(strict_types=1);
//@formatter:on

namespace BartB\ParamConverter;


use BartB\Data\Sorter\Sort;
use BartB\Data\Sorter\SortableEnum;
use BartB\Data\Sorter\SortDirectionType;
use BartB\Exception\SortParamConverterException;
use Docplanner\ApiBundle\Data\Enum\Sort\Sortable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;

class SortParamConverter implements ParamConverterInterface
{
	const SORT_ENUM_OPTION      = 'enum';
	const QUERY_SORT_KEY_OPTION = 'querySortKey';

	private $querySortKey = 'sort';

	public function apply(Request $request, ParamConverter $configuration)
	{
		$query = $request->query;

		if (empty($query->all()))
		{
			return true;
		}

		$this->handleConfiguration($configuration);

		if (false === $query->has($this->querySortKey))
		{
			return true;
		}

		try
		{
			$enumClass   = $this->getEnumClass($configuration);
			$sortValue   = (array) $query->get($this->querySortKey);
			$direction   = current($sortValue);
			$field       = key($sortValue);
			$paramsCount = count($sortValue);

			if (1 < $paramsCount)
			{
				throw SortParamConverterException::fromTooManyParameters($paramsCount);

			}

			$sortEnum          = new SortDirectionType($direction);
			$camelizedItemName = $this->getCamelizedSortItemName($field);
			$sortItem          = new $enumClass($camelizedItemName);
		}
		catch (\UnexpectedValueException $exception)
		{
			throw SortParamConverterException::fromWrongParameter($field, $direction);
		}

		$sortType = new Sort($sortEnum, $sortItem);
		$request->attributes->set($configuration->getName(), $sortType);

		return true;
	}

	public function supports(ParamConverter $configuration)
	{
		$class = $configuration->getClass();

		return $class === Sort::class;
	}

	private function getCamelizedSortItemName(string $sortValue): string
	{
		$camelizedItemName = lcfirst(Container::camelize($sortValue));

		return $camelizedItemName;
	}

	private function getEnumClass(ParamConverter $configuration): string
	{
		$options = $configuration->getOptions();

		if (false === array_key_exists(self::SORT_ENUM_OPTION, $options))
		{
			throw SortParamConverterException::fromNotSetOption(self::SORT_ENUM_OPTION, 'with Sort Enum');
		}

		$enum = $options[self::SORT_ENUM_OPTION];

		if (false === is_subclass_of($enum, SortableEnum::class))
		{
			throw SortParamConverterException::fromNotImplementedInterface(Sortable::class);
		}

		return $enum;
	}

	private function handleConfiguration(ParamConverter $configuration)
	{
		$options = $configuration->getOptions();

		if (false === (array_key_exists(self::QUERY_SORT_KEY_OPTION, $options)))
		{
			return;
		}

		$this->querySortKey = $options[self::QUERY_SORT_KEY_OPTION];
	}
}