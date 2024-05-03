<?php
    require_once "db_connect.php";
    require_once "mail_client_connect.php";

    function transliterate($text) {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
            
            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        );
        return strtr($text, $converter);
    }
    
    function generateLogin($firstName, $lastName) {
        // Приводим имя и фамилию к нижнему регистру и транслитерируем
        $firstName = transliterate(strtolower($firstName));
        $lastName = transliterate(strtolower($lastName));
        
        // Берем первые две буквы имени
        $firstTwoLettersFirstName = substr($firstName, 0, 1);
        
        // Берем первые пять букв фамилии (если она короче, то берем всю фамилию)
        $firstFiveLettersLastName = substr($lastName, 0, 5);
        
        // Генерируем логин путем объединения первых двух букв имени и первых пяти букв фамилии
        $login = $firstTwoLettersFirstName.$firstFiveLettersLastName;
        
        return $login;
    }
    function generateRandomPassword($length = 8) {
        // Строка символов, из которых будет состоять пароль
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomPassword = '';
    
        // Генерируем случайный пароль
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomPassword;
    }

    $workerName = $_POST['worker_name'];

    $firstName=explode(" ", $workerName)[0];
    $lastName=explode(" ", $workerName)[1];
    $workerLogin = generateLogin($firstName, $lastName);

    $password = generateRandomPassword();
    $workerPassword=md5($password);

    $workerEmail = $_POST['worker_email'];
    $workerWorkshop = $_POST['worker_workshop'];
    $workerHours = $_POST['worker_hours'];

    $body="<p>Логин: ".$workerLogin."</p>
    <p>Почта: ".$workerEmail."</p>
    <p>Пароль: ".$password."</p>";

    $insert_worker=mysqli_query($db, "INSERT INTO `workers` (`id`, `name`, `workshop_id`, `max_hours`, `login`, `email`, `password`) VALUES (NULL, '$workerName', '$workerWorkshop', '$workerHours', '$workerLogin', '$workerEmail', '$workerPassword')");
    var_dump(send_mail($settings['mail_settings'], [$workerEmail], 'Вас зарегистрировали в системе AutoAce!', $body));
?>