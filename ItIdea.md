In questa pagina discuteremo sulle nuove idee per phpDays. Posta le tue idee in fondo nei commenti a fondo pagina.

### Validator ###

[Days\_Validate](ItLibDaysValidate.md) - Controlla le variabili con dei criteri e ritorna true solo se i dati sono validi
```
$age = 21;
$mail = 'Tom@Jerry.com';
// formato errato
if (Days_Validator::check($age, array('int'=>array('max'=>50, 'min'=>18))))
  echo 'You are full of strength!';
// formato giusto
if (Days_Validator::check($age, 'int: {max: 50, min: 18}'))
  echo 'You are full of strength!';
// più formati
if (Days_Validator::check($mail, 'str: {max: 70}, email, required'))
  echo 'Name correct!';
```

Compiti:
  * Semplificare il formato _(esempio dati passati come stringa `check($age, 'int: {max: 50, min: 18}')` o simili)_

### Event ###

[Days\_Event](ItLibDaysEvent.md) - Implementazione del pattern Observer che aiuta ad implementare più componenti in un unico sistema senza effettuare modifiche agli altri componenti.

Nel codice inseriremo:
```
...
  public function login($username, $password) {
    Days_Event::run('user_login_before');
    // process loginning
    if ('user logged successfully') {
      Days_Event::run('user_login_success');
      ...
    }
    else {
      Days_Event::run('user_login_fail');
      ...
    }
    Days_Event::run('user_login_after');
  }
...
```

Ora dobbiamo aggiungere al sito un forum con una sezione riservata.
```
Days_Event::add('user_login_success', 'userSuccessLogged');
// function called on success logging
function userSuccessLogged() {
  echo 'You logged successfully on forum!';
}
```

### Form ###

[Days\_Form](ItLibDaysForm.md) - Analizza i form html. Se tutti i dati passati sono corretti esegue il form.