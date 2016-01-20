<a href='Hidden comment: revision: 1'></a>

Om effectief gebruik te maken van de middelen van een server en de verdeling daarvan redelijk raden we een aantal nuttige toepassing van technologieën.

### Memcached ###

[Memcached](http://ru.wikipedia.org/wiki/Memcached) winkels resultaat sets van query's naar een database in het geheugen (bv. MySQL). Dit laat toe om het aantal vragen te beperken tot een database.

Zie de instructies hoe memcached geinstalleerd is op [Windows](http://pureform.wordpress.com/2008/01/10/installing-memcache-on-windows-for-php/). Te installeren op Ubuntu memcached voer de volgende twee commando's:
(((
sudo aptitude install memcached
sudo aptitude install php5-memcache
)))