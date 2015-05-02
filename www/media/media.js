var index = 0;
var maxI = 0;

var folders;

function loadMediaPage(){
	$('#loading').css('visibility','visible');
	if(index == -1){
		index = maxI;
	}
	if(index > maxI){
		index = 0;
	}
	$.ajax({
		url:'ajax_media.php?get',
		type:"POST",
		data:{fid:folders[index]},
		dataType:"html",
		success: function(response){
			if(response.responseText != 'error'){
				$('#media-content').html(response);
				$('#loading').css('visibility','hidden');
			}else{
				alert("There was an error processing your request.");
			}

		}
	});
}

$(document).ready(function(e) {
	$('#prev').button({
		icons:{primary:"ui-icon-arrowthick-1-w"}
	});
	$('#prev').click(function(e){
		index--;
		loadMediaPage();
	});

	$('#next').button({
		icons:{primary:"ui-icon-arrowthick-1-e"}
	});
	$('#next').click(function(e){
		index++;
		loadMediaPage();
	});
	$.ajax({
		url:'ajax_media.php?list',
		type:"POST",
		dataType:"json",
		success: function(response){
			if(response.responseText != 'error'){
				folders = response;
				maxI = folders.length - 1;
				loadMediaPage();
			}else{
				alert("There was an error processing your request.");
			}
		}
		
	});
});

