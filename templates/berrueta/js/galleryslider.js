var $transitionLength = 400;
var $timeBetweenTransitions = 3000;
var imageCount = 0;
var currentImageIndex = 0;
var currentScrollIndex = 1;
var $imageBank = [];
var $thumbBank = [];
var $mainContainer = $("#gallery-picture");
var $thumbContainer = $("#thumbcon");
var $progressBar = $("#progressbar");
var currentElement;
var $go = true;
$(document).ready(function(){
	$("#hidden-thumbs img").each(function() {
		$imageBank.push($(this).attr("id", imageCount));
		imageCount++;
	});
	generateThumbs();
	setTimeout(function () {
	imageScroll(0);
	}, $timeBetweenTransitions);
	$('.prev-button').click(function () {
		thumbScroll("left");
		toggleScroll(true);
    });
	$('.next-button').click(function () {
		thumbScroll("right");
		toggleScroll(true);
    });
	$('#thumbcon img').on('click',function () {
		imageFocus(this);
	});
	$('#playtoggle').click(function () {
		toggleScroll(false);
	});
});
function progress(imageIndex){
	var parts = 960/imageCount-1;
	var pxProgress = parts*(imageIndex+1);
	$progressBar.css({ width: pxProgress , transition: "all 0.7s ease"});
}
function imageFocus(focus){
	for(var i = 0; i < imageCount; i++){
		if($imageBank[i].attr('src') == $(focus).attr('src')){
			$thumbBank[currentImageIndex].removeClass("selected");
			setTimeout(function () {
				$mainContainer.html($imageBank[i]);
				$thumbBank[i].addClass("selected");
			}, $transitionLength);
			currentScrollIndex = i+1;
			currentImageIndex = i;
			progress(currentImageIndex);
			toggleScroll(true);
			return false;
		}
	}
}
function toggleScroll(bool){
	if($go){
		$go = false;
		$('#playtoggle').children().removeClass('icon-pause').addClass('icon-play');
	}else{
		$go = true;
		$('#playtoggle').children().removeClass('icon-play').addClass('icon-pause');
	}
	if(bool){
		$go = false;
		$('#playtoggle').children().removeClass('icon-pause').addClass('icon-play');
	}
}
function autoScroll(){
	if(currentScrollIndex >= 0 || currentScrollIndex < imageCount){
		if(currentScrollIndex+1 > imageCount){
			$thumbBank[0].css({ marginLeft: "0" , transition: "all 1.0s ease"});
			currentScrollIndex = 1;
		}else if(currentScrollIndex+1 >= 3){
			if(currentScrollIndex+2 >= imageCount){

			}else
				$thumbBank[0].css({ marginLeft: "-=200" , transition: "all 1.0s ease"});

			currentScrollIndex++;
		}else{
			currentScrollIndex++;
		}
	}
}
function thumbScroll(direction){
	if(currentScrollIndex >= 0 || currentScrollIndex < imageCount){
		var marginTemp = currentScrollIndex;
		if(direction == "left"){
			if(currentScrollIndex-3 <= 0){
				var k = ((imageCount-4)*200)-5;
				$thumbBank[0].css({ marginLeft: -k , transition: "all 1.0s ease"});
				currentScrollIndex = imageCount-1;
			}else{
				$thumbBank[0].css({ marginLeft: "+=200" , transition: "all 1.0s ease"});
				currentScrollIndex--;
			}
		}else if(direction == "right"){
			if(currentScrollIndex+3 >= imageCount){
				$thumbBank[0].css({ marginLeft: "5px" , transition: "all 1.0s ease"});
				currentScrollIndex = 1;
			}else{
				$thumbBank[0].css({ marginLeft: "-=200" , transition: "all 1.0s ease"});
				currentScrollIndex++;
			}
		}
	}
}
function generateThumbs(){
	progress(currentImageIndex);
	for(var i = 0; i < imageCount; i++){
		var $tempObj = $('<img id="'+i+'t" class="thumb" src="'+$imageBank[i].attr('src')+'" />');
		if(i == 0)
	    $tempObj.addClass("selected");
		$thumbContainer.append($tempObj);
		$thumbBank.push($tempObj);
	}
}
function imageScroll(c){
	if($go){
		$thumbBank[c].removeClass("selected");
		c++
		if(c == $imageBank.length)
			c = 0;
		setTimeout(function () {
			$mainContainer.html($imageBank[c]);
			$thumbBank[c].addClass("selected");
			autoScroll("left");
		}, $transitionLength);
	}
	progress(c);
	setTimeout(function () {
		imageScroll(currentImageIndex);
	}, $timeBetweenTransitions);
	currentImageIndex = c;
}