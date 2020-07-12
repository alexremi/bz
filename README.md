Установка программы для рабты с археологией
========================

Программа предназначена для работы с археологическими артефактами такими как керамические остатки, фарфоровые остатки, керамические остатки покрытые глазурью и фотографии контуров венчика.
Данная программа разрабатывалась в рамках ВКР Антоновой Элиной, Ремигайло Алексеем, Русланом Халиуллиным и Чагиной Полиной

Требования
------------

  * Ubuntu;
  * MySQL;
  * PHP 7.2.9 или новее;
  * Composer;
  * [Symfony][1].

Установка
------------

Клонируем репозиторий
```bash
$  git clone https://github.com/alexremi/bz
$  cd bz/
```
Устанавливаем зависимости
```bash
$ composer install
```
Конфигурируем базу данных
```bash
# (переопределите DATABASE_URL в .env)
# например, DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
$ nano .env
```

Создание таблиц / схемы базы данных
```bash
$ make create-db
$ make migrate
$ make admin
```

Использование
-----
Для запуска приложения не нужно ничего настраивать. Если у вас уже установлен
[Symfony] [1], запустите эту команду:
```bash
$ cd bz/
$ symfony serve
```

Затем зайдите в приложение в вашем браузере по URL (<https://localhost:8000/main> по умолчанию).

Если у вас не установлен Symfony, то выполните комманду `php -S localhost:8000 -t public/`
для использования встроенного PHP веб-сервера или [настройте веб-сервер][2] как Nginx или
Apache для запуска приложения.

Данные для входа в роли администратора: 
* логин: admin 
* пароль: admin

[1]: https://symfony.com/download
[2]: https://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html


