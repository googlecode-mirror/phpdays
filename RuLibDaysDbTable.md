### Общие сведения ###

[ORM](http://ru.wikipedia.org/wiki/ORM) - позволяет работать с базой данных так, как будто Вы работаете с объектами языка php. Вам не приходится писать SQL запросов для получения или сохранения данных. Вместо этого нужно вызывать методы для получения данных.

Применение ORM поможет Вам ускорить процесс разработки приложения и упростит процесс дальнейшего изменения приложения.

### Как работает ORM ###

Создаем класс для нужной нам таблицы `blog_category` _(хранит категории постов)_. Для этого мы создаем файл "/var/www/myblog/app/Model/Table/**Blog/Category.php**" с определением класса:
```
<?php
class Myblog_Model_Table_Blog_Category extends Days_Db_Table {
    protected $_name = 'blog_category';
}
```

Получаем объект нужной нам таблицы. Это делается так:
```
$tableBlogCategory = Days_Model::factory('table_blog_category');
```

Получаем данные из таблицы:
```
// получаем информацию об одной категории
$category = $tableBlogCategory->find('one', array('where'=>array('id'=>10)));
```

```
// получаем все категории
$categories = $tableBlogCategory->find('all');
```

```
// получаем 20 подкатегорий
$subcategories = $tableBlogCategory->find('all', array(
  // возвратить подкатегории для категории с id=10
  'where' => array(
    'pid' = 10
  ),
  // возвращает первые 20 строк
  'count' => 20
));
```

```
// получаем количество подкатегорий
$countCategories = $tableBlogCategory->find('count', array(
  // возвратить подкатегории для категории с id=10
  'where' => array(
    'pid' = 10
  )
));
```

```
// получаем первые 15 категорий
$firstCaterories = $tableBlogCategory->find('first', array(
  'count' => 15
));
```

```
// удаляем категорию
$category->delete();
```

```
// удаляем все категории, входящие в набор
$firstCaterories->delete();
```

```
// создаем новую строку
$newRow = $subcategories->create();
$newRow->name = 'New subcategory';
// сохраняем запись
$newRow->save();
```

### Работа с Days\_Db\_Table ###

Первым делом - опишите структуру всех таблиц базы данных в файле `/var/www/myblog/app/config/database.yaml`. У Вас получится что-то похожее на:

```
# site database structure
catalog:
  columns:
    _catalog_id: {type: int, attr: unsigned}
    _catalog_category_id: {type: int, attr: unsigned}
    url_name: {type: varchar, len: 100}
    date_create: {type: date}
    date_change: {type: date}
    name: {type: varchar, len: 50}
    title: {type: varchar, len: 255}
    description: {type: text}
    cost: {type: float, attr: unsigned}
catalog_property:
  columns:
    _catalog_property_id: {type: int, attr: unsigned}
    _catalog_id: {type: int, attr: unsigned}
    sex: {type: enum, attr: "m,w"}
    material: {type: varchar, len: 70}
    color: {type: varchar, len: 70}
catalog_category:
  columns:
    _catalog_category_id: {type: int, attr: unsigned}
    _catalog_category_pid: {type: int, attr: unsigned}
    url_name: {type: varchar, len: 100}
    name: {type: varchar, len: 50}
    title: {type: varchar, len: 255}
    description: {type: text}
catalog_image:
  columns:
    _catalog_image_id: {type: int, attr: unsigned}
    _catalog_id: {type: int, attr: unsigned}
    src: {type: varchar, len: 100}
    name: {type: varchar, len: 100}
    title: {type: varchar, len: 255}
```

Days\_Db\_Table является представлением реальной таблицы, и позволяет выполнять операции над этой таблицей.

  * `find($type, $cond)` - получить результат в указанном виде
    * `$type` - в каком виде возвратить результат
      * `all`: все строки
      * `first`: все строки с сортировкой по дате _(свежие записи будут первыми)_
      * `last`: все строки с сортировкой по дате _(свежие записи будут последними)_
      * `one`: одна строка
      * `count`: общее количество строк _(сами строки не возвращаются)_
    * `$cond` - условия, налагаемые на результат
      * `count` _(int)_: количество строк в результате выборки
      * `page` _(int)_: текущий номер страницы (start from 1)
      * `columns` -(array)_: имена колонок
      * `where`_(array)_: пары `column=>$value` или `column_with_value`
      * `group`_(array)_: группировка по колонкам
      * `order`_(array)_: сортировка по колонкам
  * `create()` - создает новый пустой Rowset
  * `save(Days_Db_Row $row)` - сохраняет данные указанного ряда
  * `delete(Days_Db_Row $row)` - удаляет данные указанного ряда
  * `join($table)` - присоединить указанную таблицы к результату_

### Работа с Days\_Db\_Rowset ###

Представляет набор строк `Days_Db_Row`. Позволяет изменять набор строк.

  * `create(array $data=array())` - создать новую строку `Days_Db_Row`
  * `save(Days_Db_Row $row)` - сохранить указанную строку
  * `delete(Days_Db_Row $row)` - удалить указанную строку
  * `count()` - количество строк в данном наборе
  * `toArray()` - возвращает набор строк в виде массива

Так же позволяет получать данные из текущего ряда, как-будто бы мы работаем с этим рядом.
```
// выводит имя первой категории
echo $categories->name;
```

### Работа с Days\_Db\_Row ###

Представляет строку таблицы и позволяет работать с ней.

  * `save()` - сохраняет текущую строку
  * `delete()` - удаляет текущую строку
  * `toArray()` - возвращает текущую строку в виде массива
  * `parent` - получение всех родительских элементов _(если есть столбец id и pid)_
  * `child` - получение всех дочерних элементов _(если есть столбец id и pid)_
  * `имя_таблицы` - получение связанных записей из указанной таблицы _(для получения категорий из таблицы `blog_category` для объекта таблицы `blog` нужно указать просто `category` вместо `blog_category`)_