# FilterSorterBundle

This Symfony bundle aims to provide structurized filtering and sorting with usage of the specification pattern (see [doctrine-specification](https://github.com/Happyr/Doctrine-Specification)). It was design to use in the api applications but it could be also used with standard web apps.

#####  Provides feature like:
- `FilterQueryManager` - it collects all `filter services` and gives you queryBuilder with applied specifications.
- `FilterParamConverter` - provide `filter object` by the data in query string
- `SortParamConverter` - provide `sort object` by the data in query string

[![Build Status](https://travis-ci.org/bartlomiejbeta/FilterSorterBundle.png?branch=master)](https://travis-ci.org/bartlomiejbeta/FilterSorterBundle)

### Installation

##### 1. Install via composer:
```
composer require bartlomiejbeta/filter-sorter-bundle
```


##### 2. Register bundle in `AppKernel`:

```php
public function registerBundles()
{
    $bundles = array(
        // ...
        new BartB\FilterSorterBundle\FilterSorterBundle(),
    );
}
```

### Usage
I assume that you already have entities, and so one. 

##### 1. Change parent of the entities to `AbstractEntitySpecificationAwareRepository`:
example:
```PHP
class CarRepository extends AbstractEntitySpecificationAwareRepository
{
}
```
##### 2. Add specifications ([example](https://github.com/bartlomiejbeta/FilterSorterBundleExample/tree/master/src/AppBundle/Repository/Specification))

##### 3. Add Collection filter ([example](https://github.com/bartlomiejbeta/FilterSorterBundleExample/blob/master/src/AppBundle/Data/Filter/CarCollectionFilter.php))

##### 4. Add Sort Enum ([example](https://github.com/bartlomiejbeta/FilterSorterBundleExample/blob/master/src/AppBundle/Data/Sort/CarSort.php))

##### 5. Build and register your first service adapter ([adapter example](https://github.com/bartlomiejbeta/FilterSorterBundleExample/blob/master/src/AppBundle/Service/Filter/Adapter/FilterCarAdapter.php), [register adapter example](https://github.com/bartlomiejbeta/FilterSorterBundleExample/blob/master/src/AppBundle/Resources/config/services.yml))

##### 5. Run ([standard](https://github.com/bartlomiejbeta/FilterSorterBundleExample/blob/master/src/AppBundle/Controller/DefaultController.php), [api with paramConverters](https://github.com/bartlomiejbeta/FilterSorterBundleExample/blob/master/src/AppBundle/Controller/GetCarController.php))
```PHP
$carCollectionFilter = (new CarCollectionFilter())->setGearboxType('automatic');

$carSorter     = new CarSort(CarSort::FUEL_TYPE);
$sortDirection = new SortDirectionType(SortDirectionType::DESC);
		
/** @var FilterQueryManager $filterQueryManager */
$filterQueryManager = $this->filterQueryManager;
$carRepository      = $this->repostioryCar;
		
$queryBuilder = $filterQueryManager->getQueryBuilder($carRepository, $carCollectionFilter, new Sort($sortDirection, $carSorter));
$query        = $queryBuilder->getQuery();
$result       = $query->execute();
```
[Also I prepared full stand alone example](https://github.com/bartlomiejbeta/FilterSorterBundleExample)
