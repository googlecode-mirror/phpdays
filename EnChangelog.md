<a href='Hidden comment: revision: 1'></a>

## List of changes in version 1.1 ##

### 1.1 beta3 ###

  * no changes

### 1.1 beta2 <sup>(15 November 2009)</sup> ###

  * Created `apps/phpdays.org`
  * Added class [Days\_Event](EnLibDaysEvent.md), Observer design pattern implementation
  * Added Unit tests for `Days_View_*` and [Days\_Event](EnLibDaysEvent.md)
  * [r59](https://code.google.com/p/phpdays/source/detail?r=59) [Days\_Engine](EnLibDaysEngine.md) Delete auto-conversion all Ajax data to JSON
  * [r193](https://code.google.com/p/phpdays/source/detail?r=193) Fix bug in Templum: throw exception if template contein php tags
  * [r200](https://code.google.com/p/phpdays/source/detail?r=200) Change url from sf.net to googlecode.com
  * [r247](https://code.google.com/p/phpdays/source/detail?r=247) Create [Days\_Tool\_AppGenerator](EnLibDaysToolAppGenerator.md). Change `@package` and `@subpackage` in all Days classes
  * [r255](https://code.google.com/p/phpdays/source/detail?r=255) Add class [Days\_Router](EnLibDaysRouter.md). Add methods "copy" and "rename" to [Days\_Db\_Table](EnLibDaysDbTable.md)
  * [r262](https://code.google.com/p/phpdays/source/detail?r=262), [r275](https://code.google.com/p/phpdays/source/detail?r=275) Refactor [View](EnLibDaysView.md) classes. Add empty helpers base
  * [r263](https://code.google.com/p/phpdays/source/detail?r=263) Extend helper classes by [Days\_Helper\_Abstract](EnLibDaysHelperAbstract.md)
  * [r266](https://code.google.com/p/phpdays/source/detail?r=266) Fix #22: Extract [Days\_Exception](EnLibDaysException.md) from `Engine.php`
  * [r267](https://code.google.com/p/phpdays/source/detail?r=267) Added methods [Days\_Response](EnLibDaysResponse.md)::getContent and [Days\_Response](EnLibDaysResponse.md)::setContent for comfort and control output of the engine
  * [r268](https://code.google.com/p/phpdays/source/detail?r=268) Added method [Days\_Event](EnLibDaysEvent.md):: get($event) for all subscribers of certain event
  * [r282](https://code.google.com/p/phpdays/source/detail?r=282) Added first [Helpers](EnLibDaysHelper.md)
  * [r283](https://code.google.com/p/phpdays/source/detail?r=283) `[lib/Templum]` Create new Pages function
  * [r284](https://code.google.com/p/phpdays/source/detail?r=284) `[lib/Templum]` Create new Collect block
  * [r285](https://code.google.com/p/phpdays/source/detail?r=285) `[lib/Templum]` Add new tests in template
  * [r288](https://code.google.com/p/phpdays/source/detail?r=288) Creating a branch for [Issue #24](https://code.google.com/p/phpdays/issues/detail?id=#24)
  * [r290](https://code.google.com/p/phpdays/source/detail?r=290) `[apps/phpdays.org]` Change menu links
  * [r291](https://code.google.com/p/phpdays/source/detail?r=291) `[apps/phpdays.org]` Rename service "dev" to "lab"

### 1.1 beta1 <sup>(18 October 2009)</sup> ###

  * [r19](https://code.google.com/p/phpdays/source/detail?r=19)-[r20](https://code.google.com/p/phpdays/source/detail?r=20) Added [Templum](http://templum.googlecode.com) support - new template engine.
  * `apps/new`: Fix css text-align (created by yui library).
  * Changes in apps/new: added jquery library, added yui css reset, changed index layout.
  * Fix bug in application "phpdays.org" in tag script.
  * Add Smarty plugin block for show block template by name.
  * Add application "phpdays.org" with static main page.

### Archive versions ###

Select the appropriate version of the framework, to see a list of changes.

  * [1.0](EnChangelog1_0.md)