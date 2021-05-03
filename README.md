# Social Network

####  _Социальная сеть на минималках с простыми возможностями_

Возможности:

:white_check_mark: Оставлять сообщения на стене пользователей

:white_check_mark: Выбирать аватар и устанавливать статус

:white_check_mark: Добавлять в друзья 

____
# _Развертывание через Docker:_
## Подстройка параметров
1) Файл `docker-compose.yml`:

Небходимо поменять путь до каталога (_app_) приложения _website_ на путь до каталога на вашем _компьютере_ (не контейнере !):
```sh
website: \
volumes: \
 - /путь/до/вашего/каталога/(app)/:/var/www/html
```
    
## Создать БД из dump файла, расположенного на рабочей машине
1) Создаем образ, если он не создан:
        
```shell
sudo docker-compose build --no-cache
```
2) Запускаем образ:

```
sudo docker-compose up
```
3) Ждем пока запустится и настроится контейнер с mysql (~30 сек) 
4) Из другого окна shell копируем sql дамп:
    * Копируем sql дамп с каталога компьютера в docker
    * Запускаем его в контейнере
    *  Обратите внимание на перенос команды ("\\")
    ```sh
    sudo cat /путь/до/дампа.sql |\
    sudo docker exec -i mysql-server-5.7 /usr/bin/mysql \
    -usocial_user -psocial_pass social_network_db
    ```
    Мой пример:
        
```
sudo cat /home/kali/projects/social_network/setup.sql | sudo docker exec -i mysql-server-5.7 /usr/bin/mysql -usocial_user -psocial_pass social_network_db
```
        
## Примечание к запуску
1) Файл `app/function.php`

Подключение PHP к MYSQL осуществляется по имени контейнера:
     ```sh
    $dbhost = 'mysql-server-5.7';
     ```
    Если контейнер не работает должным образом, то проблема может заключаться в неправильном функционировании DNS, тогда `альтернативным вариантом имени MYSQL` хоста будет указание его `IP` к примеру:
    ```sh
    $dbhost = '172.21.0.2';
     ```
    Узнать точный IP MYSQL можно через `shell` команду:
    ```sh
    sudo docker inspect mysql-server-5.7 | grep IPAddress
     ```
     (_Стоит учесть, что команду нужно запускать после запуска контейнера_)
     
## Зайти в контейнер
1) Зайти в контейнер:
```sh
sudo docker exec -it mysql-server-5.7 bash -l 
```
