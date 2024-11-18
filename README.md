# Ticket service
Нативное приложение PHP с выводом информации через логи в браузер. 

# Getting Started
1. Если нет, то [Установить Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Запустить `docker compose build --no-cache` для билда свежего образа
3. Импорт данных `docker exec -i ticket-service-mysql-1 mysql -u my_user -puser_password my_database < backup.sql
ticket-service-mysql-1`
4. Открыть `https://localhost` в браузере // `https://localhost:8080` - Для phpMyAdmin

# DOCS
1. [Логика-Приложения](https://github.com/1nnuser/ticket-service/wiki/Логика-Приложения)
2. [Визуализация-Таблиц](https://github.com/1nnuser/ticket-service/wiki/Визулизация-таблиц)
3. [OrderTiket class](https://github.com/1nnuser/ticket-service/wiki/OrderTiket-class)
4. [OrderTiket-class](https://github.com/1nnuser/ticket-service/wiki/TicketManager-class)

# Вопросы при разработке
Как я понимаю, сторонние API сначала валидируют штрих-код (barcode), т.е. проверяют его на уникальность, а затем второй endpoint — это уже проверка на наличие билетов и т.д. Получается, что сторонний сервис знает о стоимости билетов, и ему лишь нужны данные для проверки уникальности кода и наличия билетов на определенные события.

Еще по причине того, что часть функционала теряется, возникает непонимание этих логических моментов. Буду считать, что сторонние API знают о ценах на билеты и расписании программ, которые хранятся у меня в БД, и просто передавать тогда штрих-код на валидацию и проверку на наличие билетов/мест/событий и т.д.

# Проблемы разработки
Из-за того, что это частичка фунционала очень сильно хотелось полностью сделать весь фукционал сервиса и реализовать фронт XD Но следую здравому смыслу и не затягиваю реализацию.
