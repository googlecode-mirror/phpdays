Se hai imparato il progetto e hai una certa confidenza con esso e sei interessato nel contribuire al suo sviluppo, leggi le seguenti linee guida.


### Entrare nel team di phpDays ###

  * Lascia un commento alla pagina [Risposte](ItAnswers.md) o invialo qui [Project Support Group](http://groups.google.com/group/phpdays-en).
  * Nel tuo messaggio specifica il ruolo che vuoi intraprendere _(php developer, web designer, traduttore di documentazione, typesetter, Javascript developer)_ e includi il tuo indirizzo gmail _(Il tuo username gmail)_
  * Dopo una rapida valutazione riceverai un email con la nostra decisione _(se non ricevi risposta entro 3 giorni, re-invia la tua richiesta)_
  * Se tutto va bene, diventerai un membro del progetto e potrai avere accesso a particolari funzioni _(potrai cambiare il codice del progetto, la documentazione)_
  * Inoltre verrai aggiunto a [Lista membri del progetto](http://code.google.com/p/phpdays/people/list)


### Informazioni generali sul sito ###

  * [Downloads](http://code.gogogle.com/p/phpdays/downloads/list) - La pagina di download dove troverai le copie funzionanti per gli utenti finali.
  * [Wiki](http://code.google.com/p/phpdays/w/list) - La documentazione del progetto
  * [Problemi](http://code.google.com/p/phpdays/issues/list) - Lista dei vari problemi del progetto e delle varie correzioni.
  * [Source](http://code.google.com/p/phpdays/source/list) - Informazioni sul repository SVN del progetto e il changelog.

### Eseguire l'upload di una copia funzionante del progetto ###
  * scaricare ed installare un client SVN
  * scaricare una copia funzionante del progetto _(per ulteriori informazioni visitare [Checkout](http://code.google.com/p/phpdays/source/checkout))_
  * Se non hai mai lavorato con Subversion prima d'ora, ora potrai imparare.


### Linee guida per applicare dei cambiamenti _(SVN commit)_ ###

Per i commenti seguire il formato seguente


  * `Fix #1234: Il nome del bug` - con il numero di errore `1234`. Se il bug non è presente in [Issues](http://code.google.com/p/phpdays/issues/list), dovrai aggiungerlo e dopo eseguire l'`SVN Commit.
  * scrivere ogni bug/problema in una linea separata. Mettere un punto alla fine della linea.

### Test personale ###

Installare [PHPUnit](http://blogs.sun.com/netbeansphp/entry/recent_improvements_in_phpunit_support). Quest'ultimo ti aiuterà a creare delle unità di test per assicurarti che il nuovo fix da te creato non intralci altre parte del codice. Solo dopo questo potrai fare un `SVN Commit`.

### Scrivere codice migliore ###

Leggere la pagina [Stile di codice](ItCodingStyle.md). Seguendo uno stile di programmazione uniforme farai modo che tutti i programmatori potranno comunicare in un unico, comprensibile linguaggio.