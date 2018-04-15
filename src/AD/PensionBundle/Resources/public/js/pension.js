$(document).ready( function(){
	$('.carousel').carousel({
		  interval: 2000
	});

	$('.carousel').bind("slide.bs.carousel", function (e) {
		var id = $(e.relatedTarget).index();
		$("img.bg-main").removeClass('bg-main');
		$("#pension-image-tb-"+id).addClass('bg-main');
	});
})

function showCarouselImage(id){
	$('.carousel').carousel(id);
	$("img.bg-main").removeClass('bg-main');
	$("#pension-image-tb-"+id).addClass('bg-main');
}

//function changeThumbnailOnNext(length){
//	var id = $("#carouselExampleIndicators .carousel-inner div.active").index();
//	id += 1;
//	if(id > length-1)
//		id = 0;
//	$("img.bg-main").removeClass('bg-main');
//	$("#pension-image-tb-"+id).addClass('bg-main');
//}
//
//function changeThumbnailOnPrev(length){
//	var id = $("#carouselExampleIndicators .carousel-inner div.active").index();
//	id -= 1;
//	if(id < 0)
//		id = length-1;
//	$("img.bg-main").removeClass('bg-main');
//	$("#pension-image-tb-"+id).addClass('bg-main');
//}