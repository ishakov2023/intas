# intas

Установка:
1.Запустите docker-compose up -d;
2.Запустите docker ps,выберете с колонки 'CONTAINER ID' image 'mysql:8.0';
3.Запустите команду docker cp src/table/create_tables.sql "скопированный ID из прошлого пункта":/create_tables.sql, для подрузке файла в контейнер mysql;
4.Запустите команду docker exec -it "скопированный ID из прошлого пункта" bash, чтобы перейти в терминал mysql;
5.В bash пропишите mysql -u user -p intas </create_tables.sql для подгрузки БД таблиц;
6.Перейдите по ссылке http://localhost:8000/ScriptRandom/RandomCouriersAndRegions.php чтобы добавить курьеров(10) и регионы(10);
7.Перейдите по ссылке http://localhost:8000/ScriptRandom/RandomTrips.php если надо добавить поездки на 3 месяца;
8.Перейдите по ссылке http://localhost:8000 , чтобы заполнить форму для назначения поездки;

