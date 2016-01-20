<a href='Hidden comment: revision: 1'></a>

To make effective use of a server's resources and their allocation reasonable we recommend applying some useful technologies.

### Memcached ###

[Memcached](http://ru.wikipedia.org/wiki/Memcached) stores result sets from queries to a database in memory _(eg MySQL)_. This allows to reduce the number of queries to a database.

See instructions how to install memcached on [Windows](http://pureform.wordpress.com/2008/01/10/installing-memcache-on-windows-for-php/). To install memcached on Ubuntu enter the following two commands:
(((
sudo aptitude install memcached
sudo aptitude install php5-memcache
)))