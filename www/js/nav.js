var navHeight;
var animationTime = 300;
var title;

$(document).ready(function() {
	navHeight = 75;
	var nav = $("header nav");
	var list = $("ul#nav");

	var collapseMenu = function() {
		if (!list.hasClass("visible")) return;

		nav.animate({height: navHeight}, animationTime, "swing", function() {
			if ($("ul.sub-menu.visible").length > 0) {
				$("ul.sub-menu.visible").removeClass("visible").css({
					left: '100%',
				}).parent().parent().css({
					right: '0%'
				});
			}
		});
		list.removeClass("visible");
	};

	$("header#hero, main#main, footer#colophon").click(collapseMenu);

	$("header nav div#button").click(function() {
		var height = list.height();

		if (list.hasClass("visible")) {
			collapseMenu();
		} else {
			nav.animate({height: navHeight + height}, animationTime);
			list.addClass("visible");
		}
	});
	
	$("ul#nav li.has-sub-menu a").click(function(e) {
		if (window.innerWidth >= 768) return true;
		
		if (e.clientX > window.innerWidth * .75) {
			e.preventDefault();
			
			var li = $(this).parent();
			
			li.parent().css({position: 'relative'}).animate(
				{right: '100%'}, animationTime
			);
			var subHeight = li.children('ul').animate(
				{left: '0%'}, animationTime
			).addClass('visible').height();
			nav.animate(
				{height: navHeight + subHeight} 
			, animationTime);
			
			return false;
		}
	});
});
