<?php
	require_once('function.php');

	if (isset($_POST['user'])) 
	{
		$user = sanitizeString($_POST['user']);
		$result = queryMySQL("SELECT * FROM members WHERE user='$user'");

// Если результат поиска содержит хоть что-то значит такое имя уже есть
		if ($result->num_rows) 	
			echo "<span class='taken'>&nbsp;&#x2718; ".
						"Извините, имя уже занято";
		else 
			echo "<span class='available'>&nbsp;&#x2714; ".
					 "Это имя доступно</span>";
	}
 ?>