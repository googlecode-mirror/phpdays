<a href='Hidden comment: revision: 1'></a>

### General information ###

[ORM](http://en.wikipedia.org/wiki/Object-relational_mapping) - U bent in staat om te werken met de database dan werkt u met objecten van de taal PHP. Je hoeft niet om SQL queries te schrijven en/of te verkrijgen voor je gegevens op te slaan. In plaats daarvan moet u bellen met de methoden voor het verkrijgen van gegevens.

ORM zal u helpen om de applicatie-ontwikkeling te versnellen en vereenvoudigen van het proces van verdere veranderingen in de aanvraag.

### Hoe werkt ORM ###

Maak een klasse voor de gewenste tabel `blog_category` _(stores category posts)_. Om dit te creëren maken we een bestand "/ var / www / myblog / app / Model / Tabel / **Blog / category.php doen**" met klasse definitie:
```
<?php
class Model_Table_Blog_Category extends Days_Db_Table {
    protected $_name = 'blog_category';
}
```

Haal de nodige table objecten. Dit is als volgt:
```
$tableBlogCategory = Days_Model::factory('table_blog_category');
```

Gegevens te verkrijgen uit een tabel:
```
// obtain information about a category
$category = $tableBlogCategory->find('one', array('where'=>array('id'=>10)));
```

```
// obtain all categories
$categories = $tableBlogCategory->find('all');
```

```
// obtain 20 subcategories
$subcategories = $tableBlogCategory->find('all', array(
  // return sub-categories with id=10
  'where' => array(
    'pid' = 10
  ),
  // returns the first 20 rows
  'count' => 20
));
```

```
// obtain the total count of subcategories
$countCategories = $tableBlogCategory->find('count', array(
  // return sub-categories with id=10
  'where' => array(
    'pid' = 10
  )
));
```

```
// obtain the first 15 categories
$firstCaterories = $tableBlogCategory->find('first', array(
  'count' => 15
));
```

```
// delete category
$category->delete();
```

```
// remove all the categories included in the set
$firstCaterories->delete();
```

```
// create a new row
$newRow = $subcategories->create();
$newRow->name = 'New subcategory';
// save row
$newRow->save();
```

### Gebruik [Days\_Db\_Table](http://code.google.com/p/phpdays/source/browse/trunk/lib/Days/Db/Table.php) ###

Dit is een echte voorstelling van een echte tabel, en u kunt bewerkingen uitvoeren op deze tabel.

  * `find($type, $cond)` - obtain the result in specified form
    * `$type` - in what form to return the result
      * `all`: all rows
      * `first`: all rows with sorting by date _(свежие записи будут первыми)_
      * `last`: all rows with sorting by date _(свежие записи будут последними)_
      * `one`: one row
      * `count`: total number of rows _(lines themselves are not returned)_
    * `$cond` - conditions imposed on the result
      * `count` _(int)_: count of rows in result set
      * `page` _(int)_: current page number (start from 1)
      * `columns` _(array)_: column names
      * `where` _(array)_: pairs `column=>$value` or `column_with_value`
      * `group` _(array)_: group by columns
      * `order` _(array)_: sorting by columns
  * `create()` - creates a new empty Rowset
  * `save(Days_Db_Row $row)` - save specified row
  * `delete(Days_Db_Row $row)` - delete specified row
  * `join($table)` - attach the specified table to the result

### Gebruik [Days\_Db\_Rowset](http://code.google.com/p/phpdays/source/browse/trunk/lib/Days/Db/Rowset.php) ###

Vertegenwoordigt een reeks rijen `Days_Db_Row`. Hiermee kunt u de set van rijen veranderen.

  * `create(array $data=array())` - create new row `Days_Db_Row`
  * `save(Days_Db_Row $row)` - save specified row
  * `delete(Days_Db_Row $row)` - delete specified row
  * `count()` - number of rows in a given set
  * `toArray()` - returns a set of rows as an array

Ook levert de gegevens van de huidige rij, alsof we werken met deze rij.
```
// displays the name of the first category
echo $categories->name;
```

### Gebruik [Days\_Db\_Row](http://code.google.com/p/phpdays/source/browse/trunk/lib/Days/Db/Row.php) ###

Vertegenwoordigt een tabel/rij en je kan er aan werken.

  * `save()` - save the current line
  * `delete()` - delete the current line
  * `toArray()` - returns the current row as an array
  * `parent` - getting all parent elements _(if you have a column id and pid)_
  * `child` - getting all child elements _(if you have a column id and pid)_
  * `table_name` - getting related records from the specified table _(for categories of table `blog_category` object table `blog` need to specify just `category` instead of `blog_category`)_