<?php
/**
 * Created by PhpStorm.
 * User: bartb
 * Date: 30.08.2017
 * Time: 18:17
 */

//@formatter:off
declare(strict_types=1);
//@formatter:on

namespace BartB\FilterSorterBundle\ParamConverter;


use BartB\FilterSorterBundle\Data\Filter\FilterInterface;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class FiltersParamConverter implements ParamConverterInterface
{
	const QUERY_FILTER_KEY_OPTION = 'queryFilterKey';

	/** @var SerializerInterface */
	private $serializer;

	private $queryFilterKey = 'filters';

	public function __construct(SerializerInterface $serializer)
	{
		$this->serializer = $serializer;
	}

	/** @inheritdoc */
	public function apply(Request $request, ParamConverter $configuration)
	{
		$class = $configuration->getClass();
		$query = $request->query;

		if (empty($query->all()))
		{
			return true;
		}

		$this->handleConfiguration($configuration);

		if (false === $query->has($this->queryFilterKey))
		{
			return true;
		}

		$filters             = $this->getFilters($query, $class);
		$deserializedFilters = $this->serializer->fromArray($filters, $class);

		$request->attributes->set($configuration->getName(), $deserializedFilters);

		return true;
	}

	/** @inheritdoc */
	public function supports(ParamConverter $configuration)
	{
		$class = $configuration->getClass();

		return is_subclass_of($class, FilterInterface::class);
	}

	private function getFilters(ParameterBag $query, string $class): array
	{
		$filters = $query->get($this->queryFilterKey);

		$metadataFromSerializer = $this->serializer->getMetadataFactory()->getMetadataForClass($class);

		$boolProperties = [];
		foreach ($metadataFromSerializer->propertyMetadata as $propertyMetadata)
		{
			if (array_key_exists('name', $propertyMetadata->type) && $propertyMetadata->type['name'] === 'boolean')
			{
				$boolProperties[] = $propertyMetadata->name;
			}
		}

		/** @var array $booleanFilters */
		$booleanFilters = $query->getBoolean($this->queryFilterKey);

		foreach ($filters as $filterName => $filterValue)
		{
			if (in_array($filterName, $boolProperties) && is_array($booleanFilters) && array_key_exists($filterName, $booleanFilters))
			{
				$filters[$filterName] = $booleanFilters[$filterName];
			}
		}

		return $filters;
	}

	private function handleConfiguration(ParamConverter $configuration)
	{
		$options = $configuration->getOptions();

		if (false === (array_key_exists(self::QUERY_FILTER_KEY_OPTION, $options)))
		{
			return;
		}

		$this->queryFilterKey = $options[self::QUERY_FILTER_KEY_OPTION];
	}
}