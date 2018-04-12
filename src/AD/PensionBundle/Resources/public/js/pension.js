$('.carousel').carousel({
  interval: 2000
})

function showCarouselImage(id){
	$('.carousel').carousel(id);
	$("img.bg-main").removeClass('bg-main');
	$("#pension-image-tb-"+id).addClass('bg-main');
}