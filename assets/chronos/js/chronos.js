$(function () {
$('#countdown').countdown({until: secondsStr, compact: true, 
    layout: '<div class="image{d100} ' + threeDig +'"></div><div class="image{d10}"></div><div class="image{d1}"></div><div class="imageDay"></div>' +
			'<div class="imageSpace"></div><div class="image{h10}"></div><div class="image{h1}"></div><div class="imageHour"></div><div class="imageSpace"></div>' +
			'<div class="image{m10}"></div><div class="image{m1}"></div><div class="imageMin"></div><div class="imageSpace"></div><div class="image{s10}"></div>' +
			'<div class="image{s1}"></div><div class="imageSec"></div>'});
});