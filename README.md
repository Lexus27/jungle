Jungle PHP Framework(JF)
========================
v0.1.4

Фреймворк обязан доступно обеспечить разработчика всеми возможностями при проектировании целевого _WEB приложения_ с пользовательским интерфейсом.

Фреймворк в первую очередь разрабатывается с целью максимально эффективно использовать возможности технологий и парадигм программирования, для решения задач связанных с формированием программ с пользовательским интерфейсом, благодаря централизованному стилю абстрагирования.

Для **Jungle** характерен максимально централизованный стиль проектирования и абстрагирования, это означает что, один интерфейс  может использоваться несколькими компонентами, так как при проектировании некоторых разных по специфике компонентов, мы наталкиваемся на мысль об использовании одного общего интерфейса для конкретного узла. Интерфейсная часть должна проектироваться достаточно ответственно с точки зрения сфер реализации и будущего применения данного интерфейса. 
>Как пример, два слова: **Запрос** и **Ответ** в контексте **_Коммуникаций_** между хостами. 
По данному примеру разрабатываются принимающие (**Сервер**) и отправляющие (**Клиенты**) компоненты 
Например: 
`\Jungle\Http\` _Принимающий запросы_.
`\Jungle\Util\Communication\Http` _Отправка HTTP запросов внешниим онлайн сервисам в т.ч использование удаленного rest api_.

## Object Relational Model (ORM)

Из конкретных решений в данный момент также представлена объектно реляционная модель, которая проектируется с упором на больший спектр типов источников с прозрачным связыванием записей с разными источниками между собой, аналогично ForeignKey в базах данных. 
В список особенностей также входит возможность создать динамическую связь (**Relation**) , когда при обычном связывании «таблиц» мы указываем название внешней «таблицы» в определение метаданных поля, здесь же информация о внешней «таблице», указывается в определенном поле записи. 
Благодаря этому при работе с ORM, разработчик может получить возможность удобно внедрять EAV-подобную архитектуру в бизнес логику приложения, достаточно безопаснее для целостности данных, чем в самописных вариантах работы с EAV. 

## Module Controller Action (MCA)

Система скелета приложения, имеет ряд целей для обеспечения удобства разработчика, этот субъект является самым важным в проектировании проложения


## Немного пред-истории

До того как началась разработка, были практики с другими аналогами и инструментами. В результате получения идей по усовершенствованию инфраструктуры проектов, а так же их фундаментальной части – были сделанные выводы собрать с нуля работающий по отличающимся принципам будущий Фреймворк, так как реализация задуманных идей не представляется совместимой с Фреймворками находящимися в ассортименте на рынке Open-Source проектов на тот момент. Например, было решено использовать ORM для смешанных типов хранилищ, не ограни-чивая модель объектами только из Базы Данных, это позволит работать с любыми данными как с объектами по общим ORM стандартам, не думая о низкоуровневых операциях с тем или иным типом хранилища, даже с файловой системой. Используя данный прием можно надеяться на обобщенность стиля представления данных (View) реализовав Model-Presenter для любой модели.

Другие компоненты также решено было написать с нуля, т.к. считается, что их можно спроектировать по одним общим стандартам фреймворка, возможно с более мощным функционалом.



# Используй прямо сейчас

#### Установка

###### Git

    git clone https://github.com/Lexus27/Jungle.git

###### Composer

    composer require lexus27/jungle
    
## Структура файловой системы WEB-Сервера
Структура файловой системы может быть индивидуальна, но базовой для начала работы можно считать следующую

    /core
        /App
            /_cache (reserved! for application auto generate)
            /_log (reserved! for application auto generate)
            /Model
            /Modules
            /Services
            /Strategies
            /Views
            Application.php
        /Jungle (Примерное расположение фреймворка)
    /public_html
        /assets (custom use)
        /index.php
        /.htaccess - (if apache webserver used)
        
* **`/core`** 
    Папка для хранения источников: приложений(/App), библиотек и фреймворка(/Jungle)


* **`/core/App/`**
    Служебная папка приложения (Совместима с Namespace PSR-4 и Автозагрузкой)


* **`/core/App/_log/`**
    Автогенерируемая папка зарезервированая под системные логи 


* **`/core/App/_cache/`**
    Автогенерируемая папка зарезервированая под всяческий файловый кеш


* **`/core/App/Model/`**
    Зарезервированая папка для моделей ORM, модели могут быть определены в пространстве имен `namespace App/Model`, поэтому название папки не имеет технического значения и носит только смысловой характер


* **`/core/App/Modules/`**
    Папка под организацию структуры Контроллеров приложения
    
    
* **`/core/App/Services/`**
    Зарезервированая папка для Переопределенных или индивидуальных компонентов JF, используемых в приложении (Носит смысловой характер)
    
    
* **`/core/App/Strategies/`**
    Папка под стратегии запроса, в ней хранятся стратегии в виде классов с названием самой стратегии.
    
    
* **`/core/App/Application.php`**
    Класс скелет приложения, в нем могут быть переопределены служебные относительные пути например (`Strategies` или `Modules`)

* **`/core/Jungle`**
    Примерное расположение фреймворка (_Далее примеры кода будут опираться на это расположение_)

* **`/public_html`**
    Корень веб сервера, здесь хранятся файлы которые доступны публично. в том числе Точка входа в приложение
    
    
* **`/public_html/index.php`**
    Точка входа в приложение, ни что от этого файла не зависит, в нем осуществляется подключение Автозагрузчика и Приложения



## Точка входа (/public_html/index.php)

> Традиционно Для работы ЧПУ, Web-Сервер должен поддерживать Перенаправление (mod_rewrite) 
    
    
    <?php
    //use absolute path
    
    
    /** 
     * 0. Optional defines contsants for comfort 
     * -----------------------------------------
     */
    
    // similarly realpath('../../core/Jungle/Jungle')
    !defined('JUNGLE_DIRNAME') && 
        define('JUNGLE_DIRNAME', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTROY_SEPARATOR . 'Jungle' . DIRECTORY_SEPARATOR . 'Jungle');
    
    // similarly realpath('../../core/App')
    !defined('APP_DIRNAME') && 
        define('APP_DIRNAME', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'App');
    
    /** 
     * 1. Include loader file
     * ----------------------
     */
     
    include JUNGLE_DIRNAME . DIRECTORY_SEPARATOR . 'Loader.php';
    
    /** 
     * 2. Autoloader registers namespaces Jungle/ and your App/ 
     * --------------------------------------------------------
     */
      
    $loader = \Jungle\Loader::getDefault();
    $loader->registerNamespaces([
    	'Jungle'    => JUNGLE_DIRNAME,
    	'App'       => APP_DIRNAME
    ]);
    $loader->register();
    
    /** 
     * 3. Application instantiate and run
     */
     
    $app = new \App\Application($loader);
    $response = $app->handle(\Jungle\Http\Request::getInstance());
    $response->send(); // fully auto send output
    
