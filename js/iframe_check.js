var isInIFrame = (window.location != window.parent.location) ? true : false;

if(isInIFrame){
	parent.document.location=settings.home;
}