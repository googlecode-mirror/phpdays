<a href='Hidden comment: revision: 1'></a>

Om deel te nemen aan het project phpDays dient u dezelfde codering stijl volgen _(syntax voor php, html, css, js en YAML bestanden)_.

### Algemene regels ###

_Sla alle bestanden en mappen in kleine letters op _(gebruik "file\_name.html` in plaats van `filename.html`)_. Windows **IN dit creëren een probleem** We raden een ontwikkelomgeving IDE aan [NetBeans](http://netbeans.org/)_ (maar kan ook worden gebruikt en/voor andere, zoals [Eclipse PDT](http://eclipse.org/pdt/)) _**Houd alle bestanden in** UTF-8-codering _* Newlines moet in UNIX formaat
    * Het configureren van de IDE moet automatisch verwijderd worden van extra spaties aan het einde van lijnen_ (spaties)  Het configureren van de IDE automatisch tabbladen moet vervangen worden door 4 ruimtes in PHP-bestanden en 2 ruimten in alle andere_ (met inbegrip van HTML, CSS, JS en YAML bestanden) 

### Code voorbeeld ###

```
class Days_Model_User {
  // first position for constants: usee capital letters
  const USER_FIELD = 'username';
  // second position: properties. For private and protested properties use "_" prefix
  private $_name;
  protected $_name2;

  // third position: methods
  public static function test($x) {
    if (10==$x) {
       return true;
    }
    return false;
  }

  // before function definition set only one empty line
  protected function _test2($x, $y=10) {
    // not use empty lines into function code
    if ($x==$y) {
       return true;
    }
    return false;
  }
}
```

### Automatische jou formaat aan code ###

Use this regular expressions for automatically format code:
| **From**             | **To**        | **Description**                      |
|:---------------------|:--------------|:-------------------------------------|
| `\t`                 | _4 spaces_    | vervang een tab naar 4 spaties       |
| `[ ]+$`              |               | verwijder alle spaties aan het einde van de lijn   |
| `!([a-z$])`          | `! $1`        | set ruimte na niet exploitant        |
| `^[\t ]*\n`          |               | verwijder alle legen lijnen          |
| `else *\n([ ]*)\{`   | `else\n$1{`   | set `{` after `else`                 |
| `if(`                | `if (`        | gebruik spatie na    elseif          |
| `\)[ ]*\n[ ]*\{`     | `) {\n`       | set java code style                  |
| `^([ ]*)(public|protected|private)`  | \n$1$2        | set `{` in line with function        |

### Regels voor het werken met PHP bestanden ###

  * [phpDoc](http://en.wikipedia.org/wiki/PHPDoc) standarts
  * [php coding standarts](http://cvs.php.net/viewvc.cgi/php-src/CODING_STANDARDS?view=markup)
  * [coding standard in Zend Framework](http://framework.zend.com/manual/ru/coding-standard.html)
  * [coding standard in the Kohana framework](http://dev.kohanaphp.com/wiki/CodingStyle)
  * [PEAR Coding Standards](http://pear.php.net/manual/ru/standards.php)
  * [writing comments in phpDoc style](http://en.wikipedia.org/wiki/PHPDoc)

Veiligheidsinformatie:

  * [SQL injection](http://en.wikipedia.org/wiki/SQL_injection)
  * [cross-site scripting](http://en.wikipedia.org/wiki/Cross-site_scripting)
  * [Remote File Inclusion](http://en.wikipedia.org/wiki/Remote_File_Inclusion)
  * [cross-site request forgery](http://en.wikipedia.org/wiki/Cross-site_request_forgery)