<?php
/**
 * Created by PhpStorm.
 * User: bartb
 * Date: 31.08.2017
 * Time: 16:01
 */

//@formatter:off
declare(strict_types=1);
//@formatter:on

namespace BartB\FilterSorterBundle\Tests\ParamConverter;


use BartB\FilterSorterBundle\ParamConverter\FiltersParamConverter;
use BartB\FilterSorterBundle\Tests\ParamConverter\Fixtures\DummyFilter;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;

class FiltersParamConverterTest extends \PHPUnit_Framework_TestCase
{
	const ATTRIBUTE_NAME_FILTER = 'filter';

	/** @var Serializer|null */
	private $serializer;

	public function initSerializer()
	{
		$builder          = SerializerBuilder::create();
		$this->serializer = $builder->build();
	}

	/**
	 * @dataProvider dataProviderTestConverterWithBasicOptions
	 */
	public function testConverterWithBasicOptions(string $filter, array $values)
	{
		$this->initSerializer();
		$request = new Request();

		$request->query->set($filter, $values);

		$sfParamConverter      = new ParamConverter(['name' => '' . self::ATTRIBUTE_NAME_FILTER . '', 'class' => DummyFilter::class]);
		$filtersParamConverter = new FiltersParamConverter($this->serializer);

		$filtersParamConverter->apply($request, $sfParamConverter);

		self::assertTrue($request->attributes->has(self::ATTRIBUTE_NAME_FILTER));

		/** @var DummyFilter $convertedParam */
		$convertedDummyFilter = $request->attributes->get(self::ATTRIBUTE_NAME_FILTER);

		self::assertInstanceOf(DummyFilter::class, $convertedDummyFilter);

		foreach ($values as $attrName => $value)
		{
			$attrName           = sprintf('get%s', Container::camelize($attrName));
			$attrValueFromDummy = $convertedDummyFilter->$attrName();

			self::assertSame($value, $attrValueFromDummy);
		}
	}

	public function dataProviderTestConverterWithBasicOptions(): array
	{
		return [
			['filters', ['str_attribute' => 'foo']],
			['filters', ['int_attribute' => 1995]],
			['filters', ['bool_attribute' => true]],
			['filters', ['bool_attribute' => false]],
			['filters', ['str_array_attribute' => ['foo', 'bar', 'baz']]],
			['filters', ['int_array_attribute' => [1995, 1998, 2000]]],
			['filters', ['str_attribute' => 'jkasdjf', 'int_attribute' => 1970, 'bool_attribute' => false, 'int_array_attribute' => [1995, 1998, 2000], 'str_array_attribute' => ['foo', 'bar', 'baz']],]
		];
	}

	/**
	 * @dataProvider dataProviderTestEmptyAttributes
	 */
	public function testEmptyAttributes(string $filter, array $values, array $objectAttributes)
	{
		$this->initSerializer();
		$request = new Request();

		$request->query->set($filter, $values);

		$sfParamConverter   = new ParamConverter(['name' => '' . self::ATTRIBUTE_NAME_FILTER . '', 'class' => DummyFilter::class]);
		$enumParamConverter = new FiltersParamConverter($this->serializer);

		$enumParamConverter->apply($request, $sfParamConverter);

		self::assertTrue($request->attributes->has(self::ATTRIBUTE_NAME_FILTER));

		/** @var DummyFilter $convertedParam */
		$convertedDummyFilter = $request->attributes->get(self::ATTRIBUTE_NAME_FILTER);

		self::assertInstanceOf(DummyFilter::class, $convertedDummyFilter);

		foreach ($objectAttributes as $attribute)
		{
			self::assertAttributeEmpty($attribute, $convertedDummyFilter);
		}
	}

	public function dataProviderTestEmptyAttributes(): array
	{
		return [
			['filters', ['aaa_str_attribute' => 'foo'], ['strAttribute', 'intAttribute', 'boolAttribute', 'strArrayAttribute', 'intArrayAttribute']],
		];
	}
}