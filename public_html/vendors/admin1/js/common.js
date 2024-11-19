function disableallinput(canen){
    
  for(var y=0;y<document.forms[0].getElementsByTagName("INPUT").length;y++){
     if(document.forms[0].getElementsByTagName("INPUT")[y].getAttribute("type")=="checkbox" || document.forms[0].getElementsByTagName("INPUT")[y].getAttribute("type")=="radio"){
        document.forms[0].getElementsByTagName("INPUT")[y].disabled = canen;
        
        if(document.forms[0].getElementsByTagName("INPUT")[y].parentNode.parentNode.getElementsByTagName("TD")[6]){
           if(document.forms[0].getElementsByTagName("INPUT")[y].parentNode.parentNode.getElementsByTagName("TD")[6].getElementsByTagName("SELECT")[0]){
              if(canen) document.forms[0].getElementsByTagName("INPUT")[y].parentNode.parentNode.getElementsByTagName("TD")[6].getElementsByTagName("SELECT")[0].disabled = canen;
              else document.forms[0].getElementsByTagName("INPUT")[y].parentNode.parentNode.getElementsByTagName("TD")[6].getElementsByTagName("SELECT")[0].disabled = document.forms[0].getElementsByTagName("INPUT")[y].parentNode.parentNode.getElementsByTagName("TD")[6].getElementsByTagName("SELECT")[0].getAttribute("lastvalue"); 
           } 
        }
     } 
}  
}
function setlaststatus(){
    
   for(var y=0;y<document.forms[0].getElementsByTagName("INPUT").length;y++){
        if(document.forms[0].getElementsByTagName("INPUT")[y].getAttribute("type")!="hidden" && document.forms[0].getElementsByTagName("INPUT")[y].getAttribute("class")!="userlog"){
           document.forms[0].getElementsByTagName("INPUT")[y].setAttribute("laststatus",(document.forms[0].getElementsByTagName("INPUT")[y].disabled ? 1 : 0));
           document.forms[0].getElementsByTagName("INPUT")[y].disabled = true;
        }
    }
    for(var y=0;y<document.forms[0].getElementsByTagName("SELECT").length;y++){
        document.forms[0].getElementsByTagName("SELECT")[y].setAttribute("laststatus",(document.forms[0].getElementsByTagName("SELECT")[y].disabled ? 1 : 0));
        document.forms[0].getElementsByTagName("SELECT")[y].disabled = true;
    } 
}
function givelaststatus(){
 for(var y=0;y<document.forms[0].getElementsByTagName("INPUT").length;y++){
    if(document.forms[0].getElementsByTagName("INPUT")[y].getAttribute("type")!="hidden" && document.forms[0].getElementsByTagName("INPUT")[y].getAttribute("class")!="userlog"){
       document.forms[0].getElementsByTagName("INPUT")[y].disabled = document.forms[0].getElementsByTagName("INPUT")[y].getAttribute("laststatus")==1;
    }
 } 
 for(var y=0;y<document.forms[0].getElementsByTagName("SELECT").length;y++){
    document.forms[0].getElementsByTagName("SELECT")[y].disabled = document.forms[0].getElementsByTagName("SELECT")[y].getAttribute("laststatus")==1;
 }    
}
function validateNumber(obj){
  var str="";
  for(var i=0;i<obj.value.length;i++){
    if(validNumber(obj.value.substr(i))) str += obj.value.substr(i);
  }
  obj.value = str;
}

function validNumber(charCode){
  var result=true;
  /* for(var num=0;num<=9;num++){
    if(charCode==parseInt(num)){
      result = true;
      break;
    }
  } */
  return result;
}

function changeDate(obj,val){
  var ht = 200;
  var wd = 230;
  var tp = (screen.height/2) - (ht/2);
  var lf = (screen.width/2) - (wd/2);
  var settings = "menubar=no,toolbar=no,status=no,scrollbars=no,resizable=no,width="+wd+",height="+ht+",left="+lf+",top="+tp;
  var url = "../modules/calendar.php";
  var thisObj = document.getElementById(obj);
  if(!thisObj.disabled) window.open(url+"?obj="+obj+"&val="+val, "_newWin", settings);
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function toggleID(objName)
{
	var obj = document.getElementById(objName);
     	obj.style.display = (obj.style.display == "block")?"none":"block";
     	img = document.getElementById("img_"+objName);
    	img.src=(img.src.indexOf("toggle1.gif")!=-1)?"../images/toggle2.gif":"../images/toggle1.gif";
}

function setPointer(theRow, thePointerColor) 
	{
    if (thePointerColor == '' || typeof(theRow.style) == 'undefined') {
        return false;
    }
    if (typeof(document.getElementsByTagName) != 'undefined') {
        var theCells = theRow.getElementsByTagName('td');
    } else if (typeof(theRow.cells) != 'undefined') {
        var theCells = theRow.cells;
    } else {
        return false;
    }
    var rowCellsCnt=theCells.length;
    for (var c=0;c<rowCellsCnt;c++) {     
			//theCells[c].style.color = thePointerColor;
			if (thePointerColor=="52006B"){
				theCells[c].style.textDecoration = "underline";
				theCells[c].style.cursor = "hand";
			}
			else{
				theCells[c].style.textDecoration = "";
			}
    }
    return true;
	}
function _isObjectExists(objName,formObj)
	{
  	var ans=0;
  	for(x=0;x<formObj.elements.length;x++)
  		{
    		if(formObj.elements[x].name==objName)
    			{
      			ans=1;
      			break;
    			}
  		}
    return ans;
	} 	
	
function objectFound(objName,formObj){
  var ans=false;
  for(x=0;x<formObj.elements.length;x++){
    if(formObj.elements[x].name==objName){
      ans=true;
      break;
    }
  }
  return ans;
}

function _newWin(url)
	{
		window.open(url, "_newWin", "menubar=yes,toolbar=no,status=no,scrollbars=no,resizable=yes,width=1000,height=800");
	}
	
function _openWin(url,wd,ht){
  var tp = parseInt(screen.height/2) - parseInt(ht/2);
  var lf = parseInt(screen.width/2) - parseInt(wd/2);
  var settings = "menubar=no,toolbar=no,status=no,scrollbars=no,resizable=yes,width="+wd+",height="+ht+",left="+lf+",top="+tp;
  window.open(url, "_newWin", settings);
}

function getkey(e){
  if (window.event) return window.event.keyCode;
  else if(e) return e.which;
  else return null;
}

document.oncontextmenu = function(){
  return false;
}