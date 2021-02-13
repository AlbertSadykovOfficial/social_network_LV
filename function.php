<?php 
	$dbhost = 'localhost';
	$dbname = 'social_network_db';	// Должна быть создана
	$dbuser = 'albert';
	$dbpass = 'pass';

	$appname = 'social_network'; // Название соц сети


	$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if ($connection->connect_error) die($connection->connect_error);

		function createTable($name, $query)
		{
			queryMySQL("CREATE TABLE IF NOT EXISTS $name($query)");
			echo "Таблица $name создана или уже существала<br>";
		}

		function queryMySQL($query)
		{
			global $connection; // Обращение к подкючению БД вне функции
			$result = $connection->query($query);
			if(!$result) die ($connection->error);

			return $result;
		}

		function destroySession()
		{
			$_SESSION = array();																							// Опустошаем сессию

			if (session_id() != '' || isset($_COOKIE[session_name()])) 
				setcookie(session_name(), '', time()-2592000,'/');								// Просрачиваем cookie

			session_destroy();
		}

		function sanitizeString($var)
		{
			global $connection;

			$var = strip_tags($var);
			$var = htmlentities($var);
			$var = stripslashes($var);

			return $connection->real_escape_string($var);
		}

		function showProfile($user)
		{
			if (file_exists("img/$user.jpg")) 
					echo "<img src = 'img/$user.jpg' align = 'left'>";	
		
			$result = queryMySQL("SELECT * FROM profiles WHERE user = '$user'");

			if ($result->num_rows) 
			{
				$row = $result->fetch_array(MYSQLI_ASSOC);
				echo stripslashes($row['text']).
									"<br style = 'clear : left;'><br>";
			}
		}
	
 ?>