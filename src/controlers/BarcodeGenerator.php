<?php

class BarcodeGenerator {
    public static function generateRandomDigitsString() : string {
        $result = ''; // результат
        $a = 0; // числовая переменная

        while (strlen($result) < 13) { // продолжаем, пока длина результата меньше 13
            $a++;

            // Генерируем случайное число от 0 до 9
            $randomNumber = rand(0, 9);

            // Если "a" равно 9, 14, 19 или 24, добавляем дефис
            if (in_array($a, [9, 14, 19, 24])) {
                $result .= '-'; // добавляем '-'
            } else {
                $result .= $randomNumber; // добавляем случайное число
            }
        }
        return $result;
    }
}
