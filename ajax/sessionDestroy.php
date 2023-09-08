<?php
	// Если в POST нет данных
	if(!$_POST['destroy']) 
		return;

	session_destroy();
?>