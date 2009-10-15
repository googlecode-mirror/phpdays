/**
 * @author Anton Danilchenko <php6developer@ya.ru>
 */
DEFAULT_LANGUAGE = 'en';
// translations
var I18N_TRANSLATION = {
	'form_fields_empty': {
		'ru': 'Заполните все поля формы',
		'en': 'Please, fill all form fields'},
	'form_fields_incorrect': {
		'ru': 'Заполните все поля формы допустимыми значениями',
		'en': 'Please, fill all form fields with correct values'},
}; 
// process one array with messages on current language
var I18N = [];
for (field in I18N_TRANSLATION)
	I18N[field] = ('undefined'!=typeof(CURRENT_LANGUAGE) && (CURRENT_LANGUAGE in I18N_TRANSLATION[field]))
		? I18N_TRANSLATION[field][CURRENT_LANGUAGE]
		: I18N_TRANSLATION[field][DEFAULT_LANGUAGE];