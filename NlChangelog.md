<a href='Hidden comment: revision: 1'></a>

## Lijst van de veranderingen in versie 1.1 ##

### 1.1 beta3 ###

  * geen veranderingen

### 1.1 beta2 <sup>(15 November 2009)</sup> ###

  * Maak `apps/phpdays.org`
  * Voeg een class [Days\_Event](NlLibDaysEvent.md), Observeer design pattern implementeren
  * Voeg unit tests uit `Days_View_*` en [Days\_Event](NlLibDaysEvent.md)
  * [r59](https://code.google.com/p/phpdays/source/detail?r=59) [Days\_Engine](NlLibDaysEngine.md) Verwijder auto-conversion van Ajax data naar JSON
  * [r193](https://code.google.com/p/phpdays/source/detail?r=193) Fix bug in Templum: gooi uitzondering als sjabloon contein php-tags
  * [r200](https://code.google.com/p/phpdays/source/detail?r=200) Verander url sf.net naar googlecode.com
  * [r247](https://code.google.com/p/phpdays/source/detail?r=247) Maak [Days\_Tool\_AppGenerator](NlLibDaysToolAppGenerator.md). Verander `@package` en `@subpackage` in all Days classes
  * [r255](https://code.google.com/p/phpdays/source/detail?r=255) Voeg een class [Days\_Router](NlLibDaysRouter.md). Voeg methods "copy" en "rename" naar [Days\_Db\_Table](NlLibDaysDbTable.md)
  * [r262](https://code.google.com/p/phpdays/source/detail?r=262), [r275](https://code.google.com/p/phpdays/source/detail?r=275) Refactor [View](NlLibDaysView.md) classes. Voeg lege helpers toe in base
  * [r263](https://code.google.com/p/phpdays/source/detail?r=263) Uitgebreide classes bij [Days\_Helper\_Abstract](NlLibDaysHelperAbstract.md)
  * [r266](https://code.google.com/p/phpdays/source/detail?r=266) Fix #22: Pak uit [Days\_Exception](NlLibDaysException.md) van `Engine.php`
  * [r267](https://code.google.com/p/phpdays/source/detail?r=267) Voeg toe methods [Days\_Response](NlLibDaysResponse.md)::getContent en [Days\_Response](NlLibDaysResponse.md)::setContent voor comfort en controle-uitgang van de enige
  * [r268](https://code.google.com/p/phpdays/source/detail?r=268) Voeg toe methods [Days\_Event](NlLibDaysEvent.md):: get($event) for all subscribers of certain event
  * [r282](https://code.google.com/p/phpdays/source/detail?r=282) Voeg eerst [Helpers](NlLibDaysHelper.md) toe
  * [r283](https://code.google.com/p/phpdays/source/detail?r=283) `[lib/Templum]` Maak een nieuwe pagina functie
  * [r284](https://code.google.com/p/phpdays/source/detail?r=284) `[lib/Templum]` Maak een nieuwe Collect block
  * [r285](https://code.google.com/p/phpdays/source/detail?r=285) `[lib/Templum]` Voeg nieuwe tests toe in template
  * [r288](https://code.google.com/p/phpdays/source/detail?r=288) Maak een nieuwe branch voor [Issue #24](https://code.google.com/p/phpdays/issues/detail?id=#24)
  * [r290](https://code.google.com/p/phpdays/source/detail?r=290) `[apps/phpdays.org]` Verander menu links
  * [r291](https://code.google.com/p/phpdays/source/detail?r=291) `[apps/phpdays.org]` Hernoem service "dev" naar "lab"

### 1.1 beta1 <sup>(18 Oktober 2009)</sup> ###

  * [r19](https://code.google.com/p/phpdays/source/detail?r=19)-[r20](https://code.google.com/p/phpdays/source/detail?r=20) Toegevoegd [Templum](http://templum.googlecode.com) ondersteuning - nieuw template engine.
  * `apps/new`: Maak css text-align (gemaakt bij yui library).
  * Verander in apps/new: voeg toe jquery library, voeg toe yui css reset, verander index layout.
  * Repareer de fouten in application "phpdays.org" in tag script.
  * Voeg toe Smarty plugin block for show block template by name.
  * Voeg toe applicatie "phpdays.org" with static main page.

### Archive versions ###

Selecteer de juiste versie van framework, om een lijst van veranderingen.

  * [1.0](EnChangelog1_0.md)