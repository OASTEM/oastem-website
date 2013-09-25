<?php
	/*
	* phpBBCode
	*
	* @website   www.swaziboy.com
	* @author    Duncan Mundell
	* @updated   03/2003
	* @version   1.0a
	*/
	
	function BBCode($Text) {
		
		// Replace any html brackets with HTML Entities to prevent executing HTML or script
		// Don't use strip_tags here because it breaks [url] search by replacing & with amp
		$Text = str_replace("<", "&lt;", $Text);
		$Text = str_replace(">", "&gt;", $Text);
		
		// Convert new line chars to html <br /> tags
		//$Text = nl2br($Text);
		
		// Set up the parameters for a URL search string
		$URLSearchString = " a-zA-Z0-9\:\/\-\?\&\.\=\_\~\#\'";
		// Set up the parameters for a MAIL search string
		$MAILSearchString = $URLSearchString . " a-zA-Z0-9\.@";
		
		// Perform URL Search
		$Text = preg_replace("/\[url\]([$URLSearchString]*)\[\/url\]/", '<a href="$1" target="_blank">$1</a>', $Text);
		$Text = preg_replace("(\[url\=([$URLSearchString]*)\](.+?)\[/url\])", '<a href="$1" target="_blank">$2</a>', $Text);
		
		// Perform MAIL Search
		$Text = preg_replace("(\[mail\]([$MAILSearchString]*)\[/mail\])", '<a href="mailto:$1">$1</a>', $Text);
		$Text = preg_replace("/\[mail\=([$MAILSearchString]*)\](.+?)\[\/mail\]/", '<a href="mailto:$1">$2</a>', $Text);
		
		// Check for bold text
		$Text = preg_replace("(\[b\](.+?)\[\/b])is",'<span class="bold">$1</span>',$Text);
		
		// Check for Italics text
		$Text = preg_replace("(\[i\](.+?)\[\/i\])is",'<span class="italics">$1</span>',$Text);
		
		// Check for Underline text
		$Text = preg_replace("(\[u\](.+?)\[\/u\])is",'<span class="underline">$1</span>',$Text);
		
		// Check for strike-through text
		$Text = preg_replace("(\[s\](.+?)\[\/s\])is",'<span class="strikethrough">$1</span>',$Text);
		
		// Check for over-line text
		$Text = preg_replace("(\[o\](.+?)\[\/o\])is",'<span class="overline">$1</span>',$Text);
		
		// Check for colored text
		$Text = preg_replace("(\[color=(.+?)\](.+?)\[\/color\])is","<span style=\"color: $1\">$2</span>",$Text);
		$Text = preg_replace("(\[color=(.+?)\](.+?)\[\/color\])is","<span style=\"color: $1\">$2</span>",$Text);
		$Text = preg_replace("(\[color=(.+?)\](.+?)\[\/color\])is","<span style=\"color: $1\">$2</span>",$Text);
		
		// Check for sized text
		$Text = preg_replace("(\[size=(.+?)\](.+?)\[\/size\])is","<span style=\"font-size: $1px\">$2</span>",$Text);
		
		//Newlines!
		$Text = str_replace('[br /]', '<br />', $Text);
		
		// Check for list text
		$Text = preg_replace("/\[list\](.+?)\[\/list\]/is", '<ul class="listbullet">$1</ul>' ,$Text);
		$Text = preg_replace("/\[list=1\](.+?)\[\/list\]/is", '<ul class="listdecimal">$1</ul>' ,$Text);
		$Text = preg_replace("/\[list=i\](.+?)\[\/list\]/s", '<ul class="listlowerroman">$1</ul>' ,$Text);
		$Text = preg_replace("/\[list=I\](.+?)\[\/list\]/s", '<ul class="listupperroman">$1</ul>' ,$Text);
		$Text = preg_replace("/\[list=a\](.+?)\[\/list\]/s", '<ul class="listloweralpha">$1</ul>' ,$Text);
		$Text = preg_replace("/\[list=A\](.+?)\[\/list\]/s", '<ul class="listupperalpha">$1</ul>' ,$Text);
		$Text = str_replace("[*]", "<li>", $Text);
		
		// Check for font change text
		$Text = preg_replace("(\[font=(.+?)\](.+?)\[\/font\])","<span style=\"font-family: $1;\">$2</span>",$Text);
		
		// Declare the format for [code] layout
		$CodeLayout = '<div class="codebody">$1</div>';
		// Check for [code] text
		$Text = preg_replace("/\[code\](.+?)\[\/code\]/is","$CodeLayout", $Text);
		
		// Declare the format for [quote] layout
		//<blockquote><div class="citey"><cite title="Posted on November 11 2009 01:54PM"><a href="/forum/Games/Mother2/You-know-you-ve-played-to-much-Earthbound-when/1459065">PKFighter201:</a></cite></div><div class="quotey"><p>Does that mean I’m not the only one who has Magicant dreams?</p></div></blockquote>
		$QuoteLayout = '
<table class="bbcode">
	<tr>
		<td class="quotecodeheader">$1</td>
	</tr>
	<tr>
		<td class="quotebody">$2</td>
	</tr>
</table>';
		$QuoteLayout = '
<blockquote class="forumQuote">
	<div class="citey">
		$1
	</div>
	<div class="quotey">
$2
	</div>
</blockquote>';
				 
		// Check for [quote] text. Three passes is enough to make it not explode.
		$Text = preg_replace('/\[quote=(.+?)\](.+?)\[\/quote\]/is',"$QuoteLayout", $Text);
		$Text = preg_replace('/\[quote=(.+?)\](.+?)\[\/quote\]/is',"$QuoteLayout", $Text);
		$Text = preg_replace('/\[quote=(.+?)\](.+?)\[\/quote\]/is',"$QuoteLayout", $Text);
		
		// Spoiler!
		$spoiler = '
<div style="padding: 3px; border: 1px solid #d8d8d8; font-size: 1em;">
	<div style="text-transform: uppercase; border-bottom: 1px solid #CCCCCC; margin-bottom: 3px; font-size: 0.8em; font-weight: bold; display: block;">
		<b>Spoiler: $1 </b>
		<span onClick="spoiler(this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0], this.getElementsByTagName(\'a\')[0]); ">
			<a href="#" onClick="return false;">show</a>
		</span>
	</div>
	<div class="quotecontent">
		<div style="display: none;">
			$2
		</div>
	</div>
</div>';
		$Text = preg_replace('/\[spoiler=(.+?)\](.+?)\[\/spoiler\]/is', $spoiler, $Text);
		$Text = preg_replace('/\[spoiler=(.+?)\](.+?)\[\/spoiler\]/is', $spoiler, $Text);
		$Text = preg_replace('/\[spoiler=(.+?)\](.+?)\[\/spoiler\]/is', $spoiler, $Text);
		
		// Images
		// [img]pathtoimage[/img]
		$Text = preg_replace("/\[img\](.+?)\[\/img\]/", '<img src="$1">', $Text);
		
		// [img=widthxheight]image source[/img]
		$Text = preg_replace("/\[img\=([0-9]*)x([0-9]*)\](.+?)\[\/img\]/", '<img src="$3" height="$2" width="$1">', $Text);
		
		return $Text;
	}
	function doCode($text) {
		return highlight_string($text);
	}
?>