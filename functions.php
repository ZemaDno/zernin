<?php
    // Подключение к БД
    $servername = "localhost"; 
    $username = "site1"; 
    $password = "site1"; 
    $dbname = "site1"; 

    $conn = mysqli_connect($servername, $username, $password, $dbname); 
    
    if (!$conn) { 
        die("Connection Failed: " . mysqli_connect_error()); 
    } 
    
    // Получение данных из формы 
    $name = $_POST["name"]; 
    $email = $_POST["email"]; 
    $message = $_POST["message"]; 
    
    // ПРАВИЛЬНОЕ использование подготовленного выражения
    $sql = "INSERT INTO post (name, email, message) VALUES (?, ?, ?)"; 
    $stmt = mysqli_prepare($conn, $sql); 
    
    // Проверка подготовки запроса
    if (!$stmt) {
        die("Ошибка подготовки запроса: " . mysqli_error($conn));
    }
    
    // Привязка параметров
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);
    
    // Выполнение запроса 
    if (mysqli_stmt_execute($stmt)) { 
        echo "Данные успешно добавлены в базу данных!"; 
    } else { 
        echo "Ошибка при добавлении данных: " . mysqli_stmt_error($stmt); 
    } 
    
    // Закрытие ресурсов
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
    // header('Location: index.html');
    // exit;
?>