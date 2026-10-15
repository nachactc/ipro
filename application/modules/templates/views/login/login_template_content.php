<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>


	<?php
	
	foreach($modules as $index=>$value)
	{
		echo Modules::run($modules[$index]."/".$methods[$index]);
	}
	
	?>
