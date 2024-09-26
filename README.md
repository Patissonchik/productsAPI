API для управления категориями и продуктами.\
После развертывания и настройки проекта с БД:\
1) Необходимо создать пользователя(http://project_path/api/register), изменить в БД его роль на admin.
2) Получить его access token (http://project_path/api/login).
3) При тестировании включить Authorization, type => Bearer Token, задать полученный по API токен.\

После этого можно тестировать все доступные пути.\
Документация api находится по http://project_path/api/documentation
