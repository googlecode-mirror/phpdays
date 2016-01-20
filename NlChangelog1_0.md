<a href='Hidden comment: revision: 1'></a>

## Version 1.0 - _9 October 2009_ ##

De eerste release inclusief ORM implementatie, logging, stabiele project structuur, stabiele applicaties.

### 1.0 final release - _9 October 2009_ ###

  * Verbetering van de methode `find()` voor "one" row: ga terug naar null als de rij niet bestaat
  * verbeter fouten in method `find()` voor "one" rij (als de rij niet bestaat)
  * verbeter bug met method `create()` in [Days\_Db\_Rowset](NlLibDaysDbRowset.md) en [Days\_Db\_Table](NlLibDaysDbTable.md)
  * breng in een werkende staat van php-templates **(xaoc)**
  * even verkleinen in het blog-example **(xaoc)**
  * presenteren in een goed werkend conditie in blog-example **(xaoc)**

### 1.0 release candidate 2 - _7 October 2009_ ###

  * verbeter `profile()` method in [Days\_Log](NlLibDaysLog.md) class _(stuur bericht alleen als firephp logging)_
**Bug fix met onjuiste definitie controller / actie met lege basis pad
  * Fix onjuiste Pathes vervangen met lege basis pad
  * Fix show waarschuwing op servers zonder standaard tijdzone**

### 1.0 release candidate - _6 October 2009_ ###

  * Voeg profiel toe [Days\_Db\_Table](NlLibDaysDbTable.md) class
  * Voegtoe `child` en `parent` magic fields into [Days\_Db\_Row](NlLibDaysDbRow.md)
  * Voegtoe `profile()` method into [Days\_Log](NlLibDaysLog.md)
  * update Spyc yaml parser to version 0.4.5
  * Verander applications into "apps" directory (voegtoe directories "app" en "public")
  * Voegtoe smarty plugin `helper` voor call helpers in templates
  * Voegtoe ondersteuning van de path (voor werk in directory)
  * reworked en presented in de werking condition the blog-example **(xaoc)**
  * Voegtoe method `_quote` in [Days\_Db\_Table](NlLibDaysDbTable.md) for quote identifiers
  * quote column names and table names in join statements (method `find()` in [Days\_Db\_Table](NlLibDaysDbTable.md))
  * add prefix to model classes. _Change this into you projects_
  * separetely handle `PostAction` before execute specified action
  * reworked and presented in the working condition the blog-example **(xaoc)**
  * Verbeter fout met connection View in ORM (link MxN), voegtoe shielding behalf View **(xaoc)**
  * Verander applicatie examples (fix bugs)
  * Verbeter in [DaysEngine](NlLibDaysEngine.md) for loading file in `CamelCase`
  * Verbeter een fout in native php templates bij default
  * Voeg een nieuwe template engine toe - Dwoo
  * code cleanup and refactoring
  * Verbeter fouten in test compatibiliteit met php 5.3
  * Verander project description naar _"php:Days - flexible php5 framework"_

### 1.0 beta 3 - _21 September 2009_ ###

  * verander method info() in [Days\_Db\_Table](NllibDaysDbTable.md) en keer terug "null" if column not exists
  * implement 1x1, 1xN, MxN relations in [Days\_Db\_Table](NlLibDaysDbTable.md) (need full tests)
  * verander de method info() in [Days\_Db\_Table](NlLibDaysDbTable.md) voor het terug info over specifieke tabel
  * refactoring code into [DaysEngine](NlLibDaysEngine.md) class
  * [Days\_Log](NlLibDaysLog.md): voegtoe implementatie van de method `logtoSqlite()` **(xaoc)**
  * slightly verander het formaat van de output `FirePhp` **(xaoc)**
  * Verbeter Days\_Log: voegtoe error levels
  * Repareer fout [DaysLog](EnLibDaysLog.md): voegtoe method `logtoSqlite` voor sqlite logging
  * Voegtoe comments in configuratie files
  * Voegtoe configuratie parameter "log/level"
  * Voegtoe "View/block" folder into applications for template blocks
  * refactoring van [Days\_Controller](NlLibDaysController.md), [Days\_Engine](NlLibDaysEngine.md): pass inhoud naam sjabloon op controller object creatie
  * refactoring of [Days\_Controller](NlLibDaysController.md): change logic in "getContent" method - return content without layout
  * Toegevoegde method "toArray" voor terugkeer van alle gegevens arrays in [Days\_Db\_Rowset](NlLibDaysDbRowset.md)
  * Herstel fout in [Days\_Db\_Table](NlLibDaysDbTable.md): vervang en creëer een object uit Zend\_Db tot innerlijke in de class
  * Herstel fout in [Days\_Db\_Row](NlLibDaysDbRow.md) voor het niet bestaande kolommen zijn er uitzonderingen
  * Herstel fout in [Days\_Db\_Row](NlLibDaysDbRow.md) en controleer de tabel structuur.
  * Verbeter [Days\_Db\_Row](NlLibDaysDbRow.md) de bovenstaande tabel.
  * Voeg ondersteuning `AjaxAction` en `PostAction` in controllers

### 1.0 beta 2 - _8 September 2009_ ###

  * Repareer de fouten in het configuratie bestand

### 1.0 beta 1 - _4 September 2009_ ###

  * Toegevoegd ORM ondersteuning met [Days\_Db\_Table](NlLibDaysDbTable.md) _(Active Record and Date Mapper patterns)_
  * Toegevoegd `apps/blog` directory voor develop blog applicatie
  * verplaatst pld test applicatie naar `app` to `apps/new`
  * update Zend Framework library to versie 1.9.2
  * Gerepareerde fouten

### 1.0 alpha 5 - _17 August 2009_ ###

  * Voeg een nieuw component toe [Days\_Db\_Table](NlLibDaysDbTable.md) (user for create models)
  * upgrade Zend Framework naar version 1.9.1
  * Repareer de fouten en voeg de model class name toe

### 1.0 alpha 4 - _10 August 2009_ ###

  * verminder de bestandsgrootte _(verwijder de niet gebruikte Zend Framework components)_

### 1.0 alpha 3 - _9 August 2009_ ###

  * [show error page](NlLibDaysLog.md) (404 - page not found; redirect; etc)
  * [ajax support](NlAjax.md) Toegevoegd
  * Maak de bug in Return part of URL addres by parameter nummer

### 1.0 alpha 2 - _30th July 2009_ ###

  * U moet nu een `app/Controller/Index.php` in plaats van de oude `app/controller/IndexController.php` tot wijziging van de structuur van het project. Kijk naar de [updated manual](NlMvc.md). Deze wijzigingen hebben betrekking op [model](NlMvc.md) en [presentation](NlMvc.md)

### 1.0 alpha 1 - _23 July 2009_ ###

  * initial release