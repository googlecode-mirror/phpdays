<a href='Hidden comment: revision: 1'></a>

Нам нужно создать все модели, которые могут потребоваться в нашем блоге. Мы можем использовать стандартные _базовые модели_ phpDays, а так же можем их расширить под свои требования. Этим и займемся.

Если Вы еще не прочитали о [моделях](RuLibDaysModel.md) - самое время это сделать. Ниже мы создадим модели для нашего приложения.

### Создаем модели для блога ###

В директории `app/Model` создайте следующие файлы:
  * `Blog.php` - представляет конкретный блог на сайте. Блогов может быть несколько, и у каждого из них - своя тематика
```
<?php
class Model_Blog extends Days_Model {
    protected $_name    = 'type: String, min: 2, max: 100, required';
    protected $_url     = 'type: String, min: 2, max: 100, required';
    protected $_owner   = 'type: User, required';
    protected $_created = 'type: DateTime, now: create, required';
    protected $_changed = 'type: DateTime, now: always, required';
}
```
  * `BlogPost.php` - представляет собой статью в блоге. К статье могут добавляться комментарии
```
<?php
class Model_BlogPost extends Days_Model {
    protected $_name     = 'type: String, min: 2, max: 100, required';
    protected $_url      = 'type: String, min: 2, max: 100, required, unique';
    protected $_title    = 'type: String, max: 255, required';
    protected $_content  = 'type: Text, min: 100, required';
    protected $_blog     = 'type: Blog, required';
    protected $_category = 'type: BlogCategory';
    protected $_tags     = 'type: +BlogTag';
    protected $_author   = 'type: User, required';
    protected $_created  = 'type: DateTime, now: create, required';
    protected $_media    = 'type: +String';
}
```
  * `BlogCategory.php` - категория сообщения _(музыка, новости, разное и т.п.)_
```
<?php
class Model_BlogCategory extends Days_Model {
    protected $_name     = 'type: String, min: 2, max: 50, required';
    protected $_url      = 'type: String, min: 2, max: 50, required';
}
```
  * ```BlogTag.php`` - теги служат для того, чтобы пометить статью
```
<?php
class Model_BlogTag extends Days_Model {
    protected $_name = 'type: String, min: 2, max: 70, required, unique';
    protected $_url  = 'type: String, min: 2, max: 70, required, unique';
}
```
  * `BlogComment` - комментарии к статье. Расширяем стандартную модель комментирования
```
<?php
class Model_BlogComment extends Days_Model_Comment {
    protected $_title   = 'type: String, required';
    protected $_author  = 'type: User, required';
    protected $_post    = 'type: BlogPost, required';
    protected $_created = 'type: DateTime, now: create';
}
```
  * `User.php` - пользователь сайта. Расширяем стандартную модель пользователя
```
<?php
class Model_User extends Days_Model_User {
    protected $_firstname = 'type: String, min: 2, max: 50';
    protected $_lastname  = 'type: String, min: 2, max: 50';
    protected $_birthdate = 'type: DateTime, min: 1950-1-1, required';
}
```

### Что мы создали ###

Выше мы создали классы моделей, которые представляют объекты хранилища данных. Эти данные сохраняются в хранилище, и затем мы можем их оттуда извлечь и возвратить пользователю. Таким образом мы работаем не с хранилищем данных, а с объектами, которые автоматически преобразуются в данные хранилища.

Заметьте что мы не описывали никаких служебных данных, наподобие ключевых полей объектов. Ключевые поля создаются автоматически.

Теперь самое время перейти к созданию [контроллеров приложения](RuStartController.md).