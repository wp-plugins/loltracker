(function( $ ) {
	'use strict';
	 $( window ).load(function() {
			$('#lol_tracker_widget_freechampions').html('<center><img src="'+preloaderUrl+'"/> Loading</center>');
					$.ajax({
					url: "wp-admin/admin-ajax.php?action=showFreeChampions",
				}).done(function(championData){
						//console.log(championData);	
						$('#lol_tracker_widget_freechampions').html(championData);									 
					}).fail(function(){
						$('#lol_tracker_widget_freechampions').html('Unable to fetch data!');
						console.log('Unable to fetch data!');
					});
				
				

	 });

})( jQuery );
