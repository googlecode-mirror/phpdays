### Downloaden ###

Gehen Sie zur [Downloadseite](http://code.google.com/p/phpdays/downloads/list) und wählen die aktuelle stabile Version aus _(Alpha, Beta, RC - gehören nicht zu den stabilen Versionen)_

### Überprüfen der Systemanforderungen ###

Auf Ihrem Server _(lokalem oder echtem)_ sollte installiert sein:
  * **Apache** Server
  * **PHP** Version 5.2.6 oder höher mit den Modulen: PHP5-mysql, PHP5-sqlite, pdo, pdo-mysql, pdo-sqlite _(außerdem empfohlen: PHP5-syck, PHP5-curl, PHP5-xdebug, PHP-apc, PHP5-memcache)_
  * **Datenbankserver** _(dies kann MySQL, MSSQL, Postgres, Oracle oder SQLite sein)_

### Installation des Frameworks ###

  * Enzippen Sie das Archiv
  * Laden Sie das Verzeichnis `lib` auf Ihren Server hoch _(wir empfehlen das Verzeichnis nicht in den Ordner `document_root` hochzuladen, z.B. `/var/lib`)_
  * Konfigurieren Sie den Apache Server zur Benutzung als `document_root` `/var/www` _(in Linux)_ oder `D:/server/www` _(in Windows)_

### Erstellen einer neuen Anwendung ###

  * Stellen Sie die Option `AllowOverride All` in der Apache Konfiguration ein
  * _FÜR LINUX SERVER_ führen Sie den Befehl `sudo a2enmod rewrite && sudo /etc/init.d/apache2 restart` aus _(zum Aktivieren des Apache mod\_rewrite)_
  * Gehen Sie zum `apps` Verzeichnis
  * Kopieren Sie dann das `new` Verzeichnis in das Verzeichnis `document_root` _(zu `/var/www`)_
  * Benennen Sie das `new` Verzeichnis in den Projektnamen um _(z.B. `myblog`)_
  * _FÜR LOKALE SERVER_ erstellen Sie eine `.htaccess` Datei in `/var/www` mit dem Inhalt
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
  * _FÜR LOKALE SERVER_ erstellen Sie eine `index.php` Datei in `/var/www` mit dem Inhalt
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
  * Öffnen Sie `/var/www/myblog/public/index.php` und ändern Sie den Pfad zum phpDays Framework und Ihrem Anwendungs-Verzeichnis
```
require_once '/var/lib/Days/Engine.php';
Days_Engine::run('/var/www/myblog/app/', 'development');
```
  * _FÜR LINUX SERVER_ Ändern Sie die Berechtigungen zum Schreiben für die Ordner: `/var/www/myblog/app/system/cache`, `/var/www/myblog/app/system/log` und `/var/www/myblog/app/system/view` _(Öfnnen Sie das Terminal und führen den Befehl `chmod 0777 path1 path2 path3` aus)_
  * Öffnen Sie `/var/www/myblog/app/config/development.yaml` und ändern die folgenden Zeilen:
    * `db`: Korrigieren Sie die Datenbank-Verbindungs-Einstellungen
    * `engine/brand`: Name Ihrer Anwendung `Myblog` _(den ersten Buchstaben großschreiben)_
    * `url/base`: Pfadpräfix nach dem Hostname `myblog`
    * `view/engine`: Template Engine. Wir empfehlen `smarty` oder `templum` zu benutzen
  * Ersetzen Sie das Präfix `App` mit `Myblog` in den Klassen im Verzeichnis `/var/www/myblog/app/Controller`

Speichern Sie dann die Dateien und öffnen Ihre Anwendung mit der URL http://localhost/myblog.

### Problemlösungen ###

Wenn die Startseite nicht angezeigt wird, öfnen Sie bitte den [Firefox](http://mozilla-europe.org/firefox) Browser, installieren [FireBug](http://getfirebug.com/) und die [FirePHP](http://www.firephp.org/) Erweiterungen. Danach drücken Sie F12, um FireBug zu öffnen und [Ihre Seite](http://localhost/myblog). Im Tab "Console" sehen Sie die Fehlermeldungen.

### mehrere Projekte nutzen ###

Eine Kopie des Frameworks wird für viele Projekte genutzt. Wir sehen alle vorhandenen Projekte mithilfe der Adresse http://localhost.