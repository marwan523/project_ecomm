<?php
	
	function langs ($phrase){

		static $lang = array(
			//dasdboard page
			'HOME_ADMIN' 	=> 'Home',
			'CATEGORIES' 	=> 'Categories',
			'ITEMS' 		=> 'items',
			'MEMBERS' 		=> 'Members',
			'COMMENTS' 		=> 'Comments',
			'STATISCICS' 	=> 'Statistics',
			'LOGS' 			=> 'Logs',

		 );
		return $lang[$phrase];
	}	

?>