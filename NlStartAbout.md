<a href='Hidden comment: revision: 1'></a>

### Snelstart Handleiding ###

Eerst [installeer de phpDays framework](NlInstall.md) op je server. Leer over phpDays' [coding standard](NlCodingStyle.md) _(Dit zal u helpen en andere projectleden te begrijpen van de code die u hebt gemaakt, zelfs een paar jaar later)_.

### Project Structuur ###

Nu zijn er twee mappen tot uw beschikking: `app` and `public`.

De `public` directory bevat een subdirectory `static` die beelden, houdt css, javascript en andere statische bestanden _(eg, documents or archives)_. Ook is het belangrijk  dossier - `index.php heeft" die de toepassing start van de "app" directory. De `. Htaccess-bestand is` hulp - niet nodig om het te veranderen. De `` robots.txt-bestand is voor zoekmachines _(u kunt meer over lezen op het internet)_.

#### App - jou applicatie directory ####

De `app" directory bevat alle bestanden van onze "dynamisch" applicatie.

Het "systeem" directory bevat submappen: "cache" (cache), `doc` (documentatie project), `log` (foutmeldingen), `view` (gecompileerde bestanden sjabloon).

De `config" directory bevat configuratie-bestanden van toepassing: `development.yaml` (voor een toepassing in ontwikkeling) en "production.yaml" (voor een productie).

Nu zie je de drie belangrijkste mappen met die we voortdurend zullen werken: "Model`, `Hobby`, `Controller` (afgekort als [MVC](NlMvc.md) - lees meer over).

### Maken van een blog site ###

Waar valt te beginnen? Laten we een eenvoudig naar een zeer doeltreffend voorbeeld kijken - een blog site. De gebruikers moeten in staat zijn om door de artikelen heen te bladeren en op de site. Verder registreren ze hun eigen artikelen en commentaar toevoegen.

Laten we eens zien hoe snel en elegant kan worden gedaan in 2 uur. Is er genoeg tijd? Dan verder naar het volgende onderdeel - modellen [aanvraag's](NlStartModel.md).