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
var $go = false;
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
		//toggleScroll(true);
		changeImage("left");
    });
	$('.next-button').click(function () {
		thumbScroll("right");
		//toggleScroll(true);
		changeImage("right");
    });
	$('#thumbcon img').on('click',function (e) {
		$("#gallery-picture img").attr("src",$(e.currentTarget).attr("src"));
		$(".thumbnails img.thumb").removeClass("selected");
		$(e.currentTarget).addClass("selected");
	});
	$('#playtoggle').click(function () {
		toggleScroll(false);
	});
	
	$("#gallery-picture img").load(function() {
		var alto = $(this).outerHeight() / 2 + 80;
		$("#gallery-slider #gallery-nav").css({"marginTop":-alto,"display":"block"});
	});
	
});
function changeImage(direction) {
	
	var width = $(".thumb:first").outerWidth() + parseInt($(".thumb:first").css("margin-right").replace("px",""));
	var totalWidth = width * imageCount;
	var availableWidth = $("#gallery-picture img").outerWidth();
	var ml = parseInt($thumbBank[0].css("marginLeft").replace("px",""));
	if( (availableWidth-totalWidth) < ml && ml <= 0){
		if(direction == "left"){
			$thumbBank[0].css({ marginLeft: "+="+width , transition: "all 1.0s ease"});
		}else if(direction == "right"){
			$thumbBank[0].css({ marginLeft: "-="+width , transition: "all 1.0s ease"});
		}
	}
	
	if (direction == "left") {
		var img = $(".thumbnails img.thumb.selected").prev("img");
		if (img.length <= 0) {
			img = $(".thumbnails img.thumb").last();
			$thumbBank[0].css({ marginLeft: (availableWidth-totalWidth) , transition: "all 1.0s ease"});
		}		
	} else {
		var img = $(".thumbnails img.thumb.selected").next("img");
		if (img.length <= 0) {
			img = $(".thumbnails img.thumb").first();
			$thumbBank[0].css({ marginLeft: "0" , transition: "all 1.0s ease"});
		}
	}
	
	$(".thumbnails img.thumb").removeClass("selected");
	$("#gallery-picture img").attr("src",img.attr("src"));
	img.addClass("selected");		
}
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