$(document).ready( function(){
	for(var i = 1; i <= 3; i++){
		setTimeout(addShadow,i*1000,i);
		setTimeout(removeShadow,i*1000+1000,i);
	}
})

function addShadow(value){
	$(".small-link:nth-of-type("+value+")").addClass("shadowed");
}

function removeShadow(value){
	$(".small-link:nth-of-type("+value+")").removeClass("shadowed")
}
