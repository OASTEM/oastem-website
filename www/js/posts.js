var editPid = 0;
var editSucc = false;
var newSucc = false;
var newPost;
var editDialog;
var width;

var sci = true;
var tech = true;
var eng = true;
var math = true;

function refreshFilters(){
	if(sci){
		$('[data-cid=2]').removeClass('hidden');
		$('#sci img').attr('src','images/Atom.svg');
	}else{
		$('[data-cid=2]').addClass('hidden');
		$('#sci img').attr('src','images/Green-Atom.svg');
	}
	if(tech){
		$('[data-cid=3]').removeClass('hidden');
		$('#tech img').attr('src','images/Pointer.svg');
	}else{
		$('[data-cid=3]').addClass('hidden');
		$('#tech img').attr('src','images/Blue-Pointer.svg');
	}
	if(eng){
		$('[data-cid=4]').removeClass('hidden');
		$('#eng img').attr('src','images/Gear.svg');
	}else{
		$('[data-cid=4]').addClass('hidden');
		$('#eng img').attr('src','images/Orange-Gear.svg');
	}
	if(math){
		$('[data-cid=5]').removeClass('hidden');
		$('#math img').attr('src','images/Pi.svg');
	}else{
		$('[data-cid=5]').addClass('hidden');
		$('#math img').attr('src','images/Yellow-Pi.svg');
	}
}

function reloadp(){
	$('#feed-wrapper').empty();
	$.ajax({
		url:'/ajax_posts.php?get',
		dataType:"html",
		success:function(response){
			$('#feed-wrapper').html(response);
			initDynamicElements();
		}
	});
}

function initDynamicElements(){
	recursiveUnbind('#feed-wrapper');
	
	$('.delete-button').click(function() {
		var pid = $(this).parent().parent().data('pid');
		if(confirm("Continuing will delete this post.")){
			$.ajax({
				url:'/ajax_posts.php?delete',
				data:{pid:pid},
				type:"POST",
				dataType:"text",
				success:function(response){
					if(response == 'deleted'){
						reloadp();
					}else{
						alert('There was a problem processing your request.');
					}
				}
			});
		}
	});
			
	$('.edit-button').click(function() {
		editPid = $(this).parent().parent().data('pid');
				
		editDialog.dialog("open");
		
		var id = "post" + editPid;
				
		var t = $('#' + id + ' > .content-wrapper > .title').html();
		var c = $('#' + id + ' > .content-wrapper > .content').html();
		
		$('#title-edit-box').val(t);
		$('#content-edit-box').val(c);
	});
	
	$('time.post-time').timeago();
}

function recursiveUnbind(jElement) {
	$(jElement).unbind();
	$(jElement).removeAttr('onclick');
	$(jElement).children().each(function(){
		recursiveUnbind(this);
	});
}

$(function() {
	var measure = document.createElement('div');
    measure.style.height = '1em';
    document.body.appendChild(measure);
    width = measure.offsetHeight;
    document.body.removeChild(measure);
	
	reloadp();
	var topOff = 37;
	newDialog = $("#dialog-new").dialog({
		title:"New Post",
		autoOpen: false,
		width: 650,
		position:{my:'top',at:'top+50'},
		resizable:false,
		draggable:false,
		modal: true,
		buttons: [
			{
				text: 'Save',
				click: function(){
					$("#new-post-form").ajaxSubmit({
						success:function(response){
							if(response == 'success'){
								reloadp();
								newSucc = true;
								newDialog.dialog("close");
							}else{
								alert("There was an error processing your request.");
							}
						},
					});
				}
			},
			{
				text:'Cancel',
				click: function(e){
					$(this).dialog("close");
				}
			}
			],
			beforeClose:function(e){
				if(newSucc){
					newSucc = false;
				}else{
					if(confirm('Continuing will discard changes.')){
						newSucc = false;
					}else{
						return false;
					}
				}
			}
		});	

	
	editDialog = $("#dialog-edit").dialog({
		title:"Edit Post",
		autoOpen: false,
		width: 650,
		position:{my:'top',at:'top+50'},
		resizable:false,
		draggable:false,
		modal: true,
		buttons: [
			{
				text: 'Save',
				click: function(){
					$("#edit-form").ajaxSubmit({
						success:function(response){
							if(response == 'modified'){
								reloadp();
								editPid = 0;
								editSucc = true;
								editDialog.dialog("close");
							}else{
								alert("There was an error processing your request.");
							}
						},
						data:{pid:editPid}
					});
				}
			},
			{
				text:'Cancel',
				click: function(e){
					$(this).dialog("close");
				}
			}
			],
			beforeClose:function(e){
				if(!editSucc){
					if(confirm('Continuing will discard changes.')){
							$(this).find("#title-edit-box").val("");
							$(this).find("#content-edit-box").val("");
					}else{
						return false;
					}
				}
				editSucc = false;
				editPid = 0;
			}
	});
	
	$('#new-post').click(function(){
		newDialog.dialog("open");
	});
	
	$('#sci').click(function(){
		$(this).toggleClass('sel');
		sci = !sci;
		refreshFilters();
	});
	$('#tech').click(function(){
		$(this).toggleClass('sel');
		tech = !tech;
		refreshFilters();
	});
	$('#eng').click(function(){
		$(this).toggleClass('sel');
		eng = !eng;
		refreshFilters();
	});
	$('#math').click(function(){
		$(this).toggleClass('sel');
		math = !math;
		refreshFilters();
	});
});

