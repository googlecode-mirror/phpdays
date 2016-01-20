Se una sezione diventa complessi o piena di funzioni, è consigliabile spostarla in un'altro progetto separato. Quindi quest'ultimo potrà essere integrato all'interno di un'ulteriore sito, dove potrai creare un sito web con le basi degli altri progetti.


### Creare un sito ###

Supponendo che avessi bisogno di crare un complessa _forum section_ dovrete creare un [progetto](ItInstall.md) separato e implementarlo solo nella sezione del forum. Lo stesso metodo deve essere usato con le altre sezioni del sito _(come blog, cataloghi ecc)_.

Il progetto si troverà nella directory `/var/www/forum`.

Ora preparate il vostro forum per l'inclusione in un'altra sezione del sito.
  * Create un nuovo file di configurazione `/var/www/forum/app/config/myblog_development.yaml`.
  * Editarlo per farlo funzionare con il database della vostra applicazione. Settare l'opzione `url/base: myblog/forum`.

  * Implementare tutte le parti del sito con la stessa procedura, cioè creando un [controller](ItController.md) separato.


### Includere il progetto nella sezione corrente del sito ###

I file e le directory `static` sono nella directory `/var/www/myblog/public`.

Creiamo una directory `/var/www/myblog/public/forum` per la nostra nuova sezione forum.
Copiamo il contenuto di `/var/www/forum/public` dentro la nostra nuova directory.

Editiamo il file `/var/www/myblog/public/forum/index.php`:
  * settare il percorso alle librerie phpDays
  * settare il percorso all'applicazione forum
  * cambiare la configurazione da `development` a `myblog_development`


### Conclusioni ###

Ora quando andrete all'indirizzo http://localhost/myblog/forum, verrete redirectati a `/var/www/myblog/public/forum` e l'applicazione appropriata verrà lanciata con il risultato di avere "un sito dentro un sito".

Se intendi usare una simile sezione forum in un altro progetto, questo metodo ti farà risparmiare tempo.
E tutto quello che dovrai fare sarà includere un progetto all'interno di un'altro.