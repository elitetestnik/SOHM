<?php
////////////////////////////////////////
//  Файл из пакета дистрибутива:
//  CMS "Mambo 4.5.2.3 Paranoia"
//  Дата выпуска: 06.08.2005
//  Исправленная и доработанная версия
//  Локализация и сборка дистрибутива:
//  - AndyR - mailto:andyr@mail.ru
//////////////////////////////////////
// Не удаляйте строку ниже:
$andyr_signature='Mambo_4523_Patanoia_012';
?>
<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/** common */
DEFINE('_LANGUAGE','ru');
DEFINE('_NOT_AUTH','У Вас нет прав для просмотра этого ресурса.');
DEFINE('_DO_LOGIN','Вы должны зайти как пользователь.');
DEFINE('_VALID_AZ09',"Пожалуйста, введите правильно %s.  Не должно быть пробелов, только символы 0-9,a-z,A-Z и длина больше %d символов.");
DEFINE('_CMN_YES',"Да");
DEFINE('_CMN_NO',"Нет");
DEFINE('_CMN_SHOW',"Показать");
DEFINE('_CMN_HIDE',"Скрыть");

DEFINE('_CMN_NAME',"Имя");
DEFINE('_CMN_DESCRIPTION',"Описание");
DEFINE('_CMN_SAVE',"Сохранить");
DEFINE('_CMN_CANCEL',"Отменить");
DEFINE('_CMN_PRINT',"Версия для печати");
DEFINE('_CMN_PDF',"Версия в формате PDF");
DEFINE('_CMN_EMAIL',"Отправить на e-mail");
DEFINE('_ICON_SEP','|');
DEFINE('_CMN_PARENT',"Источник");
DEFINE('_CMN_ORDERING',"Порядок");
DEFINE('_CMN_ACCESS',"Уровень доступа");
DEFINE('_CMN_SELECT',"Выбор");

DEFINE('_CMN_NEXT',"Следующая");
DEFINE('_CMN_NEXT_ARROW',"&gt;&gt;");
DEFINE('_CMN_PREV',"Предыдущая");
DEFINE('_CMN_PREV_ARROW',"&gt;&gt;");

DEFINE('_CMN_SORT_NONE',"Без сортировки");
DEFINE('_CMN_SORT_ASC',"По возрастанию");
DEFINE('_CMN_SORT_DESC',"По убыванию");

DEFINE('_CMN_NEW',"Добавить");
DEFINE('_CMN_NONE',"Нет");
DEFINE('_CMN_LEFT',"Лево");
DEFINE('_CMN_RIGHT',"Право");
DEFINE('_CMN_CENTER',"Центр");
DEFINE('_CMN_ARCHIVE','В архив');
DEFINE('_CMN_UNARCHIVE','Из архива'); DEFINE('_CMN_TOP','В (TOP)'); DEFINE('_CMN_BOTTOM','В (Bottom)');

DEFINE('_CMN_PUBLISHED',"Опубликована");
DEFINE('_CMN_UNPUBLISHED',"Неопубликована");

DEFINE('_CMN_EDIT_HTML','Редактировать HTML');
DEFINE('_CMN_EDIT_CSS','Редактировать CSS');

DEFINE('_CMN_DELETE','Удалить');

DEFINE('_CMN_FOLDER',"Каталог");
DEFINE('_CMN_SUBFOLDER',"Подкаталог");
DEFINE('_CMN_OPTIONAL',"Не обязательно");
DEFINE('_CMN_REQUIRED',"Обязательно");

DEFINE('_CMN_CONTINUE',"Продолжить");

DEFINE('_CMN_NEW_ITEM_LAST',"Новый элемент будет последним");
DEFINE('_CMN_NEW_ITEM_FIRST','Новый элемент будет первым');
DEFINE('_LOGIN_INCOMPLETE','Пожалуйста, заполните поля Пользователь и Пароль.');
DEFINE('_LOGIN_BLOCKED','Ваша учётная запись была заблокирована. За более подробной информации обращайтесь к администатору.');
DEFINE('_LOGIN_INCORRECT','Неправильное имя пользователя (логин) или пароль. Попробуйте ещё раз.');
DEFINE('_LOGIN_NOADMINS','Вы не можете войти. На сайте нет администраторов.');
DEFINE('_CMN_JAVASCRIPT','!Внимание! Для выполнения операции должна быть включена поддержка Java-Script.');

DEFINE('_NEW_MESSAGE','Есть новое личное сообщение');
DEFINE('_MESSAGE_FAILED','Пользователь блокировал входящие ЛС. Сообщение НЕ доставлено.');

DEFINE('_CMN_IFRAMES', 'Выбранная операция может быть выполнена некорректно. К сожалению, Ваш браузер не поддерживает Inline Frames');

DEFINE('_INSTALL_WARN','Для Вашей же безопасности, пожалуйста, полностью удалите директорию "installation", включая все файлы и поддиректории в ней, затем - просто обновите эту страницу');
DEFINE('_TEMPLATE_WARN','<font color=\"red\"><b>Файл(ы) запрошенного скина не найден(ы):</b></font>');
DEFINE('_NO_PARAMS','Параметров для этой опции нет');
DEFINE('_HANDLER','Не определен хендлер для типа');

/** mambots */
DEFINE('_TOC_JUMPTO',"Список статей");

/**  content */
DEFINE('_READ_MORE','Подробнее...');
DEFINE('_READ_MORE_REGISTER','Только для зарегистрированных пользователей...');
DEFINE('_MORE','Еще...');
DEFINE('_ON_NEW_CONTENT', "Новый элемент добавил [ %s ]  с названием [ %s ]  из раздела [ %s ]  и категории  [ %s ]" );
DEFINE('_SEL_CATEGORY','Выберите категорию');
DEFINE('_SEL_SECTION','Выберите секцию (раздел)');
DEFINE('_SEL_AUTHOR','- Выбор автора -');
DEFINE('_SEL_POSITION','- Выбор позиции -');
DEFINE('_SEL_TYPE','- Выбор типа -');
DEFINE('_EMPTY_CATEGORY','Категория сейчас пуста');
DEFINE('_EMPTY_BLOG','Нет материала для отображения');
DEFINE('_NOT_EXIST','Запрашиваимая страница не существует.<br />Пожалуйста, выберите нужную страницу из главного меню.');

/** classes/html/modules.php */
DEFINE('_BUTTON_VOTE','Ок!');
DEFINE('_BUTTON_RESULTS','Итоги');
DEFINE('_USERNAME','Пользователь');
DEFINE('_LOST_PASSWORD','Забыли пароль?');
DEFINE('_PASSWORD','Пароль');
DEFINE('_BUTTON_LOGIN','Войти');
DEFINE('_BUTTON_LOGOUT','Выйти');
DEFINE('_NO_ACCOUNT','Вы не зарегистрированы.');
DEFINE('_CREATE_ACCOUNT','Регистрация');
DEFINE('_VOTE_POOR','Худшая');
DEFINE('_VOTE_BEST','Лучшая');
DEFINE('_USER_RATING','Рейтинг');
DEFINE('_RATE_BUTTON','Оценить');
DEFINE('_REMEMBER_ME','Запомнить меня');

/** contact.php */
DEFINE('_ENQUIRY','Контакты');
DEFINE('_ENQUIRY_TEXT','Это сообщение было отправлено через раздел Контакты сайта');
DEFINE('_COPY_TEXT','Это копия Вашего сообщения, посланного Вами Администратору сайта. <br>Дата: %s');
DEFINE('_COPY_SUBJECT','Копия: ');
DEFINE('_THANK_MESSAGE','Спасибо! Сообщение успешно отправлено.');
DEFINE('_CLOAKING','Этот адрес e-mail защищен от спам-ботов. Чтобы увидеть его, у Вас должен быть включен Java-Script');
DEFINE('_CONTACT_HEADER_NAME','Имя');
DEFINE('_CONTACT_HEADER_POS','Должность');
DEFINE('_CONTACT_HEADER_EMAIL','e-mail');
DEFINE('_CONTACT_HEADER_PHONE','Телефон');
DEFINE('_CONTACT_HEADER_FAX','Факс');
DEFINE('_CONTACTS_DESC','Контактные лица этого сайта...');

/** classes/html/contact.php */
DEFINE('_CONTACT_TITLE','Контакты');
DEFINE('_EMAIL_DESCRIPTION','Отправить письмо этому контактному лицу:');
DEFINE('_NAME_PROMPT','Введите Ваше имя:');
DEFINE('_EMAIL_PROMPT',' Введите Ваш e-mail:');
DEFINE('_MESSAGE_PROMPT',' Введите текст Вашего сообщения:');
DEFINE('_SEND_BUTTON','Отправить');
DEFINE('_CONTACT_FORM_NC','Пожалуйста, заполните форму полностью и правильно.');
DEFINE('_CONTACT_TELEPHONE','Телефон: ');
DEFINE('_CONTACT_MOBILE','Моб.тел.: ');
DEFINE('_CONTACT_FAX','Факс: ');
DEFINE('_CONTACT_EMAIL','e-mail: ');
DEFINE('_CONTACT_NAME','Имя: ');
DEFINE('_CONTACT_POSITION','Должность: ');
DEFINE('_CONTACT_ADDRESS','Адрес: ');
DEFINE('_CONTACT_MISC','Информация: ');
DEFINE('_CONTACT_SEL','Выберите получателя:');
DEFINE('_CONTACT_NONE','Подробные данные контактного лица не представлены.');
DEFINE('_EMAIL_A_COPY','Отправить копию этого письма на Ваш адрес');
DEFINE('_CONTACT_DOWNLOAD_AS','Информация для раздела Download');
DEFINE('_VCARD','VCard-карта');

/** pageNavigation */
DEFINE('_PN_PAGE','Страница');
DEFINE('_PN_OF','из');
DEFINE('_PN_START','В начало');
DEFINE('_PN_PREVIOUS','Предыдущая');
DEFINE('_PN_NEXT','Следующая');
DEFINE('_PN_END','В конец');
DEFINE('_PN_DISPLAY_NR','Показано #');
DEFINE('_PN_RESULTS','Всего');

/** emailfriend */
DEFINE('_EMAIL_TITLE','Написать e-mail  другу');
DEFINE('_EMAIL_FRIEND','Отправка на e-mail ссылки на страницу.');
DEFINE('_EMAIL_FRIEND_ADDR','e-mail друга:');
DEFINE('_EMAIL_YOUR_NAME','Ваше имя:');
DEFINE('_EMAIL_YOUR_MAIL','Ваш e-mail:');
DEFINE('_SUBJECT_PROMPT',' Тема письма:');
DEFINE('_BUTTON_SUBMIT_MAIL','Отправить e-mail');
DEFINE('_BUTTON_CANCEL','Отмена');
DEFINE('_EMAIL_ERR_NOINFO','Вы должны правильно ввести свой e-mail и e-mail получателя этого письма.');
DEFINE('_EMAIL_MSG',' Здравствуйте! Следующую страницу с сайта "%s" отправил Вам %s ( %s ).

Вы сможете просмотреть её по этой ссылке: %s');
DEFINE('_EMAIL_INFO','Письмо отправил');
DEFINE('_EMAIL_SENT','Ссылка на эту страницу отправлена для');
DEFINE('_PROMPT_CLOSE','[Закрыть окно]');

/** classes/html/content.php */
DEFINE('_AUTHOR_BY', ' Автор');
DEFINE('_WRITTEN_BY', ' Написал');
DEFINE('_LAST_UPDATED', 'Последнее обновление');
DEFINE('_BACK','[Назад]');
DEFINE('_LEGEND','История');
DEFINE('_DATE','Дата');
DEFINE('_ORDER_DROPDOWN','Сортировка');
DEFINE('_HEADER_TITLE','Название');
DEFINE('_HEADER_AUTHOR','Автор');
DEFINE('_HEADER_SUBMITTED','Представлен');
DEFINE('_HEADER_HITS','Просмотров');
DEFINE('_E_EDIT','Редактировать');
DEFINE('_E_ADD','Добавить');
DEFINE('_E_WARNUSER','Пожалуйста, нажмите [Сохранить] или [Отмена] для текущей страницы');
DEFINE('_E_WARNTITLE','Материал должен иметь название');
DEFINE('_E_WARNTEXT','Материал должен иметь вводный текст');
DEFINE('_E_WARNCAT','Пожалуйста, выберите категорию');
DEFINE('_E_CONTENT','Материал');
DEFINE('_E_TITLE','Название:');
DEFINE('_E_CATEGORY','Категория:');
DEFINE('_E_INTRO','Вводный текст');
DEFINE('_E_MAIN','Основной текст');
DEFINE('_E_MOSIMAGE','Вставить тэг {mosimage}');
DEFINE('_E_IMAGES','Рисунки');
DEFINE('_E_GALLERY_IMAGES','Галерея рисунков');
DEFINE('_E_CONTENT_IMAGES','Рисунки к тексту');
DEFINE('_E_EDIT_IMAGE','Параметры рисунка');
DEFINE('_E_INSERT','Добавить');
DEFINE('_E_UP','Выше');
DEFINE('_E_DOWN','Ниже');
DEFINE('_E_REMOVE','Удалить');
DEFINE('_E_SOURCE','Название файла:');
DEFINE('_E_ALIGN','Расположение:');
DEFINE('_E_ALT','Текст подписи:');
DEFINE('_E_BORDER','Рамка:');
DEFINE('_E_APPLY','Применить');
DEFINE('_E_PUBLISHING','Публикация');
DEFINE('_E_STATE','Состояние:');
DEFINE('_E_AUTHOR_ALIAS','Псевдоним автора:');
DEFINE('_E_ACCESS_LEVEL','Уровень доступа:');
DEFINE('_E_ORDERING','Порядок:');
DEFINE('_E_START_PUB','Дата начала публикации:');
DEFINE('_E_FINISH_PUB','Дата окончания публикации:');
DEFINE('_E_SHOW_FP','Показывать на главной странице:');
DEFINE('_E_HIDE_TITLE','Скрыть заголовок:');
DEFINE('_E_METADATA','Мета-данные');
DEFINE('_E_M_DESC','Описание:');
DEFINE('_E_M_KEY','Ключевые слова:');
DEFINE('_E_SUBJECT','Тема:');
DEFINE('_E_EXPIRES','Дата истечения:');
DEFINE('_E_VERSION','Версия:');
DEFINE('_E_ABOUT','О статье');
DEFINE('_E_CREATED','Дата создания:');
DEFINE('_E_LAST_MOD','Последнее изменение:');
DEFINE('_E_HITS','Количество просмотров:');
DEFINE('_E_SAVE','Сохранить');
DEFINE('_E_CANCEL','Отмена');
DEFINE('_E_REGISTERED','Только для зарегистрированных пользователей');
DEFINE('_E_ITEM_INFO','Информация');
DEFINE('_E_ITEM_SAVED','Успешно сохранён!');
DEFINE('_ITEM_PREVIOUS','&lt; Пред.');
DEFINE('_ITEM_NEXT','След. &gt;');
DEFINE('_E_CAPTION','Заголовок');

/** content.php */
DEFINE('_SECTION_ARCHIVE_EMPTY','В настоящее время архивных записей в этом разделе не существует. Попробуйте зайти позже');
DEFINE('_CATEGORY_ARCHIVE_EMPTY','В настоящее время архивных записей в этой категории не существует. Попробуйте зайти позже.');
DEFINE('_HEADER_SECTION_ARCHIVE','Архив разделов');
DEFINE('_HEADER_CATEGORY_ARCHIVE','Архив категорий');
DEFINE('_ARCHIVE_SEARCH_FAILURE','Не найдено архивных записей для %s %s');	// значения: месяц, потом год
DEFINE('_ARCHIVE_SEARCH_SUCCESS','Найдены архивные записи для %s %s');	// месяц, потом год
DEFINE('_FILTER','Фильтр');
DEFINE('_ORDER_DROPDOWN_DA','Дата - по возрастанию');
DEFINE('_ORDER_DROPDOWN_DD','Дата - по убыванию');
DEFINE('_ORDER_DROPDOWN_TA','Заголовок по возрастанию');
DEFINE('_ORDER_DROPDOWN_TD','Заголовок по убыванию');
DEFINE('_ORDER_DROPDOWN_HA','Хиты по возрастанию');
DEFINE('_ORDER_DROPDOWN_HD','Хиты по убыванию');
DEFINE('_ORDER_DROPDOWN_AUA','Автор по возрастанию');
DEFINE('_ORDER_DROPDOWN_AUD','Автор по убыванию');
DEFINE('_ORDER_DROPDOWN_O','Сортировка');

/** poll.php */
DEFINE('_ALERT_ENABLED','Cookies должны быть разрешены!');
DEFINE('_ALREADY_VOTE','Вы уже голосовали в этом опросе!');
DEFINE('_NO_SELECTION','Вы не сделали свой выбор, пожалуйста, попробуйте ещё раз');
DEFINE('_THANKS','Спасибо за Ваше участие в опросе!');
DEFINE('_SELECT_POLL','Выберите опрос из списка');

/** classes/html/poll.php */
DEFINE('_JAN','Январь');
DEFINE('_FEB','Февраль');
DEFINE('_MAR','Март');
DEFINE('_APR','Апрель');
DEFINE('_MAY','Май');
DEFINE('_JUN','Июнь');
DEFINE('_JUL','Июль');
DEFINE('_AUG','Август');
DEFINE('_SEP','Сентябрь');
DEFINE('_OCT','Октябрь');
DEFINE('_NOV','Ноябрь');
DEFINE('_DEC','Декабрь');
DEFINE('_POLL_TITLE','Результаты опроса');
DEFINE('_SURVEY_TITLE','Название опроса:');
DEFINE('_NUM_VOTERS','Количество участников:');
DEFINE('_FIRST_VOTE','Первый голос:');
DEFINE('_LAST_VOTE','Последний голос:');
DEFINE('_SEL_POLL','Выберите опрос:');
DEFINE('_NO_RESULTS','Нет данных по выбранному опросу.');

/** registration.php */
DEFINE('_ERROR_PASS','Извините, такой пользователь не найден');
DEFINE('_NEWPASS_MSG','Учетная запись пользователя $checkusername соответствует этому адресу e-mail.\n'
.' Пользователь $mosConfig_live_site сделал запрос на получение нового пароля.\n\n'
.' Ваш новый пароль: $newpass\n\n Если Вы не запрашивали изменение пароля, не переживайте.'
.' Никто, кроме Вас не может видеть это сообщение. Если это сообщение послано ошибочно, просто зайдите '
.' на сайт используя новый пароль и затем измените его на удобный Вам.');
DEFINE('_NEWPASS_SUB','$_sitename :: Новый пароль для - $checkusername');
DEFINE('_NEWPASS_SENT','Новый пароль для пользователя создан и отправлен!');
DEFINE('_REGWARN_NAME','Пожалуйста, введите Ваше настоящее имя.');
DEFINE('_REGWARN_UNAME','Пожалуйста, введите Ваше имя пользователя (логин).');
DEFINE('_REGWARN_MAIL','Пожалуйста, введите правильно адрес e-mail.');
DEFINE('_REGWARN_PASS','Пожалуйста, введите правильно пароль. Пароль не должен содержать пробелы, его длина должна быть больше 6 символов и состоять только из цифр (0-9) и английских букв (a-z, A-Z)');
DEFINE('_REGWARN_VPASS1','Пожалуйста, проверьте пароль.');
DEFINE('_REGWARN_VPASS2','Пароль и его подтверждение не совпадают, пожалуйста, попробуйте ещё раз.');
DEFINE('_REGWARN_INUSE','Это имя пользователя уже используется. Пожалуйста, выберите другое.');
DEFINE('_REGWARN_EMAIL_INUSE','Этот адрес e-mail уже используется. Пожалуйста, выберите другой.');
DEFINE('_SEND_SUB','Данные о новом пользователе: %s на сайте \'%s\'');
DEFINE('_USEND_MSG_ACTIVATE','Здравствуйте, %s!
Спасибо за регистрацию на сайте \'%s\'. Ваш аккаунт создан, но нуждается в активации, перед тем, как Вы сможете пользоваться всеми его преимуществами.

Чтобы активировать Ваш аккаунт, Вы можете просто кликнуть мышкой на этой ссылке
%s

После активации Вы можете войти на сайт \'%s\', используя следующие данные:
Логин - %s
Пароль - %s
На это письмо не надо отвечать, так как оно создано автоматически и предназначено только для уведомления.

----------------
С уважением,
Привратник.');

DEFINE('_USEND_MSG', "Здравствуйте, %s,
Спасибо за регистрацию на сайте \'%s\'.
Теперь Вы можете войти на сайт \'%s\', используя введенные Вами ранее данные");

DEFINE('_USEND_MSG_NOPASS','Здравствуйте $name,\n\nВы были добавлены как пользователь на $mosConfig_live_site.\n'
.'Вы можете теперь зайти на $mosConfig_live_site с именем и паролем, указанными Вами при регистрации.\n\n'
.'Пожалуйста не отвечайте на это письмо т.к. оно сгенерировано автоматически только для вашего уведомления.\n');

DEFINE('_ASEND_MSG','Здравствуйте, Админ сайта \'%s\'!

Новый пользователь зарегистрировался на Вашем сайте -  \'%s\'.

Это письмо содержит данные о пользователе:
Настоящее имя - %s
e-mail - %s
Логин - %s

На это письмо не надо отвечать, так как оно создано автоматически и предназначено только для уведомления.

----------------
С уважением,
Привратник Вашего сайта.');

DEFINE('_REG_COMPLETE_NOPASS','<div class="componentheading">Registration Complete!</div><br />&nbsp;&nbsp;'
.'You may now login.<br />&nbsp;&nbsp;');
DEFINE('_REG_COMPLETE', '<div class="componentheading">Регистрация завершена!</div><br />Теперь Вы можете войти на сайт, как пользователь.');
DEFINE('_REG_COMPLETE_ACTIVATE', '<div class="componentheading">Регистрация завершена!</div><br />Ваш аккаунт создан и на указанный Вами e-mail отправлена инструкция по активации нового аккаунта. <br /> Ничего сложного, - в письме ссылка, по которой Вам просто нужно перейти.');
DEFINE('_REG_ACTIVATE_COMPLETE', '<div class="componentheading">Активация завершена!</div><br />Ваш аккаунт был успешно активирован.<br />Теперь Вы можете войти на сайт, используя указанные Вами логин и пароль.');
DEFINE('_REG_ACTIVATE_NOT_FOUND', '<div class="componentheading">Неправильная ссылка для активации!!!</div><br />Указанный аккаунт не зарегистрирован или активация данного аккаунта уже произведена.');

/** classes/html/registration.php */
DEFINE('_PROMPT_PASSWORD','Забыли пароль?');
DEFINE('_NEW_PASS_DESC','Пожалуйста, введите Ваши имя пользователя (логин) и адрес e-mail, затем нажмите кнопку [Отправить пароль].<br />'
.'Вскоре Вы получите Ваш новый пароль по почте. Используйте Ваш новый пароль для входа на сайт.');
DEFINE('_PROMPT_UNAME','Пользователь:');
DEFINE('_PROMPT_EMAIL','Адрес e-mail:');
DEFINE('_BUTTON_SEND_PASS','Отправить пароль');
DEFINE('_REGISTER_TITLE','Регистрация');
DEFINE('_REGISTER_NAME','Ваше Имя:');
DEFINE('_REGISTER_UNAME','Логин:');
DEFINE('_REGISTER_EMAIL','e-mail:');
DEFINE('_REGISTER_PASS','Пароль:');
DEFINE('_REGISTER_VPASS','Подтверждение пароля:');
DEFINE('_REGISTER_REQUIRED','Поля со звездочкой (*) обязательны к заполнению.');
DEFINE('_BUTTON_SEND_REG','Зарегистрироваться');
DEFINE('_SENDING_PASSWORD','Ваш пароль будет отправлен на указанный выше адрес e-mail.<br />Когда Вы получите пароль,'
.' Вы сможете зайти на сайт и изменить этот пароль в любой момент.');

/** classes/html/search.php */
DEFINE('_SEARCH_TITLE','Поиск');
DEFINE('_PROMPT_KEYWORD','Поиск по ключевой фразе');
DEFINE('_SEARCH_MATCHES','вернул %d совпадений');
DEFINE('_CONCLUSION','Всего найдено $totalRows материалов. Найти <b>$searchword</b> с помощью ');
DEFINE('_NOKEYWORD','Ничего не найдено');
DEFINE('_IGNOREKEYWORD','В поиске были пропущены предлоги');
DEFINE('_SEARCH_ANYWORDS','Любые слова');
DEFINE('_SEARCH_ALLWORDS','Все слова');
DEFINE('_SEARCH_PHRASE','Точное совпадение');
DEFINE('_SEARCH_NEWEST','Новые - первые');
DEFINE('_SEARCH_OLDEST','Старые - первые');
DEFINE('_SEARCH_POPULAR','Популярные');
DEFINE('_SEARCH_ALPHABETICAL','По алфавиту');
DEFINE('_SEARCH_CATEGORY','Секции/Категории');

/** templates/*.php */
DEFINE('_ISO','charset=Windows-1251');
DEFINE('_DATE_FORMAT','d-m-Y');  //Uses PHP's DATE Command Format - Depreciated
/**
* Modify this line to reflect how you want the date to appear in your site
*
*e.g. DEFINE("_DATE_FORMAT_LC","%A, %d %B %Y %H:%M"); //Uses PHP's strftime Command Format
*/
DEFINE('_DATE_FORMAT_LC',"%d-%m-%Y"); //Uses PHP's strftime Command Format
DEFINE('_DATE_FORMAT_LC2'," %d-%m-%Y %H:%M");
DEFINE('_SEARCH_BOX','поиск...');
DEFINE('_NEWSFLASH_BOX','Объявление!');
DEFINE('_MAINMENU_BOX','Главное меню');

/** classes/html/usermenu.php */
DEFINE('_UMENU_TITLE','Меню пользователя');
DEFINE('_HI','Здравствуйте, ');

/** user.php */
DEFINE('_SAVE_ERR','Пожалуйста, заполните все поля.');
DEFINE('_THANK_SUB','Спасибо за Ваш материал. Теперь материал будет просмотрен \n администратором перед размещением на сайте.');
DEFINE('_UP_SIZE','Вы не можете загружать файлы размером больше чем 15Кб.');
DEFINE('_UP_EXISTS','Рисунок с именем $userfile_name уже существует. Пожалуйста, измените название файла и попробуйте ещё раз.');
DEFINE('_UP_COPY_FAIL','Ошибка при копировании');
DEFINE('_UP_TYPE_WARN','Вы можете загружать только изображения в формате gif или jpg.');
DEFINE('_MAIL_SUB','Новый материал от пользователя');
DEFINE('_MAIL_MSG','Здравствуйте $adminName,\n\nНовый материал в раздел $type с названием $title представил $author'
.' для сайта $mosConfig_live_site.\n'
.'Пожалуйста, зайдите в панель администратора $mosConfig_live_site для просмотра и добавления его в $type.\n\n'
.'На это письмо не надо отвечать, так как оно создано автоматически и предназначено только для уведомления\n\n

----------------
С уважением,
Привратник Вашего сайта.');
DEFINE('_PASS_VERR1','Если Вы желаете изменить пароль, пожалуйста, введите его ещё раз для подтверждения изменений.');
DEFINE('_PASS_VERR2','Если Вы решили изменить пароль, пожалуйста, обратите внимание, что пароль и его подтверждение должны совпадать.');
DEFINE('_UNAME_INUSE','Пользователь с таким имненем уже есть.');
DEFINE('_UPDATE','Обновить');
DEFINE('_USER_DETAILS_SAVE','Ваши данные сохранены.');
DEFINE('_USER_LOGIN','Вход пользователя');

/** components/com_user */
DEFINE('_EDIT_TITLE','Личные данные');
DEFINE('_YOUR_NAME','Настоящее имя:');
DEFINE('_EMAIL','Адрес e-mail:');
DEFINE('_UNAME','Имя пользователя (логин):');
DEFINE('_PASS','Пароль:');
DEFINE('_VPASS','Подтверждение пароля:');
DEFINE('_SUBMIT_SUCCESS','Ваш материал принят!');
DEFINE('_SUBMIT_SUCCESS_DESC','Ваша информация успешно отправлена администратору. После просмотра, Ваш материал будет опубликован на этом сайте');
DEFINE('_WELCOME','Добро пожаловать!');
DEFINE('_WELCOME_DESC','Добро пожаловать в Ваш личный раздел нашего сайта');
DEFINE('_CONF_CHECKED_IN','Все \'не проверенные\' элементы теперь имеют статус \'проверенные\'.');
DEFINE('_CHECK_TABLE','Проверка таблицы');
DEFINE('_CHECKED_IN','Проверено ');
DEFINE('_CHECKED_IN_ITEMS',' элементы');
DEFINE('_PASS_MATCH','Пароли не совпадают');

/** components/com_banners */
DEFINE('_BNR_CLIENT_NAME','Введите имя для клиента.');
DEFINE('_BNR_CONTACT','Выберите контактное лицо для этого клиента.');
DEFINE('_BNR_VALID_EMAIL','Введите реальный e-mail для клиента.');
DEFINE('_BNR_CLIENT','Вы должны выбрать клиента,');
DEFINE('_BNR_NAME','Присвойте этому баннеру имя.');
DEFINE('_BNR_IMAGE','Выберите графический файл для этого баннера.');
DEFINE('_BNR_URL','Введите URL или код для этого баннера.');

/** components/com_login */
DEFINE('_ALREADY_LOGIN','Вы уже авторизированы!');
DEFINE('_LOGOUT','Нажмите здесь для завершения работы');
DEFINE('_LOGIN_TEXT','Используйте поля Пользователь и Пароль для доступа к сайту');
DEFINE('_LOGIN_SUCCESS','Привратник узнал Вас! Вы успешно вошли на сайт, как пользователь.');
DEFINE('_LOGOUT_SUCCESS','Вы вышли. До свидания!');
DEFINE('_LOGIN_DESCRIPTION','Для получения доступа к закрытым разделам сайта, пожалуйста, авторизуйтесь/зарегистрируйтесь.');
DEFINE('_LOGOUT_DESCRIPTION','Вам открыт доступ на закрытые разделы сайта');


/** components/com_weblinks */
DEFINE('_WEBLINKS_TITLE','Ссылки');
DEFINE('_WEBLINKS_DESC','В данном разделе собраны наиболее интересные и полезные ссылки в сети.'
.' <br />Выберите из списка ниже один из разделов, затем выберите нужную ссылку.');
DEFINE('_HEADER_TITLE_WEBLINKS','Ссылка');
DEFINE('_SECTION','Раздел:');
DEFINE('_SUBMIT_LINK','Отправить ссылку');
DEFINE('_URL','URL:');
DEFINE('_URL_DESC','Описание:');
DEFINE('_NAME','Имя:');
DEFINE('_WEBLINK_EXIST','Веб-ссылка с таким именем уже существует. Измените имя и попробуйте ещё раз.');
DEFINE('_WEBLINK_TITLE','Веб-ссылка должна иметь название.');

/** components/com_newfeeds */
DEFINE('_FEED_NAME','Новостная лента');
DEFINE('_FEED_ARTICLES','Кол-во статей');
DEFINE('_FEED_LINK','Ссылка на ленту');

/** whos_online.php */
DEFINE('_WE_HAVE', 'Сейчас на сайте:<br />');
DEFINE('_AND', ' и ');
DEFINE('_GUEST_COUNT','Гостей - $guest_array<br />');
DEFINE('_GUESTS_COUNT','Гостей - $guest_array<br />');
DEFINE('_MEMBER_COUNT','пользователей - $user_array');
DEFINE('_MEMBERS_COUNT','пользователей - $user_array');
DEFINE('_ONLINE',' ');
DEFINE('_NONE','Посетителей нет.');

/** modules/mod_stats.php */
DEFINE('_TIME_STAT','Время');
DEFINE('_MEMBERS_STAT','Участников');
DEFINE('_HITS_STAT','Посетителей');
DEFINE('_NEWS_STAT','Новостей');
DEFINE('_LINKS_STAT','Ссылок');
DEFINE('_VISITORS','посетителей');

/** /adminstrator/components/com_menus/admin.menus.html.php */
DEFINE('_MAINMENU_HOME','* 1-я  публикация в этом меню [mainmenu] - страница по умолчанию `Homepage` для сайта *');
DEFINE('_MAINMENU_DEL','* Вы не можете удалить это меню т.к. оно требуется для корректной работы сайта *');
DEFINE('_MENU_GROUP','* Некотрые `Menu Types` appear in more than one group *');


/** administrators/components/com_users */
DEFINE('_NEW_USER_MESSAGE_SUBJECT', 'Подробности о новом пользователе' );
DEFINE('_NEW_USER_MESSAGE', 'Здравствуйте, %s,

Вы были добавлены как пользователь на сайт %s Администратором.
Ниже - Ваши пользовательские данные для входа на %s:

Логин - %s
Пароль - %s (Можно изменить в "Личных настройках")

На это письмо не нужно отвечать. Оно сгенерированно автоматически и послано Вам только для уведомления.

----------------
С уважением,
Привратник сайта.');


/** administrators/components/com_massmail */
DEFINE('_MASSMAIL_MESSAGE', "Письмо с сайта '%s'

Сообщение:
" );

?>
