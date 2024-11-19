document.onmousemove = mouseMove;
document.onmouseup   = mouseUp;

var dragObject  = null;
var mouseOffset = null;

document.onscroll = function(ev){
  
}

function getMouseOffset(target, ev){
	ev = ev || window.event;

	var docPos    = getPosition(target);
	var mousePos  = mouseCoords(ev);
	var docX = mousePos.x - docPos.x;
	var docY = mousePos.y - docPos.y;
	if(docX < 0) docX = 0;
  if(docY < 0) docY = 0;
	return {x:docX, y:docY};
}

function mouseCoords(ev){
  if(ev.pageX || ev.pageY){
    return {x:ev.pageX, y:ev.pageY};
  }
  return {
    x:ev.clientX + document.body.scrollLeft - document.body.clientLeft,
    y:ev.clientY + document.body.scrollTop  - document.body.clientTop
  };
}

function getPosition(e){
	var left = 0;
	var top  = 0;

	while (e.offsetParent){
		left += e.offsetLeft;
		top  += e.offsetTop;
		e     = e.offsetParent;
	}

	left += e.offsetLeft;
	top  += e.offsetTop;

	return {x:left, y:top};
}

function mouseMove(ev){
	ev           = ev || window.event;
	var mousePos = mouseCoords(ev);
	if(dragObject){
    var docX = mousePos.x - mouseOffset.x;
  	var docY = mousePos.y - mouseOffset.y;
  	var objWidth = parseInt(dragObject.style.width);
  	var objHeight = parseInt(dragObject.style.height);
  	var bodyWidth = document.body.clientWidth-2;
  	var bodyHeight = document.body.clientHeight-2;
  	var sY = getScrollY();
  	if(docX < 0) docX = 0;
  	if(docY < 0) docY = 0;
  	if(docX + objWidth > bodyWidth) docX = bodyWidth - objWidth;
  	if(docY + objHeight > (bodyHeight+sY)) docY = (bodyHeight+sY) - objHeight;
		dragObject.style.position = 'absolute';
		dragObject.style.top      = docY;
		dragObject.style.left     = docX;
		return false;
	}
}
function mouseUp(){
	dragObject = null;
}

function makeDraggable(item){
	if(!item) return;
	item.onmousedown = function(ev){
		dragObject  = this;
		mouseOffset = getMouseOffset(this, ev);
		return false;
	}
}

function getX(obj){
  var wd = parseInt(obj.style.width);
  var lf = (screen.width/2) - (wd/2);
  return lf+"px";
}

function getY(obj){
  var ht = parseInt(obj.style.height);
  var tp = (screen.height/2) - (ht/2);
  return tp+"px";
}

function dragThis(obj){
	obj.onmousedown = function(ev){
		dragObject  = this;
		dragObject.style.cursor = "move";
		mouseOffset = getMouseOffset(this, ev);
		return false;
	}
	obj.onmouseup = function(){
    obj.onmousedown = null;
    obj.style.cursor = "default";
 }
}

function setDraggable(){
	var divs = document.getElementsByTagName("div");
	for(var ix=0;ix<divs.length;ix++){
    if(divs[ix].getAttribute("drag")=="1"){
      var item = divs[ix];
    	item.onmousedown = function(ev){
    		dragObject  = this;
    		mouseOffset = getMouseOffset(this, ev);
    		return false;
    	}
    }
 }
}

function getScrollY() {
  var scrOfX = 0, scrOfY = 0;
  if( typeof( window.pageYOffset ) == 'number' ) {
    //Netscape compliant
    scrOfY = window.pageYOffset;
    scrOfX = window.pageXOffset;
  } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
    //DOM compliant
    scrOfY = document.body.scrollTop;
    scrOfX = document.body.scrollLeft;
  } else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
    //IE6 standards compliant mode
    scrOfY = document.documentElement.scrollTop;
    scrOfX = document.documentElement.scrollLeft;
  }
  return scrOfY;
}

function getScrollX() {
  var scrOfX = 0, scrOfY = 0;
  if( typeof( window.pageYOffset ) == 'number' ) {
    //Netscape compliant
    scrOfY = window.pageYOffset;
    scrOfX = window.pageXOffset;
  } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
    //DOM compliant
    scrOfY = document.body.scrollTop;
    scrOfX = document.body.scrollLeft;
  } else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
    //IE6 standards compliant mode
    scrOfY = document.documentElement.scrollTop;
    scrOfX = document.documentElement.scrollLeft;
  }
  return scrOfX;
}