<a href='Hidden comment: revision: 1'></a>

Als het een complexe site wordt, moet er een deel feature-rich worden toegevoegd aan de site, dit is om het beste te maken voor een afzonderlijk project. Het project kan worden geïntegreerd in een andere site. Het geeft een schijn van Lego stenen, waaruit u een website kan bouwen op basis van andere projecten.

### Maken van een site ###

Stel dat je nog meer nodig hebt om een complexe _forum\_section te maken_. Maak dan een aparte [project](NlInstall.md), en uit te voeren enkel de forum sectie. Dezelfde manier omgaan met de andere complexe onderdelen van de site _(met inbegrip van een blog, catalogus, enz.)_.

Het project zal worden gevestigd in `/var/www/forum` directory.

Nu de voorbereiding van uw forum voor opname in een ander gedeelte van de site. Maak een nieuw configuratiebestand `/var/www/forum/app/config/myblog_development.yaml`. Bewerk zo de database dat de applicatie goed werkt. Maak `url/base: myblog/forum` option.

Voer alle eenvoudige delen van de site op dezelfde manier uit als voorheen - door het creëren van een aparte [controller](EnController.md).

### Met inbegrip van het project in de huidige sectie van de site ###

Files en de `static` directory bevinden zich in de `/var/www/myblog/public` directory.

We hebben om een `/var/www/myblog/public/forum` directory voor ons nieuwe forum gedeelte. Kopieer de inhoud van `/var/www/forum/public` in een nieuwe map.

Bewerk dit bestand `/var/www/myblog/public/forum/index.php`:
**Stel het pad naar de phpDays bibliotheek
  * Stel het pad naar het forum toepassing** Wijziging van de configuratie van `ontwikkeling` in `myblog_development`

### Uitleg ###

Wanneer u naar gaat http://localhost/myblog/forum, dan wordt je door gestuurd naar `/var/www/myblog/public/forum` en de juiste toepassing zal worden gelanceerd. Als gevolg daarvan zullen we krijgen "a site within a site."

Als u een soortgelijk forum sectie gebruikt en dit in een ander project toepast, zal dit tijd besparen. Alles wat je je hoeft te doen is een project in een ander project stoppen.