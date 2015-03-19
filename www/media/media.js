var index = 0;

var folders;

function loadMediaPage(){
	console.log(folders[index]);
	$.ajax({
		url:'ajax_media.php?get',
		type:"POST",
		data:{fid:folders[index]},
		dataType:"html",
		success: function(response){
			console.log("Done");
			if(response.responseText != 'error'){
				$('#media-content').html(response);
				console.log(response);
			}else{
				alert("There was an error processing your request.");
			}

		}
	});
}

$(document).ready(function(e) {
	$.ajax({
		url:'ajax_media.php?list',
		type:"POST",
		dataType:"json",
		success: function(response){
			if(response.responseText != 'error'){
				folders = response;
				console.log(folders);
				loadMediaPage();
			}else{
				alert("There was an error processing your request.");
			}
		}
		
	});
});

