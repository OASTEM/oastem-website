var index = 0;

var folders;

$(document).ready(function(e) {
	$.ajax({
		url:'ajax_media.php?list',
		type:"POST",
		dataType:"json",
		complete: function(response){
			if(response.responseText != 'error'){
				folders = JSON.parse(response.responseText);
				console.log(response.responseText);
			}else{
				alert("There was an error processing your request.");
			}
		}
		
	});
});
