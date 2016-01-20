<a href='Hidden comment: revision: 1'></a>

To participate in the project phpDays you should follow the same coding style _(syntax for php, html, css, js and yaml files)_.

### General rules ###

  * save all files and folders in lower case only _(use `file_name.html` instead of `fileName.html`)_. _In Windows this create a problems_
  * recommend a development environment IDE [NetBeans](http://netbeans.org/) _(but can be used and other such as [Eclipse PDT](http://eclipse.org/pdt/))_
  * keep all the files in **UTF-8** encoding
  * newlines must be in UNIX format
  * configure the IDE to automatically remove extra spaces at the end of lines _(trailing spaces)_
  * configure the IDE to automatically replace tabs by 4 spaces in php files and 2 spaces in all other _(including html, css, js and yaml files)_

### Code sample ###

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

### Autoformat your code ###

Use this regular expressions for automatically format code:
| **From**             | **To**        | **Description**                      |
|:---------------------|:--------------|:-------------------------------------|
| `\t`                 | _4 spaces_    | replace tab to 4 spaces              |
| `[ ]+$`              |               | delete all spaces in end of line     |
| `!([a-z$])`          | `! $1`        | set space after not operator         |
| `^[\t ]*\n`          |               | delete empty lines                   |
| `else *\n([ ]*)\{`   | `else\n$1{`   | set `{` after `else`                 |
| `if(`                | `if (`        | use space after if and elseif        |
| `\)[ ]*\n[ ]*\{`     | `) {\n`       | set java code style                  |
| `^([ ]*)(public|protected|private)`  | \n$1$2        | set `{` in line with function        |

### Rules for work with php files ###

  * [phpDoc](http://en.wikipedia.org/wiki/PHPDoc) standarts
  * [php coding standarts](http://cvs.php.net/viewvc.cgi/php-src/CODING_STANDARDS?view=markup)
  * [coding standard in Zend Framework](http://framework.zend.com/manual/ru/coding-standard.html)
  * [coding standard in the Kohana framework](http://dev.kohanaphp.com/wiki/CodingStyle)
  * [PEAR Coding Standards](http://pear.php.net/manual/ru/standards.php)
  * [writing comments in phpDoc style](http://en.wikipedia.org/wiki/PHPDoc)

Safety Information:

  * [SQL injection](http://en.wikipedia.org/wiki/SQL_injection)
  * [cross-site scripting](http://en.wikipedia.org/wiki/Cross-site_scripting)
  * [Remote File Inclusion](http://en.wikipedia.org/wiki/Remote_File_Inclusion)
  * [cross-site request forgery](http://en.wikipedia.org/wiki/Cross-site_request_forgery)