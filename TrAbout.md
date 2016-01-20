**phpDays** ile Web sitesi oluşturma sürecini hızlandırma ve basitleştirme imkanına sahip olacaksınız. Bu sitenin bakımı ve geliştirmesi daha kolay olacaktır.

### phpDays özellikleri ###

  * birinci sınıf [phpDays topluluğu](http://code.google.com/p/phpdays/people/list)
  * phpDays [MVC](TrMvc.md) temelinde oluşturulmuştur
  * [ORM](TrLibDaysDbTable.md) için tam desteğe sahiptir _(SQL sorguları yazmaya gerek yok)_
  * [database abstraction layer](TrLibDaysDb.md) kullanarak veritabanlarına erişim sağlar _(SQL sorguları yazma)_
  * phpDays'in tüm ayarları [YAML](http://en.wikipedia.org/wiki/YAML) formatında [konfigürasyon dosyası](TrLibDaysConfig.md) içerisinde tutulur
  * sınıflar otomatik olarak yüklenir _(`include()` ve `require()`u unutun)_
  * **UTF-8** kodlaması ile _(Türkçe dahil)_ tüm yazım dillerini tam destekler
  * [AJAX](TrAjax.md) için tam destek _([jQuery](http://jquery.com) ile tavsiye edilir)_
  * dilediğiniz gibi [hataları gösterin](TrDaysLog.md) _([FirePHP](http://firephp.org), tarayıcı(browser), basit dosya ve hatta SQLite çıktısı desteklenir)_
  * uygulamaların çalışması hakkında bilgi basın _(çalıştırılan SQL sorguları, çalıştırılan metodların isimleri)_
  * pratik sınıf hiyerarşisi _(Zend Frameworkte kullanıldığı gibi)_
  * _ve diğerleri_