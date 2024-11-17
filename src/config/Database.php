<?php

class Database {
    private $pdo;

    public function __construct($host, $db, $user, $pass) {
        $this->pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    }

    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }

    public function commit() {
        return $this->pdo->commit();
    }

    public function rollBack() {
        return $this->pdo->rollBack();
    }
}



// try {
//     // Начало транзакции
//     $database->beginTransaction();

//     // 1. Получение ID пользователя
//     $stmt = $database->query("SELECT id FROM users WHERE username = :username", ['username' => 'john_doe']);
//     $user_id = $stmt->fetchColumn();
    
//     if ($user_id === false) {
//         // Выводим дополнительные данные для отладки
//         $stmt = $database->query("SELECT username FROM users");
//         $all_users = $stmt->fetchAll(PDO::FETCH_COLUMN);
//         throw new Exception("Пользователь не найден. Доступные пользователи: " . implode(", ", $all_users));
//     }

//     // 2. Получение ID события
//     $stmt = $database->query("SELECT id FROM events WHERE name = :event_name", ['event_name' => 'Концерт группы XYZ']);
//     $event_id = $stmt->fetchColumn();

//     if ($event_id === false) {
//         throw new Exception("Событие не найдено.");
//     }

//     // 3. Вставка взрослого билета
//     $barcode_adult = '012331343у2';
//     $database->query("
//         INSERT INTO tickets (event_id, ticket_price_id, barcode, purchase_date)
//         VALUES (
//             :event_id,
//             (SELECT id FROM ticket_prices WHERE ticket_type_id = (SELECT id FROM type_tickets WHERE type_name = 'взрослый') LIMIT 1),
//             :barcode,
//             NOW()
//         )", ['event_id' => $event_id, 'barcode' => $barcode_adult]);

//     // Получение ID последнего добавленного взрослого билета
//     $adult_ticket_id = $database->lastInsertId();

//     // 4. Вставка детского билета
//     $barcode_child = '34553344534534';
//     $database->query("
//         INSERT INTO tickets (event_id, ticket_price_id, barcode, purchase_date)
//         VALUES (
//             :event_id,
//             (SELECT id FROM ticket_prices WHERE ticket_type_id = (SELECT id FROM type_tickets WHERE type_name = 'детский') LIMIT 1),
//             :barcode,
//             NOW()
//         )", ['event_id' => $event_id, 'barcode' => $barcode_child]);

//     // Получение ID детского билета
//     $child_ticket_id = $database->lastInsertId();

//     // 5. Вставка заказа для взрослого билета
//     $database->query("
//         INSERT INTO orders (ticket_id, user_id, order_date)
//         VALUES (:ticket_id, :user_id, NOW())", ['ticket_id' => $adult_ticket_id, 'user_id' => $user_id]);

//     // Вставка заказа для детского билета
//     $database->query("
//         INSERT INTO orders (ticket_id, user_id, order_date)
//         VALUES (:ticket_id, :user_id, NOW())", ['ticket_id' => $child_ticket_id, 'user_id' => $user_id]);

//     // Фиксация транзакции
//     $database->commit();

//     echo "Билеты успешно куплены!";
// } catch (Exception $e) {
//     // Откат транзакции в случае ошибки
//     $database->rollBack();
//     echo "Ошибка: " . $e->getMessage();
// }

