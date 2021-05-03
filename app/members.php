<?php 

		require_once('header.php');

		if (!$loggedin) die();

		echo "<div class='main'>";

		if (isset($_GET['view'])) 
		{
			$view = sanitizeString($_GET['view']);

			if ($view == $user) $name = 'Ваши';
			else 								$name = "$view";
		
			echo "<h3>Ваш профиль</h3>";
			showProfile($view);
			echo "<a class='button' href='messages.php?view=$view'>".
					"Посмотреть сообщения пользователя $name </a><br><br>";
			die('</div></body></html>');
		}

		if (isset($_GET['add'])) 
		{
			$add = sanitizeString($_GET['add']);
			$result = queryMySQL("SELECT * FROM friends WHERE user='$add' AND friend='$user'");

			if (!$result->num_rows) 
					queryMySQL("INSERT INTO friends VALUES ('$add', '$user')");
		}
		elseif (isset($_GET['remove']))
		{
			$remove = sanitizeString($_GET['remove']);
			queryMySQL("DELETE FROM friends WHERE user='$remove' AND friend='$user'");
		}
///////////////////////////////////////////////////////
		$result = queryMySQL("SELECT user FROM members ORDER BY user");
		$num = $result->num_rows;

		echo '<h3>Другие участники</h3><ul>';

		for ($j = 0; $j < $num; ++$j)
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
			if ($row['user'] == $user) continue;

			echo 	"<li><a href='members.php?view=".
					 	$row['user']. "'>" .$row['user']."</a>";
			$follow = "follow"; // Проявить заинтересованность в дружбе

			$result1 	= queryMySQL("SELECT * FROM friends WHERE user='" . $row['user'] ."' AND friend='$user'");
			$t1				= $result1->num_rows;
			$result1 	= queryMySQL("SELECT * FROM friends WHERE user='$user' AND friend='". $row['user']."'");
			$t2				= $result1->num_rows;

			if (($t1+$t2) > 1) 	echo " &harr; Взаимный друг";
			elseif ($t1)				echo " &larr; Вы подписаны";
			elseif ($t2)				{echo " &rarr; Подписан на вас";
													$follow = "recip";}
			
			if (!$t1) echo "[<a href='members.php?add=".   $row['user']. "'>$follow</a>]";
			else 			echo "[<a href='members.php?remove=".$row['user']. "'>drop</a>]";
		}
 ?>

		</ul></div>
	</body>
</html>