<a href='Hidden comment: revision: 1'></a>

### Downloaden ###

Ga naar [download page](http://code.google.com/p/phpdays/downloads/list) en selecteer de laatste stabiele versie _(alpha, beta, RC - is niet stabiel!)_.

**ATTENTIE** Gebruik **phpdays 1.1 beta** plaats van **phpdays 1.0 final** release. In **phpdays 1.0 final** release vonden we veel kritische bugs, deze werden opgelost in **phpdays 1.1 beta**.

### Check Eisen ###

Op je server _(lokaal en reëel)_ moeten worden geinstalleerd:
  * **Apache** server
  * **PHP** 5.2.6 or newer with modules: php5-mysql, php5-sqlite, pdo, pdo-mysql, pdo-sqlite _(also recommend: php5-syck, php5-curl, php5-xdebug, php-apc, php5-memcache)_
  * **Database** server _(ondersteund MySQL, MSSQL, Postgres, Oracle, SQLite)_

### Installeer framework ###

  * Pak de file uit
  * upload directory `lib` naar je server _(vervang niet de directory plaats in `document_root` directory, bijvoorbeeld voor `/var/lib`)_
  * configureer Apache server voor `/var/www` _(in Linux)_ of `D:/server/www` _(in Windows)_ als `document_root`

### Maak een nieuwe applicatie ###

  * Zet de options `AllowOverride All` aan in Apache configuratie.
  * _Voor LINUX SERVER_ uitvoeren commando `sudo a2enmod rewrite && sudo /etc/init.d/apache2 herstart` _(zet aan Apache mod\_rewrite)_
  * Ga naar `apps` directorie
  * Copy `nieuw` directorie naar jou `document_root` _(to `/var/www`)_
  * Vervang de naam `new` directorie naar de echte naam van het project _(for example use `myblog`)_
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
  * open `/var/www/myblog/public/index.php` en verander het pad naar phpDays framework en naar je applicatie directory.
```
require_once '/var/lib/Days/Engine.php';
Days_Engine::run('/var/www/myblog/app/', 'development');
```
  * _FOR LINUX SERVER_ change directories permission for write to: `/var/www/myblog/app/system/cache`, `/var/www/myblog/app/system/log` and `/var/www/myblog/app/system/view` _(open terminal and type command `chmod 0777 path1 path2 path3`)_
  * open `/var/www/myblog/app/config/development.yaml` and change next lines _([additional info](EnLibDaysConfig.md))_:
    * `db`: correct database connection info
    * `url/base`: path prefix after host name `myblog`
    * `view/engine`: template engine. We recommend use `smarty` or `templum`

Sla alle bestanden op en open het in je applicatie bij deze url http://localhost/myblog.

### Problemen ###

Als de startpagina niet weergegeven wordt - open dan [Firefox](http://mozilla-europe.org/firefox) browser te installeren [FireBug](http://getfirebug.com/) en [FirePHP](http://www.firephp.org/) extensies. Na deze uitgevoerd te hebben druk op F12 voor open [FireBug](http://getfirebug.com/) en open [uw site](http://localhost/myblog). Op het tabblad "Console" see bug berichten.

### Gebruik veel projecten ###

Een exemplaar van een framework wordt gebruikt voor vele projecten. Nu zien we alle beschikbare projecten van adres http://localhost.