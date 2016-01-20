<a href='Hidden comment: revision: 1'></a>

### General information ###

[ORM](http://en.wikipedia.org/wiki/Object-relational_mapping) - allows you to work with the database as if you are working with objects of language php. You do not have to write SQL queries to obtain or save data. Instead, you must call the methods for obtaining data.

ORM will help you to accelerate the application development and simplify the process of further changes in the application.

### How work ORM ###

Create a class for the desired table `blog_category` _(stores category posts)_. To do this we create a file "/var/www/myblog/app/Model/Table/**Blog/Category.php**" with class definition:
```
<?php
class Model_Table_Blog_Category extends Days_Db_Table {
    protected $_name = 'blog_category';
}
```

Get the necessary table object. This is done as follows:
```
$tableBlogCategory = Days_Model::factory('table_blog_category');
```

Obtain data from a table:
```
// obtain information about a category
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

### Using [Days\_Db\_Table](http://code.google.com/p/phpdays/source/browse/trunk/lib/Days/Db/Table.php) ###

Is a representation of a real table, and allows you to perform operations on this table.

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

### Using [Days\_Db\_Rowset](http://code.google.com/p/phpdays/source/browse/trunk/lib/Days/Db/Rowset.php) ###

Represents a set of rows `Days_Db_Row`. Allows you to change the set of rows.

  * `create(array $data=array())` - create new row `Days_Db_Row`
  * `save(Days_Db_Row $row)` - save specified row
  * `delete(Days_Db_Row $row)` - delete specified row
  * `count()` - number of rows in a given set
  * `toArray()` - returns a set of rows as an array

Also provides data from the current row, as if we are working with this row.
```
// displays the name of the first category
echo $categories->name;
```

### Using [Days\_Db\_Row](http://code.google.com/p/phpdays/source/browse/trunk/lib/Days/Db/Row.php) ###

Represents a table row and allows you to work with it.

  * `save()` - save the current line
  * `delete()` - delete the current line
  * `toArray()` - returns the current row as an array
  * `parent` - getting all parent elements _(if you have a column id and pid)_
  * `child` - getting all child elements _(if you have a column id and pid)_
  * `table_name` - getting related records from the specified table _(for categories of table `blog_category` object table `blog` need to specify just `category` instead of `blog_category`)_