# Ticket service
Тестовое задание.

# Getting Started
1. Если нет, то https://docs.docker.com/compose/install/
2. Запустить `docker compose build --no-cache` для билда свежего образа
3. `docker exec -i ticket-service-mysql-1 mysql -u my_user -puser_password my_database < backup.sql
ticket-service-mysql-1`
4. Открыть `https://localhost` в браузере
5. 

# Вопросы при разработке
Как я понимаю, что сторонние API сначала валидирует barcode, т.е. проверяют его на уникальность, а потом второй endpoint это уже проверка на наличие билетов и т.д. Т.е, получается сторонний сервис знает об стоиомости билетов и ему лишь нужны данные для проверки уникальности кода и проверки наличие билетов на определенные ивенты. 
Еще по причине того, что это так сказать частичка функицонала теряется понимание этих логических моментов. Буду тогда считать, что сторонние API о ценах на билеты, расписание программ, которые хранятся у меня в БД и просто передавать тогда barcode на валидацию и проверку на наличие билетов/мест/ивентов и т.д.

# Пробелмы разработки
Из-за того, что это частичка фунционала очень сильно хотелось полностью сделать весь фукционал сервиса и реализовать фронт XD Но следую здравому смыслу и не затягиваю реализацию.
