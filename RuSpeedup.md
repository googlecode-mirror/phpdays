Для экономии ресурсов сервера и разумного их распределения предлагаем воспользоваться полезными технологиями.

### Memcached ###

[Memcached](http://ru.wikipedia.org/wiki/Memcached) хранит в оперативной памяти выборки данных из базы данных _(например MySQL)_. Это позволяет реже обращаться к базе данных.

Просмотрите инструкцию по установке memcached для [Windows](http://pureform.wordpress.com/2008/01/10/installing-memcache-on-windows-for-php/). Для установки memcached в Ubuntu требуется ввести всего две команды:
```
sudo aptitude install memcached
sudo aptitude install php5-memcache
```