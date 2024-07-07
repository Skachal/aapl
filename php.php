<?php
// Проверяем, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем сырые данные из тела запроса
    $rawData = file_get_contents("php://input");
    // Декодируем JSON-данные
    $data = json_decode($rawData, true);

    if (isset($data["name"]) && isset($data["willbe"])) {
        // Получаем имя и фамилию пользователя и их выбор
        $name = $data["name"];
        $willAttend = ($data["willbe"][1] === "yes") ? true : false;

        // Сохраняем данные в файл, базу данных или другое хранилище
        // В этом примере мы просто добавим данные в текстовый файл
        $dataToSave = "$name, $willAttend\n";
        $file = fopen("rsvp_data.txt", "a"); // Открываем файл для добавления данных
        fwrite($file, $dataToSave); // Записываем данные
        fclose($file); // Закрываем файл

        // Возвращаем пользователю сообщение об успешной отправке формы
        echo json_encode(["status" => "success", "message" => "Данные успешно отправлены!"]);
    } else {
        // Если данные не были отправлены, возвращаем ошибку
        echo json_encode(["status" => "error", "message" => "Ошибка: Не удалось обработать данные формы."]);
    }
} else {
    // Если запрос не был POST, возвращаем ошибку
    echo json_encode(["status" => "error", "message" => "Ошибка: Недопустимый метод запроса."]);
}
?>
