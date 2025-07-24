<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Обратная связь</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <ul>
                    <li><a href="index.html">Первый компьютер</a></li>
                    <li><a href="supercomputers.html">Суперкомпьютеры</a></li>
                    <li><a href="modern.html">Современные ПК</a></li>
                    <li><a href="forma1.php">Обратная связь</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="formm">
            <div class="formmO">
                <h2><i>ОБРАТНАЯ СВЯЗЬ:</i></h2>
                <form name="form1" method="post" action="forma1.php">
                    <p> Имя: <input type="text" name="name" required></p>
                    <p> Ваш Email: <input type="email" name="email" required></p>
                    <p> Сообщение: <textarea name="message" required></textarea></p>
                    <p><input class="button_ent" type="submit" name="send" value="Отправить"></p>
                </form>
            </div>
            
            <div class="formmT">
                <h2><i>СООБЩЕНИЯ:</i></h2>
                <?php
                // Подключение к базе данных
                $servername = "localhost";
                $username = "site1";
                $password = "site1";
                $dbname = "site1";
                
                $conn = new mysqli($servername, $username, $password, $dbname);
                
                if ($conn->connect_error) {
                    die("Ошибка подключения: " . $conn->connect_error);
                }
                
                // Обработка формы
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name = $conn->real_escape_string($_POST['name']);
                    $email = $conn->real_escape_string($_POST['email']);
                    $message = $conn->real_escape_string($_POST['message']);
                    
                    $sql = "INSERT INTO feedback (name, email, message) 
                            VALUES ('$name', '$email', '$message')";
                    
                    if ($conn->query($sql)) {
                        echo "<p class='success'>Сообщение отправлено!</p>";
                    } else {
                        echo "<p class='error'>Ошибка: " . $conn->error . "</p>";
                    }
                }
                
                // Вывод сообщений
                $sql = "SELECT name, email, message, created_at 
                        FROM feedback 
                        ORDER BY created_at DESC 
                        LIMIT 10";
                
                $result = $conn->query($sql);
                
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='feedback-item'>";
                        echo "<p><strong>Имя:</strong> " . htmlspecialchars($row['name']) . "</p>";
                        echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
                        echo "<p><strong>Сообщение:</strong> " . nl2br(htmlspecialchars($row['message'])) . "</p>";
                        echo "<p><small>" . $row['created_at'] . "</small></p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Пока нет сообщений</p>";
                }
                
                $conn->close();
                ?>
            </div>
        </div>
    </main>
</body>
</html>