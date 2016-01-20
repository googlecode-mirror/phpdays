### System engine ###

  * MVC ([Days\_Model](ItLibDaysModel.md), [Days\_View](ItLibDaysView.md), [Days\_Controller](ItLibDaysController.md)) - classi base per lavorare con il framework
  * [Days\_Config](ItLibDaysConfig.md) - interagisce con la configurazione del sito
  * [Days\_Db](ItLibDaysDb.md) - Interagisce con il database
  * [Days\_Db\_Table](ItLibDaysDbTable.md) - Implementazione ORM che rappresenta le tabelle del database
  * [Days\_Engine](ItLibDaysEngine.md) - Il punto di partenza del framework
  * [Days\_Event](ItLibDaysEvent.md) - Implementazione del pattern [observer](http://it.wikipedia.org/wiki/Observer_pattern).
  * [Days\_Log](ItLibDaysLog.md) - Logga gli errori e i debug
  * [Days\_Request](ItLibDaysRequest.md) - Gestisce le request provenienti dal browser utente
  * [Days\_Response](ItLibDaysResponse.md) - Gestisce le risposte da inviare al browser
  * [Days\_Url](ItLibDaysUrl.md) - Lavora con gli URL

### In fase di sviluppo ###

  * [Days\_Acl](ItLibDaysAcl.md) _(Aceess Control List)_ - Classe per la gestione dei privilegi nelle sezioni del sito.
  * [Days\_Filter](ItLibDaysFilter.md) - Filtra i dati dell'utente _(anche conosciuto come verifica o convalida dei dati)_
  * [Days\_Form](ItLibDaysForm.md) - Gestione dei dati provenienti dai form html.
  * [Days\_User](ItLibDaysUser.md) - Classe di gestione degli utenti _(autorizzazioni, autenticazioni, fine della sessione)_