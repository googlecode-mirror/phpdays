### Скачайте ###

Перейдите на [страницу загрузки](http://code.google.com/p/phpdays/downloads/list) и выберите последнюю стабильную версию _(alpha, beta, RC - не являются стабильными!)_

**ВНИМАНИЕ** Используйте **phpdays 1.1 beta** вместо **phpdays 1.0 final**. В версии **phpdays 1.0 final** мы нашли множество критических ошибок, которые были исправлены в **phpdays 1.1 beta**.

### Проверьте требования ###

На Вашем сервере _(локальном или реальном)_ должны быть установлены:
  * **Apache** сервер
  * **PHP** 5.2.6 или новее с модулями: php5-mysql, php5-sqlite, pdo, pdo-mysql, pdo-sqlite _(так же рекомендуем: php5-syck, php5-curl, php5-xdebug, php-apc, php5-memcache)_
  * сервер **баз данных** _(поддерживаются MySQL, MSSQL, Postgres, Oracle, SQLite)_

### Установите фреймворк ###

  * распакйте архив
  * загрузите директорию `lib` на Ваш сервер _(мы рекомендуем размещать эту директорию не в `document_root` директории, например в `/var/lib`)_
  * настройте сервер Apache для использования `/var/www` _(в Linux)_ or `D:/server/www` _(в Windows)_ как `document_root`

### Создайте новое приложение ###

  * установите опцию `AllowOverride All` в файле конфигурации Apache
  * _ДЛЯ LINUX СЕРВЕРА_ выполните команду `sudo a2enmod rewrite && sudo /etc/init.d/apache2 restart` _(включить Apache mod\_rewrite)_
  * перейдите в директорию `apps`
  * скопируйте директорию `new` в `document_root` _(в `/var/www`)_
  * переименуйте директорию `new` на действительное название проекта _(для примера будем использовать `myblog`)_
  * _ДЛЯ ЛОКАЛЬНОГО СЕРВЕРА_ создайте файл `.htaccess` в `/var/www` с содержимым
```
# no scan directories
DirectoryIndex index.php
Options -Indexes
# handle all queries within main script
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteRule ^index.php$ index.php [L]
  RewriteRule ^/?([^/]+)(.*)$ $1/public/$2 [NC,L]
</IfModule>
```
  * _ДЛЯ ЛОКАЛЬНОГО СЕРВЕРА_ создайте файл `index.php` в `/var/www` с содержимым
```
<?php
$dirs = scandir('.');
echo '<ul>';
echo '<h2>Projects</h2>';
foreach ($dirs as $dir) {
    // show directories with projects only
    if ('.' != $dir[0] AND is_dir($dir) AND is_dir("{$dir}/public"))
        echo "<li> <a href='/{$dir}'>{$dir}</a>";
}
echo '</ul>';
```
  * откройте файл `/var/www/myblog/public/index.php` и измените путь к фреймворку phpDays и директории Вашего проекта
```
require_once '/var/lib/Days/Engine.php';
Days_Engine::run('/var/www/myblog/app/', 'development');
```
  * _ДЛЯ LINUX СЕРВЕРА_ измените права доступа к директориям для записи: `/var/www/myblog/app/system/cache`, `/var/www/myblog/app/system/log` и `/var/www/myblog/app/system/view` _(откройте консоль и наберите команду `chmod 0777 path1 path2 path3`)_
  * откройте файл `/var/www/myblog/app/config/development.yaml` и измените следующие строки:
    * `db`: измените информацию о соединении с базой данных
    * `url/base`: префикс в url адресе после имени сайта `myblog`
    * `view/engine`: шаблонизатор. Мы рекомендуем применять `smarty` или `templum`

Сохраните файлы и откройте Ваше приложение по адресу http://localhost/myblog.

### Настройка хранилища данных ###

В роли хранилища данных может использоваться сервер практически любых баз данных _(MySQL, PgSQL, MSSQL, SQLite и другие)_. Благодаря phpDays, нам не придется создавать вручную таблицы базы данных - это произойдет автоматически ([подробнее](RuStart.md)).

### Решение проблем ###

Если стартовая страница не отображается - то пожалуйста откройте [Firefox](http://mozilla-europe.org/firefox) брайзер, установите расширения [FireBug](http://getfirebug.com/) и [FirePHP](http://www.firephp.org/). После этого нажмите F12 для открытия окна FireBug и перейдите к [вашему сайту](http://localhost/myblog). На вкладке "консоль" просмотрите список возникших ошибок.

### Используйте несколько проектов ###

Одна копия фреймворка используется с несколькими приложениями. Сейчас Вы можете увидеть список всех доступных проектов по адресу http://localhost.