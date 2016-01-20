İngilizce biliyorsanız, projeye aşina olduysanız ve projede yer almaktan eminseniz ve ilgi duyuyorsanız, o zaman aşağıdaki yönergeleri okuyun.

### phpDays Ekibine katılmak ###

  * ekibe katılma talebinizi [Tartışmalar](TrAnswers.md) sayfasına ingilizce yorum olarak ekleyin veya [proje destek grubu](http://groups.google.com/group/phpdays-en)na gönderin (Sadece ingilizce)
  * mesajınızda ingilizce olarak üstlenmek istediğiniz görevi belirtin _(php geliştiricisi, web tasarımcısı, dökümantasyon çevirmeni, dizgici, JavaScript geliştiricisi)_ ve Gmail adresinizi ekleyin _(Gmail kullanıcı adınız yeterlidir)_
  * bazı değerlendirmelerden sonra projeye katılmanız hakkındaki kararımızı içeren bir eposta alacaksınız _(eğer üç gün içinde cevap almazsanız, talebinizi tekrar gönderin)_
  * herşey iyi giderse, projenin bir üyesi olacaksınız ve üye olmayanların yapabildiğinden daha fazlasını yapabileceksiniz _(projenin kodunu, dökümantasyonu ve görevleri değiştirebileceksiniz)_
  * aynı zamanda [projenin üye listesi](http://code.google.com/p/phpdays/people/list)ne ekleneceksiniz _(bu linki özgeçmişinize eklemeyi unutmayın)_

### Site hakkında Genel Bilgi ###

  * [Yüklemeler](http://code.google.com/p/phpdays/downloads/list) - Son kullanıcı için projenin çalışan kopyalarının bulunduğu indirme sayfası
  * [Wiki](http://code.google.com/p/phpdays/w/list) - projenin dökümantasyonu
  * [Sorunlar](http://code.google.com/p/phpdays/issues/list) - sorunların ve görevlerin listesi
  * [Kaynak](http://code.google.com/p/phpdays/source/list) - projenin SVN deposu ve değişim günlüğü hakkında bilgi

### Projenin çalışan kopyasını yüklemek ###

  * projenin dosyalarıyla çalışmak için bir SVN istemcisi indirip kurun
  * projenin çalışan bir kopyasını indirin _(daha fazla bilgi için: [Checkout](http://code.google.com/p/phpdays/source/checkout))_
  * eğer daha önce Subversion ile çalışmadıysanız, zamanınızı ayırıp öğrenin

### Değişikleri Uygulamak için Yönergeler _(SVN commit)_ ###

Yorumlar için aşağıdaki formatı takip edin

  * `Fix #1234: Açığın adı (ingilizce)` - `1234` numaralı hatanın çözümü için. Eğer açık [Sorunlar](http://code.google.com/p/phpdays/issues/list) listesinde yoksa, o zaman öncelikle sorunu eklemelisiniz ve sadece bundan sonra `SVN commit` yapmalısınız.
  * her açığı/sorunu ayrı bir satırda yazın. Satırın sonuna nokta koymayın.

### Kendiniz Deneyin ###

[PHPUnit](http://blogs.sun.com/netbeansphp/entry/recent_improvements_in_phpunit_support) kurun. Bu, koddaki yeni düzenlemenin başka birşeyi bozmayacağından emin olmanız için ünite testler oluşturmanıza imkan tanıyacaktır. Sadece bundan sonra `SVN commit` yapmalısınız.

### Daha İyi Kod Yazın ###

Projemizde benimsenmiş [kodlama stili](TrCodingStyle.md)ni okuyun. Tek stili uygulamak tüm geliştiricilerin tek ve anlaşılır dilde iletişim kurmalarına imkan tanır.