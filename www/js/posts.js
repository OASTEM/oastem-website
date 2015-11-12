
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

var catInit = true;
var postInit = false;

var fetchingMore = false;
var scrollCt = 0;

$(window).scroll(function() {
   if($(window).scrollTop() + $(window).height() == $(document).height()) {
      loadMore();
   }
});

function four(){
	return !sci && !eng  && !math && !tech;
}

function allOn(){
	return sci && eng  && math && tech;
}

function refreshFilters(){
	checkInit();
	if(sci){
		$('[data-cid=2]').removeClass('hidden');
		$('#sci img').attr('src','images/Atom.svg');
		$('#sci').removeClass('sel');
	}else{
		$('[data-cid=2]').addClass('hidden');
		$('#sci img').attr('src','images/Green-Atom.svg');
		$('#sci').addClass('sel');
	}
	if(tech){
		$('[data-cid=3]').removeClass('hidden');
		$('#tech img').attr('src','images/Pointer.svg');
		$('#tech').removeClass('sel');
	}else{
		$('[data-cid=3]').addClass('hidden');
		$('#tech img').attr('src','images/Blue-Pointer.svg');
		$('#tech').addClass('sel');
	}
	if(eng){
		$('[data-cid=4]').removeClass('hidden');
		$('#eng img').attr('src','images/Gear.svg');
		$('#eng').removeClass('sel');
	}else{
		$('[data-cid=4]').addClass('hidden');
		$('#eng img').attr('src','images/Orange-Gear.svg');
		$('#eng').addClass('sel');
	}
	if(math){
		$('[data-cid=5]').removeClass('hidden');
		$('#math img').attr('src','images/Pi.svg');
		$('#math').removeClass('sel');
	}else{
		$('[data-cid=5]').addClass('hidden');
		$('#math img').attr('src','images/Yellow-Pi.svg');
		$('#math').addClass('sel');
	}
}

function checkInit(){
	if((four() || catInit) && !fetchingMore){
		console.log('triggered')
		sci = !sci;
		tech = !tech;
		eng = !eng;
		math = !math;
		catInit = false;
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
			scrollCt = 24;
            if(!postInit) postInit = true;
		}
	});
}

function loadMore(){
	if(scrollCt != -1 && !fetchingMore && postInit){
		fetchingMore = true;
		$('#loading').css('visibility','visible');
		//setTimeout(function(){
		$.ajax({
			url:'/ajax_posts.php?get',
			data:{
				'lim':scrollCt
			},
			dataType:'html',
			type:"POST",
			success:function(response){
				if(response == "No more."){
					scrollCt = -1;
					$('#loading').css('visibility','hidden');
				}else{
					$('#feed-wrapper').append(response);
					initDynamicElements();
					refreshFilters();
					scrollCt += 24;
				}
				$('#loading').css('visibility','hidden');
				fetchingMore = false;
			}
		});
		//},10000);
	}
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
	$('#loading').css('visibility','hidden');
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
		position:{
            my:"center",
            at:"center",
            of:window
        },
		resizable:false,
		draggable:false,
		modal: true,
		buttons: [
			{
				text: 'Save',
				click: function(){
					/**$.ajax({
                        url:"/ajax_posts.php?new",
                        method:"POST",
                        success:function(response){
                            if(response == 'success'){
								reloadp();
								newSucc = true;
								newDialog.dialog("close");
							}else{
								alert("There was an error processing your request.");
								console.log('Received:');
								console.log(response);
                                console.log($('#new-title').val());
                                console.log(newBox.getBody());
							}
                        },
                        data:{
                            title:$('#new-title').val(),
                            content:newBox.getBody()
                        }
                    });*/
                    tinyMCE.get('new-content').save();
                    $("#new-post-form").ajaxSubmit({
						success:function(response){
							if(response == 'success'){
								reloadp();
								newSucc = true;
								newDialog.dialog("close");
							}else{
								alert("There was an error processing your request.");
								console.log('Received:');
								console.log(response);
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
					$("#new-post-form").find("input,textarea").val("");
				}else{
					if(confirm('Continuing will discard changes.')){
						newSucc = false;
						$("#new-post-form").find("input,textarea").val("");
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
		position:{
            my:"center",
            at:"center",
            of:window
        },
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
                                console.log('Received:');
								console.log(response);
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
							//$(this).find("#content-edit-box").val(""); TODO: Update to MCE
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
		catInit = allOn();
		sci = !sci;
		refreshFilters();
	});
	$('#tech').click(function(){
		catInit = allOn();
		tech = !tech;
		refreshFilters();
	});
	$('#eng').click(function(){
		catInit = allOn();
		eng = !eng;
		refreshFilters();
	});
	$('#math').click(function(){
		catInit = allOn();
		math = !math;
		refreshFilters();
	});
});

