<?php

// Контролер, который полностью управляет заказом и тикетом

class OrderTicket {

    private $eventId;
    private $eventDate;
    private $ticketAdultPrice;
    private $ticketManager;

    public function __construct(int $eventId, string $eventDate, array $typeAndCountTickets) {
        $this->eventId = $eventId;
        $this->eventDate = $eventDate;
        $this->ticketAdultPrice = $typeAndCountTickets;
        $this->ticketManager = new TicketManager();
    }

    // Считает количество разных типов билетов и возвращает их
    private function countTicketTypes(string $adult, string $youth, string $student, string $discount) : array {
        $counts = [
            'Old' => 0,
            'Yung' => 0,
            'Studens' => 0,
            'Lgota' => 0
        ];
        
        $mapping = [
            $adult => 'Old',
            $youth => 'Yung',
            $student => 'Studens',
            $discount => 'Lgota'
        ];

        foreach ($this->ticketAdultPrice as $item) {
            if (isset($mapping[$item])) {
                $counts[$mapping[$item]]++;
            }
        }

        return $counts;
    }

    // Метод для бронирования заказа
    public function makeOrder(Database $database): void {
        try {
            $this->log('📢 Лог панель');
            $this->checkBarcode();
            $barcodes = $this->generateBarcodes();
            $this->approveOrder();
            $this->ticketManager->purchaseTickets($database, $barcodes);
            $this->log('📈 Запись добавлена в БД');
        } catch (Exception $e) {
            $this->log('🔴 Ошибка: ' . $e->getMessage());
        }
    }

    // Валидация barcord через api-1
    private function checkBarcode(): void {
        $this->log('⚙️ Статус 1-api:');
        $statusBook = Api::bookEndPoint($this->eventId, $this->eventDate, $this->ticketAdultPrice, BarcodeGenerator::generateRandomDigitsString());
        if ($statusBook === "barcode already exists") {
            throw new Exception('barcode already exists');
        }
        $this->log('🟢 OK');
    }

    // Метод для генерации barcode
    private function generateBarcodes(): array {
        $this->log('📇 Генерация barcode');
        $barcodes = [];
        $arrayAllTickets = $this->countTicketTypes('Old', 'Yung', 'Studens', 'Lgota');

        foreach ($arrayAllTickets as $type => $count) {
            for ($i = 0; $i < $count; $i++) {
                $barcode = BarcodeGenerator::generateRandomDigitsString();
                $barcodes[$type][] = $barcode;
                $this->log("📥 Баркод для типа '$type': $barcode");
            }
        }

        return $barcodes;
    }

    // Метод для подтверждения заказа
    private function approveOrder(): void {
        $this->log('⚙️ Статус 2-api:');
        $statusApprove = Api::approveEndPoint(1, '2023-06-15', $this->ticketAdultPrice, 'testtest');
        if ($statusApprove !== "order successfully approved") {
            throw new Exception('order not successfully approved');
        }
        $this->log('🟢 OK');
    }

    // Метод для логирования сообщений
    private function log(string $message): void {
        echo $message . '<br>';
    }
}
