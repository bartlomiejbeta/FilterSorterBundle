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


use BartB\FilterSorterBundle\Data\Sorter\Sort;
use BartB\FilterSorterBundle\Data\Sorter\SortDirectionType;
use BartB\FilterSorterBundle\ParamConverter\SortParamConverter;
use BartB\FilterSorterBundle\Tests\ParamConverter\Fixtures\DummySortEnum;
use BartB\FilterSorterBundle\Tests\ParamConverter\Fixtures\DummySortEnumWithoutSortableInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class SortParamConverterTest extends \PHPUnit_Framework_TestCase
{
	const ATTRIBUTE_NAME_SORT = 'sort';

	/**
	 * @dataProvider dataProviderTestConverterWithBasicOptions
	 */
	public function testConverterWithBasicOptions(string $sort, array $values, string $expectedSortField)
	{
		$request = new Request();

		$request->query->set($sort, $values);

		$sfParamConverter   = new ParamConverter(['name' => '' . self::ATTRIBUTE_NAME_SORT . '', 'options' => ['enum' => DummySortEnum::class], 'class' => Sort::class]);
		$sortParamConverter = new SortParamConverter();

		$sortParamConverter->apply($request, $sfParamConverter);

		self::assertTrue($request->attributes->has(self::ATTRIBUTE_NAME_SORT));

		/** @var Sort $convertedParam */
		$convertedDummySort = $request->attributes->get(self::ATTRIBUTE_NAME_SORT);

		self::assertInstanceOf(Sort::class, $convertedDummySort);

		$sortDirection     = $convertedDummySort->getSortDirection();
		$sortableEnum      = $convertedDummySort->getSortableEnum();
		$expectedDirection = current($values);

		self::assertSame($expectedSortField, $sortableEnum->getValue());
		self::assertSame($expectedDirection, $sortDirection->getValue());
	}

	public function dataProviderTestConverterWithBasicOptions(): array
	{
		return [
			['sort', ['first_sort_field' => SortDirectionType::ASC], DummySortEnum::FIRST_SORT_FIELD],
			['sort', ['first_sort_field' => SortDirectionType::DESC], DummySortEnum::FIRST_SORT_FIELD],
			['sort', ['second_sort_field' => SortDirectionType::ASC], DummySortEnum::SECOND_SORT_FIELD],
			['sort', ['second_sort_field' => SortDirectionType::DESC], DummySortEnum::SECOND_SORT_FIELD],
		];
	}

	/**
	 * @expectedException \RuntimeException
	 * @expectedExceptionMessageRegExp /^Sort Enum should implement interface/
	 * @dataProvider dataProviderTestConverterWithBasicOptions
	 */
	public function testConverterWithDummySortEnumWithoutSortableInterface(string $sort, array $values, string $expectedSortField)
	{
		$request = new Request();

		$request->query->set($sort, $values);

		$sfParamConverter   = new ParamConverter(['name' => '' . self::ATTRIBUTE_NAME_SORT . '', 'options' => ['enum' => DummySortEnumWithoutSortableInterface::class], 'class' => Sort::class]);
		$sortParamConverter = new SortParamConverter();

		$sortParamConverter->apply($request, $sfParamConverter);
	}

	/**
	 * @expectedException \RuntimeException
	 * @expectedExceptionMessageRegExp /^Please set option `enum` with Sort Enum/
	 * @dataProvider dataProviderTestConverterWithBasicOptions
	 */
	public function testConverterWithDummySortEnumWithoutEnumOption(string $sort, array $values, string $expectedSortField)
	{
		$request = new Request();

		$request->query->set($sort, $values);

		$sfParamConverter   = new ParamConverter(['name' => '' . self::ATTRIBUTE_NAME_SORT . '', 'class' => Sort::class]);
		$sortParamConverter = new SortParamConverter();

		$sortParamConverter->apply($request, $sfParamConverter);
	}

	/**
	 * @expectedException \RuntimeException
	 * @expectedExceptionMessageRegExp /^Unexpected sort value/
	 * @dataProvider dataProviderTestConverterWithDummySortEnumWithNonExistingFieldOrDirection
	 */
	public function testConverterWithDummySortEnumWithNonExistingFieldOrDirection(string $sort, array $values)
	{
		$request = new Request();

		$request->query->set($sort, $values);

		$sfParamConverter   = new ParamConverter(['name' => '' . self::ATTRIBUTE_NAME_SORT . '', 'options' => ['enum' => DummySortEnum::class], 'class' => Sort::class]);
		$sortParamConverter = new SortParamConverter();

		$sortParamConverter->apply($request, $sfParamConverter);
	}

	public function dataProviderTestConverterWithDummySortEnumWithNonExistingFieldOrDirection(): array
	{
		return [
			['sort', ['non_existing_first_sort_field' => SortDirectionType::ASC]],
			['sort', ['non_existing_second_sort_field' => SortDirectionType::ASC]],
			['sort', ['non_existing_second_sort_field' => SortDirectionType::DESC]],
			['sort', ['second_sort_field' => 'no_direction']],
			['sort', ['first_sort_field' => 'no_direction']],

		];
	}
}