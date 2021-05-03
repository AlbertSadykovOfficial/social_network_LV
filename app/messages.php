<?php 

		require_once('header.php');

		if (!$loggedin) die();
		
		if (isset($_GET['view']))	$view = sanitizeString($_GET['view']);
		else 											$view = $user;

		if (isset($_POST['text']))  
		{    
			$text = sanitizeString($_POST['text']);
	    
	    if ($text != "")    
	    {      
	    	$pm   = substr(sanitizeString($_POST['pm']),0,1);      
	    	$time = time();      
	    	queryMySQL("INSERT INTO messages VALUES(NULL, '$user', '$view', '$pm', $time, '$text')");    
	    }
	  }

	    if ($view != "")  
	    {    
	    	if ($view == $user) $name1 = $name2 = "Ваши"; // Ваши    
	    	else 
	    	{      
	    		$name1 = "<a href='members.php?view=$view'>$view</a>'s";      
	    		$name2 = "$view's";    
	    	}

    		echo "<div class='main'><h3>$name1 Сообщения</h3>";
    		showProfile($view);

echo <<<_END
<form method='POST' action='messages.php?view=$view'>
Оставить сообщение:<br>
<textarea name='text' cols='40' rows='3'></textarea><br>    
Public<input type='radio' name='pm' value='0' checked='checked'>	
Private<input type='radio' name='pm' value='1' /> 
<input type='submit' value='Опубликовать'></form><br>  
_END;

			 if (isset($_GET['erase']))    
			 {      
			 	$erase = sanitizeString($_GET['erase']);      
			 	queryMySQL("DELETE FROM messages WHERE id=$erase AND recip='$user'");    
			 }

			  $query  = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC";    
			  $result = queryMySQL($query);  
			  $num    = $result->num_rows;

			  for ($j = 0 ; $j < $num ; ++$j)    
			  {     
			  	$row = $result->fetch_array(MYSQLI_ASSOC);
 					
 					 if ($row[3] == 0 || $row[1] == $user || $row[2] == $user)     // 3
 					 	{       
 					 		echo "<span style='font-size:10px;'>".date('jS M Y \| h:m', ($row['time']+60*60*3))."</span>";// date('M jS \'y g:ia:', $row['time']);
 					 		echo " <a href='messages.php?view=$row[1]'>$row[1]</a> ";
 					 		
 					 		if ($row['pm'] == 0)        
 					 		echo "&quot;".$row['message']."&quot; от ".$row['auth'];
 					 		  //	echo 'wrote: &quot;'.$row['message'].'&quot; <br>'; 
 					 		 else 
 					 		 echo "<span class='whisper'>" . '&quot;'.$row['message'].'&quot;</span>';                  // Прошептал 
  						
  						if ($row['recip'] == $user)           
  							echo "[<a href='messages.php?view=$view&erase=". $row['id']."'>СТЕРЕТЬ</a>]";
 
 							 echo "<br>"; 
 						}
 				}
 		}


 		if (!$num) echo "<br><span class='info'>Нет сообщений</span><br><br>";

 		echo 	"<br><a class='button' href='messages.php?view=$view'>Обновить</a>".
 					"  <a class='button' href='friends.php?view=$view'>Показать друзей $name2</a>";
?>

		</div><br>
	</body>
</html>