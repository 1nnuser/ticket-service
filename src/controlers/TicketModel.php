<?

// Вынесеная модель для работы с БД

class TicketManager {
    public function purchaseTickets(Database $database, $array_user) {
        try {
            // Начало транзакции
            $database->beginTransaction();
    
            // Получение ID пользователя
            $stmt = $database->query("SELECT id FROM users WHERE username = :username", ['username' => 'john_doe']);
            $user_id = $stmt->fetchColumn();
            
            if ($user_id === false) {
                $stmt = $database->query("SELECT username FROM users");
                $all_users = $stmt->fetchAll(PDO::FETCH_COLUMN);
                throw new Exception("Пользователь не найден. Доступные пользователи: " . implode(", ", $all_users));
            }
    
            // Получение ID события
            $stmt = $database->query("SELECT id FROM events WHERE name = :event_name", ['event_name' => 'Концерт группы XYZ']);
            $event_id = $stmt->fetchColumn();
    
            if ($event_id === false) {
                throw new Exception("Событие не найдено.");
            }
    
            // Вставка билетов в зависимости от массива $array_user
            foreach ($array_user as $ticket_type => $barcodes) {
                foreach ($barcodes as $barcode) {
                    $ticket_type_name = ($ticket_type === 'Old') ? 'взрослый' : 'детский';

                    // Вставка билета
                    $database->query("
                        INSERT INTO tickets (event_id, ticket_price_id, barcode, purchase_date)
                        VALUES (
                            :event_id,
                            (SELECT id FROM ticket_prices WHERE ticket_type_id = (SELECT id FROM type_tickets WHERE type_name = :ticket_type_name) LIMIT 1),
                            :barcode,
                            NOW()
                        )", [
                            'event_id' => $event_id,
                            'ticket_type_name' => $ticket_type_name,
                            'barcode' => $barcode
                        ]);

                    // Получение ID последнего добавленного билета
                    $ticket_id = $database->lastInsertId();

                    // Вставка заказа для билета
                    $database->query("
                        INSERT INTO orders (ticket_id, user_id, order_date)
                        VALUES (:ticket_id, :user_id, NOW())", ['ticket_id' => $ticket_id, 'user_id' => $user_id]);
                }
            }

            // Фиксация транзакции
            $database->commit();
            echo "🟢 Билеты успешно куплены!";
        } catch (Exception $e) {
            // Откат транзакции в случае ошибки
            $database->rollBack();
            echo "🔴 Ошибка: " . $e->getMessage();
        }
    }
}