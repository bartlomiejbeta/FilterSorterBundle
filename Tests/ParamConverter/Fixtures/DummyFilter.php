<?php
/**
 * Created by PhpStorm.
 * User: bartb
 * Date: 31.08.2017
 * Time: 15:53
 */

//@formatter:off
declare(strict_types=1);
//@formatter:on

namespace BartB\FilterSorterBundle\Tests\ParamConverter\Fixtures;

use JMS\Serializer\Annotation as Serializer;
use BartB\FilterSorterBundle\Data\Filter\FilterInterface;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class DummyFilter implements FilterInterface
{
	/**
	 * @var string
	 *
	 * @Serializer\Type("string")
	 * @Serializer\Accessor(getter="getStrAttribute", setter="setStrAttribute")
	 * @Serializer\Expose()
	 */
	private $strAttribute;

	/**
	 * @var bool
	 *
	 * @Serializer\Type("boolean")
	 * @Serializer\Accessor(getter="getBoolAttribute", setter="setBoolAttribute")
	 * @Serializer\Expose()
	 */
	private $boolAttribute;

	/**
	 * @var int
	 *
	 * @Serializer\Type("integer")
	 * @Serializer\Accessor(getter="getIntAttribute", setter="setIntAttribute")
	 * @Serializer\Expose()
	 */
	private $intAttribute;

	/**
	 * @var array|int[]
	 *
	 * @Serializer\Type("array<integer>")
	 * @Serializer\Accessor(getter="getIntArrayAttribute", setter="setIntArrayAttribute")
	 * @Serializer\Expose()
	 */
	private $intArrayAttribute;

	/**
	 * @var array|string[]
	 *
	 * @Serializer\Type("array<string>")
	 * @Serializer\Accessor(getter="getStrArrayAttribute", setter="setStrArrayAttribute")
	 * @Serializer\Expose()
	 */
	private $strArrayAttribute;

	public function getStrAttribute()
	{
		return $this->strAttribute;
	}

	public function setStrAttribute($strAttribute)
	{
		$this->strAttribute = $strAttribute;

		return $this;
	}

	public function getBoolAttribute()
	{
		return $this->boolAttribute;
	}

	public function setBoolAttribute($boolAttribute)
	{
		$this->boolAttribute = $boolAttribute;

		return $this;
	}

	public function getIntAttribute()
	{
		return $this->intAttribute;
	}

	public function setIntAttribute($intAttribute)
	{
		$this->intAttribute = $intAttribute;

		return $this;
	}

	public function getIntArrayAttribute()
	{
		return $this->intArrayAttribute;
	}

	public function setIntArrayAttribute($intArrayAttribute)
	{
		$this->intArrayAttribute = $intArrayAttribute;

		return $this;
	}

	public function getStrArrayAttribute()
	{
		return $this->strArrayAttribute;
	}

	public function setStrArrayAttribute($strArrayAttribute)
	{
		$this->strArrayAttribute = $strArrayAttribute;

		return $this;
	}
}