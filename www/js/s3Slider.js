/* ------------------------------------------------------------------------
	s3Slider
	
	Overhaul by: Kevin Tran -> http://ktomega.net/
	Version: 1.1
	
	Developped By: Boban Karišik -> http://www.serie3.info/
        CSS Help: Mészáros Róbert -> http://www.perspectived.com/
	Version: 1.0
	
	Copyright: Feel free to redistribute the script/modify it, as
			   long as you leave my infos at the top.
------------------------------------------------------------------------- */


(function($){  

    $.fn.s3Slider = function(vars) {       
        
        var element     = this;
        var timeOut     = (vars.timeOut != undefined) ? vars.timeOut : 4000;
        var timeOutFn   = null;
        var faderStat   = false; // true = fade out; false = fade in
        var mOver       = false;
        var items       = $("#" + element[0].id + "Content ." + element[0].id + "Image");
        var itemsSpan   = $("#" + element[0].id + "Content ." + element[0].id + "Image span");
		var height		= (vars.height != undefined) ? vars.height : 300;
		
		var currNo		= 0;
		var current		= null;
		var next 		= 1;
            
        items.each(function(i) {
    
            $(items[i]).mouseenter(function() {
                mOver = true;
			    clearTimeout(timeOutFn);
            }).mouseleave(function() {
                mOver   = false;
                timeOutFn = setTimeout(fadeNext, timeOut);
            }).addClass("hidden");
            
        });
        
        var go = function() {
            currNo = currNo % items.length;
			current = items[currNo];
			
			next = (currNo + 1) % items.length;
			
			$(current).removeClass("hidden").addClass("current");
			$(itemsSpan[currNo]).slideDown(timeOut/10);
			$(items[next]).removeClass("hidden").addClass("next");
			
			timeOutFn = setTimeout(fadeNext, timeOut);
        };
		
		var fadeNext = function() {
			// fade out current
			/*console.log("");
			console.log("");
			console.log("");
			console.log("STATISTICS");
			console.log("Num of 'current' elements: " + $(".current").length);
			console.log("Num of 'next' elements: " + $(".next").length);
			console.log("Num of 'hidden' elements: " + $(".hidden").length);
			console.log("");
			console.log("");
			console.log("");*/
			
			clearTimeout(timeOutFn);
			$(itemsSpan[currNo]).slideUp(timeOut/10, function() {
				//console.log("Span slideup complete in " + (timeOut/10));
				$(current).fadeOut(timeOut/10, function() {
					$(items[next]).removeClass("next").addClass("current");
					
					//console.log("This is now the current element.");
					//console.log(items[next]);
					
					if (next == items.length - 1) {
						//console.log("next == items.length -1");
						$(items[next]).css("top", "-" + height + "px");
					} else if (next == 0) {
						//console.log("next == 0");
						$(items[next]).css("top", "0px");
					}
					$(itemsSpan[next]).slideDown(timeOut/10);
					$(current).removeClass("current").addClass("hidden");
					
					//console.log("This was the last element.");
					//console.log(current);
					
					// update vars
					currNo = (++currNo) % items.length;
					current = items[currNo];
					next = (currNo + 1) % items.length;
					
					// get ready for next
					$(items[next]).removeClass("hidden").addClass("next");
					
					//console.log("This is the next element.");
					//console.log(items[next]);
					
					if (next == 0) {
						$(items[next]).css("top", "0px");
					}
					
					// loop
					//console.log("Faded out. Setting timeout " + timeOut);
					timeOutFn = setTimeout(fadeNext, timeOut);
				});
			});
		};
        
        go();

    };  

})(jQuery);  