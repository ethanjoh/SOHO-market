<!--

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}


//Swap Image
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}


//Show HIde Image
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);


function MM_showHideLayers() { //v3.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v='hide')?'hidden':v; }
    obj.visibility=v; }
}

//open window
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function onlyNumber1(form_name){
   for(var i=0; i < form_name.value.length; i++) {
	     var chr = form_name.value.substr(i,1);
		 if(chr < '0' || chr > '9') {
		    alert("숫자 또는 소숫점 자리로만 입력하셔야 합니다!");
			form_name.focus();
			form_name.value="";
		 }
   }

}


// popup 창에서 사용
function setCookie( name, value, expiredays ) {
  var todayDate = new Date();
  todayDate.setDate( todayDate.getDate() + expiredays );
  document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}

function closeWin() {
  if ( document.getElementById("chkNotice").checked )
    setCookie( "chkNotice", "done" , 1); //1은 하루동안 쿠키보관, 테스트시 팝업을 새로 열려면 -5로 설정

  $('#notice').trigger('reveal:close');
  //self.close();
}


// function closePopup() {
//     if ( document.notice_form.chkbox.checked ){
//         setCookie( "maindiv", "done" , 1 );
//     }
//     document.all['divpop'].style.visibility = "hidden";
// }

// // $( document ).on( "pageinit", "#demo-page", function() {
// //     $( document ).on( "swipeleft swiperight", "#demo-page", function( e ) {
// //         // We check if there is no open panel on the page because otherwise
// //         // a swipe to close the left panel would also open the right panel (and v.v.).
// //         // We do this by checking the data that the framework stores on the page element (panel: open).
// //         if ( $.mobile.activePage.jqmData( "panel" ) !== "open" ) {
// //             if ( e.type === "swipeleft"  ) {
// //                 $( "#right-panel" ).panel( "open" );
// //             } else if ( e.type === "swiperight" ) {
// //                 $( "#left-panel" ).panel( "open" );
// //             }
// //         }
// //     });
// // });

function getCookie( name ) {
	var nameOfCookie = name + "=";
	var x = 0;

	while ( x <= document.cookie.length ) {
		var y = (x+nameOfCookie.length);

		if ( document.cookie.substring( x, y ) == nameOfCookie ) {
			if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
				endOfCookie = document.cookie.length;
			return unescape( document.cookie.substring( y, endOfCookie ) );
		}

		x = document.cookie.indexOf( " ", x ) + 1;

		if ( x == 0 )
			break;
	}
	return "";
}

//-->