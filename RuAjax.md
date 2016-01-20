### Работа с JavaScript библиотеками ###

Мы рекомендуем применять [jQuery](http://jquery.com) - простую и понятную JS библиотеку.

### Клиентская часть ###

Более подробно о поддержке [Ajax в jQuery](http://docs.jquery.com/Ajax/jQuery.ajax#options).

Создадим файл `/vaw/www/myblog/public/static/js/global.js` со следующим содержимым:
```
$(document).ready(function(){

  $.ajax({
    url: 'http://localhost/myblog/blog/posts',
    dataType: 'json',
    success: function(data) {
      alert(data);
    }
  });

});
```

**ВНИМАНИЕ** Обязательно указывайте `dataType: 'json'` для корректного отображения данных.

Подключим файл скрипта в шаблон страницы `/vaw/www/myblog/app/View/layout/inde.html` в рамках тега **head**:
```
  <script type="text/javascript" src="/static/js/jquery.min.js"></script>
  <script type="text/javascript" src="/static/js/global.js"></script>
```

Теперь при загрузке страницы будет выполнен наш JS скрипт, который обратиться к станице `http://localhost/myblog/blog/posts` и полученный результат выведет во всплывающем окне. Для работы этого примера нужно реализовать серверную часть.

### Серверная часть ###

В вашем приложении следует создать метод с окончанием `AjaxAction` вместо привычного `Action`. В этом методе мы возвращаем данные, которые будут отправлены клиенту.

**ВНИМАНИЕ** Для отправки данных в формате [JSON](http://ru.wikipedia.org/wiki/JSON) Вам следует подготовить результирующий массив массив и преобразовать его в формат JSON при помощи функции [json\_encode()](http://ua2.php.net/json_encode).

Создадим файл `/vaw/www/myblog/app/Controller/Blog.php` с методом `postsAjaxAction()`:
```
class Myblog_Controller_Blog extends Days_Controller {
  /** Возвращает данные в формате JSON */
  public function postsAjaxAction() {
    // получаем записи из базы данных и возвращаем в виде многомерного массива
    $data = array('name'=>'Jimmi', 'age'=>23, 'country'=>'USA');
    return json_encode($data);
  }
}
```

Теперь можете попробовать что получилось http://localhost/myblog. Если все сделано правильно - то Вы увидите сообщение с данными, которые были возвращены методом `postsAjaxAction`.