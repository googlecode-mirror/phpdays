**[Days\_Config](http://code.google.com/p/phpdays/source/browse/trunk/lib/Days/Config.php)** Interagisce con la configurazione del sito.

### Come usare ###

Esempio:
```
// carica la configurazione di default (default.yaml) e ritora tutte le sezioni.
$config = Days_Config::load()->get();
// ritorna la configurazione del database
$config = Days_Config::load()->get('db/default');
// carica uno specifico file di configurazione e ritorna una specifica opzione
$config = Days_Config::load('myconfig')->get('engine/brand');
// ritorna uno specifico valore se l'opzione non esiste.
$config = Days_Config::load()->get('engine/brand', 'app');
```

### Parametri ###

Parametri di configurazione disponibili:

  * **db** - Configurazione database
    * **default** - Il nome della seziona _(per usare più database in 1 progetto)_
    * **adapter** - Il motore del database _(disponibili: mysql, mssql, pgsql, sqlite)_
    * **host** - L'host del database _(di solito "localhost")_
    * **username** - L'username per accedere al db _(di solito "root")_
    * **password** - La password per accedere al db
    * **dbname** - Il nome del database _(per esempio "phpdays")_
  * **engine** - Configurazione motore interno
    * **debug** - Informazioni di debug _(1 - Attivo, 0 - Disattivo)_
    * **brand** - Il nome della tua applicazione _(prefisso per le classi model)_
  * **log** - Logging delle impostazioni
    * **type** - Visualliza i debug come: firephp, file, sqlite
    * **level** - Mostra solo gli errori con uno specifico livello.
  * **url** - Impostazioni per gli URL
    * **lang** - Linguaggio di default della pagina _(en, ru, fr, ecc)_
    * **ext** - Tipo di pagina di default _(html, wml, xml)_
    * **base** - La parte di url che viene eliminata nel motore interno.
    * **virtual** - Chiama l'index action se non è specificata alcuna azione _(1 - Attivo, 0 - Disattivo)_
  * **view** - Impostazioni di visualizzazione
    * **engine** - Usa template engine _(disponibili: smarty, dwoo, templum, php - per template php nativi)_
  * **cache** - Impostazioni per cache
    * **lifetime** - La durata in secondi della cache.


Il file di configurazione è scritto in [YAML](http://en.wikipedia.org/wiki/YAML) 