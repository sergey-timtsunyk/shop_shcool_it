Symfony Standard Edition
========================

Устанавливаем [Symfony 3.4][1], используем composer, указываем версию "3.4".
 
Для работы с пользователями подключаем [FOSUserBundle][2]. Для упращение 
работы с записями о пользователе можно использовать [команды][3]. Подменяем при 
необходимости [шаблоны][4].

Добавляем необходимые сущности в коде:

`php bin/console doctrine:generate:entity`

К сущностям добвяем связи: [mapping][5]

Обновляем базу данных:

`php bin/console doctrine:schema:update --force`

Следующим шагом настраиваем админку.

Создаем AdminBundle и добавляем настройки для сервиса: [extension][6]

Устанавливаем [SonataAdminBundle][7] и [SonataDoctrineORMAdminBundle][8]

Следующей командой продключаем наши сущности в админку:

`php bin/console sonata:admin:generate`

Детально о настройках и возможностях [SonataAdminBundle-doc][9]


[1]:  https://symfony.com/doc/3.4/setup.html
[2]:  https://symfony.com/doc/master/bundles/FOSUserBundle/index.htm
[3]:  https://symfony.com/doc/master/bundles/FOSUserBundle/command_line_tools.html
[4]:  https://symfony.com/doc/master/bundles/FOSUserBundle/overriding_templates.html
[5]:  https://www.doctrine-project.org/projects/doctrine-orm/en/2.5/reference/association-mapping.html
[6]: https://symfony.com/doc/current/bundles/extension.html
[7]: https://symfony.com/doc/master/bundles/SonataAdminBundle/getting_started/installation.html
[8]: https://sonata-project.org/bundles/doctrine-orm-admin/master/doc/reference/installation.html
[9]: https://sonata-project.org/bundles/admin/3-x/doc/index.html
