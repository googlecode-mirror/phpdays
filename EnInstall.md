<a href='Hidden comment: revision: 1'></a>

### Download ###

Go to the [download page](http://code.google.com/p/phpdays/downloads/list) and select the latest stable version _(alpha, beta, RC - are not stable!)_.

**ATTENTION** Use **phpdays 1.1 beta** instead of **phpdays 1.0 final** release. In **phpdays 1.0 final** release we found many critical bugs, which were fixed in **phpdays 1.1 beta**.

### Check requirements ###

On your server _(local and real)_ should be installed:
  * **Apache** server
  * **PHP** 5.2.6 or newer with modules: php5-mysql, php5-sqlite, pdo, pdo-mysql, pdo-sqlite _(also recommend: php5-syck, php5-curl, php5-xdebug, php-apc, php5-memcache)_
  * **Database** server _(supported MySQL, MSSQL, Postgres, Oracle, SQLite)_

### Install framework ###

  * unzip the archive
  * upload directory `lib` to your server _(we recommend place directory not in `document_root` directory, for example to `/var/lib`)_
  * configure Apache server for use `/var/www` _(in Linux)_ or `D:/server/www` _(in Windows)_ as `document_root`

### Create new application ###

  * set option `AllowOverride All` in Apache configuration
  * _FOR LINUX SERVER_ execute command `sudo a2enmod rewrite && sudo /etc/init.d/apache2 restart` _(enable Apache mod\_rewrite)_
  * go to `apps` directory
  * copy `new` directory to you `document_root` _(to `/var/www`)_
  * rename `new` directory to real project name _(for example use `myblog`)_
  * _FOR LOCAL SERVER_ create `.htaccess` file in `/var/www` with content
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
  * _FOR LOCAL SERVER_ create `index.php` file in `/var/www` with content
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
  * open `/var/www/myblog/public/index.php` and change path to phpDays framework and you application dir
```
require_once '/var/lib/Days/Engine.php';
Days_Engine::run('/var/www/myblog/app/', 'development');
```
  * _FOR LINUX SERVER_ change directories permission for write to: `/var/www/myblog/app/system/cache`, `/var/www/myblog/app/system/log` and `/var/www/myblog/app/system/view` _(open terminal and type command `chmod 0777 path1 path2 path3`)_
  * open `/var/www/myblog/app/config/development.yaml` and change next lines _([additional info](EnLibDaysConfig.md))_:
    * `db`: correct database connection info
    * `url/base`: path prefix after host name `myblog`
    * `view/engine`: template engine. We recommend use `smarty` or `templum`

Save files and open you application by url http://localhost/myblog.

### Troubleshooting ###

If start page not shown - please open [Firefox](http://mozilla-europe.org/firefox) browser, install [FireBug](http://getfirebug.com/) and [FirePHP](http://www.firephp.org/) extensions. After this press F12 for open [FireBug](http://getfirebug.com/) and open [your site](http://localhost/myblog). On tab "Console" see bug messages.

### Use many projects ###

One copy of framework used for many projects. Now we see all available projects by adress http://localhost.