<a href='Hidden comment: revision: 1'></a>

**[Days\_Config](http://code.google.com/p/phpdays/source/browse/trunk/lib/Days/Config.php)** - work with the configuration of the site.

### How to use ###

Example of use in php code:
```
// load default configutation (default.yaml) and return all sections
$config = Days_Config::load()->get();
// return database configuration
$config = Days_Config::load()->get('db/default');
// load specified configutation file and return specified option
$config = Days_Config::load('myconfig')->get('engine/brand');
// return specified value if option not exists
$config = Days_Config::load()->get('engine/brand', 'app');
```

### Parameters ###

Available configuration parameters:
  * **db** - database configuration
    * **default** - name of section _(for use many databases in one project)_
      * **adapter** - database engine _(available: mysql, mssql, pgsql, sqlite)_
      * **host** - database host _(typically this "localhost")_
      * **username** - user for work with database _(typycally "root")_
      * **password** - sasswork for user
      * **dbname** - databse name in this engine _(for example "phpdays")_
  * **engine** - engine settings
    * **debug** - collect debug info _(1 - enabled, 0 - disabled)_
    * **brand** - name of you application name _(prefix for model classes)_
  * **log** - logging settings
    * **type** - show debug info to: firephp, file, sqlite
    * **level** - show errors only with specified levels _(levels joided by "bytes or")_. Value 31 - show all errors, and 0 - no show errors
  * **url** - settings for url adress
    * **lang** - default page language _(en, ru, fr, ...)_
    * **ext** - default page type _(html, wml, xml)_
    * **base** - delete this part of path from start of string
    * **virtual** - call index action if specified action not exists _(1 - enabled, 0 - disabled)_
  * **view** - settings for view
    * **engine** - use template engine _(available: smarty, dwoo, templum, php - for native php templates)_
  * **cache** - settings for cache support
    * **lifetime** - cache data on this time _(in seconds)_

Configuration file writen on [YAML syntax](http://en.wikipedia.org/wiki/YAML) 