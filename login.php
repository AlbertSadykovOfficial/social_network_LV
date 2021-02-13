<?php 
	require_once('header.php');

	echo "<div class='main'><h3>Пожауйста, введите свои данные</h3>";

	$error = $user = $pass ="";

	if (isset($_POST['user'])) 
	{
	 	$user = strtolower(sanitizeString($_POST['user']));
	 	$pass = sanitizeString($_POST['pass']);

	 	if ($user =='' || $pass == '') 
	 	{
	 		$error = 'Не все поля заполнены<br>';
	 	}
	 	else
	 	{
	 			$result = queryMySQL("SELECT user,pass FROM members WHERE user='$user' AND pass='$pass'");
	
	 			if ($result->num_rows == 0) 
	 			{
	 				$error = "<span class='error'>Username/Password не верны</span> <br><br>";
	 			}
	 			else
	 			{
	 				$_SESSION['user'] = $user;
	 				$_SESSION['pass'] = $pass;
	 				echo 	"Вы вошли.".
	 							"Пожалуйтса <a href='members.php?view=$user'>".
	 							"Нажмите ЗДЕСЬ</a>, чтобы прдолжить.<br><br>";
	 			}
	 	}
	 }

	echo <<<_END
		 <form method='POST' action='login.php'>$error  
		 <span class='fieldname'>Username</span><input type='text' maxlength='16' name='user' value='$user'><br>  
		 <span class='fieldname'>Password</span><input type='password' maxlength='16' name='pass' value='$pass' ><br>
_END;
 ?>

 		<span class = 'fildname'>&nbsp;</span>
 		<input type='submit' value='Login'>
 	</form><br></div>
 </body>
</html>