### Download ###

Visitare la [pagina di download](http://code.google.com/p/phpdays/downloads/list) e selezionare la ultima release _(alpha, beta, RC - non sono stabili!)_

### Requisiti ###

Nel tuo server deve essere installato:
  * **Apache** server
  * **PHP** 5.2.6 o superiore con i moduli: php5-mysql, php5-sqlite, pdo, pdo-mysql, pdo-sqlite _(si consiglia anche: php5-syck, php5-curl, php5-xdebug, php-apc, php5-memcache)_
  * **Database** server _(MySQL, MSSQL, Postgres, Oracle, SQLite)_

### Installazione framework ###

  * decomprimere l'archivio
  * uploaddare la directory `lib` nel tuo server _(si consiglia di non metterla nella `document_root`, per esempio `/var/lib`)_
  * Configurare apache per la directory `/var/www` _(in Linux)_ o `D:/server/www` _(in Windows)_ come `document_root`

### Creare una nuova applicazione ###

  * settare l'opzione `AllowOverride All` nel file di configurazione di Apache
  * _PER SERVER LINUX_ eseguire il comando `sudo a2enmod rewrite && sudo /etc/init.d/apache2 restart` _(abilita il mod\_rewrite di Apache)_
  * aprire alla directory `apps`
  * copiare la directory `new` nella `document_root` _(in `/var/www`)_
  * rinominare la directory `new` nel nome del progetto _(per esempio: `myblog`)_
  * _PER SERVER LOCALI_ creare un file `.htaccess` in `/var/www` con il seguente codice:
```
# no scan directories
DirectoryIndex index.php
Options -Indexes
# gestisce tutte le query con il main script
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteRule ^index.php$ index.php [L]
  RewriteRule ^/?([^/]+)(.*)$ $1/public/$2 [NC,L]
</IfModule>
```
  * _PER SERVER LOCALI_ creare un file `index.php` in `/var/www` con il seguente codice:
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
  * aprire `/var/www/myblog/public/index.php` e cambiare il path nel seguente modo:
```
require_once '/var/lib/Days/Engine.php';
Days_Engine::run('/var/www/myblog/app/', 'development');
```
  * _PER SERVER LINUX_ cambiare i permessi delle directory: `/var/www/myblog/app/system/cache`, `/var/www/myblog/app/system/log` e `/var/www/myblog/app/system/view` _(aprire il terminale e scrivere `chmod 0777 path1 path2 path3`)_
  * aprire il file `/var/www/myblog/app/config/development.yaml` e cambiare le seguenti linee:
    * `db`: i dati di connessione al Database
    * `engine/brand`: il nome della tua applicazione `Myblog` _(prima lettera maiuscola)_
    * `url/base`: il path prima dell'hostname _(esempio: se la cartella phpdays si trova in c:/www/phpdays scrivere `phpdays/myblog`
    * `view/engine`: Il template engine. Si consiglia l'uso di `smarty` o `templum`_

  * Correggere il prefisso `App` nella classe `Myblog` nella directory `/var/www/myblog/app/Controller`

Salva i tuoi files e apri la tua applicazione dall'url http://localhost/myblog.

### Problemi ###

Se la pagina iniziale non viene visualizzata, installare [FireBug](http://getfirebug.com/) per firefox e [FirePHP](http://www.firephp.org/) per visualizzare gli errori generati. Dopo installato premere F12 per aprire FireBUG e aprire la [Vostra Applicazione](http://localhost/myblog). Nella tab "Console" potrete visualizzare i messaggi di errore.

### Usare più progetti ###

Una copia del framework può essere usata per più progetti.