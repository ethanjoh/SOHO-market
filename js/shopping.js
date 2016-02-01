
<!-- 구매 페이지에서 배송방법 선택 -->
function trans(curpage, delivery) {
// function trans(curpage, delivery, seller_type) {

	// if(delivery == "L1" && seller_type = "3")
	// 	alert("위탁배송의 경우 사입거래업체는 당사직송상품을 제외하고 월 3회로 제한됩니다.");

	var form = document.purchase;

	if(delivery == 'D') {
		form.action = curpage+'&delivery=d';
	}else if(delivery == 'Q') {
		form.action = curpage+'&delivery=q';
	}else if(delivery == 'L') {
		form.action = curpage+'&delivery=l';
	}else if(delivery == 'L1') {
		form.action = curpage+'&delivery=l1';
	}

	form.submit();
}

function init(){
  setTimeout("location.reload();",60000); //시간을 설정.
 }

function open_win(theURL, winName, features) {
  window.open(theURL, winName, features);
}

function form_reset(){
    document.gume.reset();
  }

function num_plus(num){
	gnum = parseInt(num.products_count.value);
	if (gnum > 1000) {
		alert(' 제품재고량(1,000개)을 초과하였습니다. ');
		num.products_count.value = 1000;
		return;
	}
	num.products_count.value = gnum + 1;
	return;
}

function num_minus(num){

	gnum = parseInt(num.products_count.value);
	if( gnum > 1 ){
		num.products_count.value = gnum - 1;
	}
	else {
		alert('본 제품의 최소 구매수량은 (1개)입니다.');
	}
	return;
}

function is_number(){
	if ((event.keyCode<48)||(event.keyCode>57)){
		alert("\n\n수량은 숫자만 입력하셔야 합니다.\n\n");
		event.returnValue=false;
	}
}


function cart_edit(form) {

  if(!form.products_count.value){
		alert('수량을 입력하지 않았습니다.');
		form.products_count.focus();
		return;
	}

  if(form.products_count.value) {
	  if(!IsNumber(form.products_count.name)){
         alert("수량은 숫자이어야 합니다!");
	     form.products_count.focus();
	     return;
	  }
  }

  form.action="cart_update.php?chk=2";
  form.submit();
}

function goCart(form) {

  if(!form.products_count.value){
		alert('수량을 입력하지 않았습니다.');
		form.products_count.focus();
		return;
	}

  if(form.products_count.value) {
	  if(!IsNumber(form, form.products_count.name)){
         alert("수량은 숫자이어야 합니다!");
	     form.products_count.focus();
	     return;
	  }
  }

  form.action="/shop/cart_update.php";
  form.submit();
}

function goOrder(form) {

  if(!form.products_count.value){
		alert('수량을 입력하지 않았습니다.');
		form.products_count.focus();
		return;
	}

  if(form.products_count.value) {
	  if(!IsNumber(form, form.products_count.name)){
         alert("수량은 숫자이어야 합니다!");
	     form.products_count.focus();
	     return;
	  }
  }

  if(form == "document.m_product_info")
  	form.action="cart_update.php?chk=3";
  else
  	form.action="cart_update.php?chk=2";

  form.submit();
}

function gomOrder(form) {

  if(!form.products_count.value){
		alert('수량을 입력하지 않았습니다.');
		form.products_count.focus();
		return;
	}

  if(form.products_count.value) {
	  if(!IsNumber(form, form.products_count.name)){
         alert("수량은 숫자이어야 합니다!");
	     form.products_count.focus();
	     return;
	  }
  }

  form.action="/shop/cart_update.php?chk=3";
  form.submit();
}

function goQuotation(form) {

  if(!form.products_count.value){
		alert('수량을 입력하지 않았습니다.');
		form.products_count.focus();
		return;
	}

  if(form.products_count.value) {
	  if(!IsNumber(form, form.products_count.name)){
         alert("수량은 숫자이어야 합니다!");
	     form.products_count.focus();
	     return;
	  }
  }

  form.action="cart_update.php?chk=3";
  form.submit();
}

function goDirOrder(form) {

  if(!form.products_count.value){
		alert('수량을 입력하지 않았습니다.');
		form.products_count.focus();
		return;
	}

  form.action="../member/login.php?from=dir";
  form.submit();
}

function goDirOrder2(form) {
  form.action="../shop/cart_update.php?from=dir";
  form.submit();
}

function equalRecipient()
{
   var form = document.purchase;
   if(form.equ.checked == true){
	   form.recipient_name.value = form.buyer_name.value;
	   form.recipient_phone01.value = form.buyer_phone01.value;
	   form.recipient_phone02.value = form.buyer_phone02.value;
	   form.recipient_phone03.value = form.buyer_phone03.value;
	   form.recipient_hphone01.value = form.buyer_hphone01.value;
	   form.recipient_hphone02.value = form.buyer_hphone02.value;
	   form.recipient_hphone03.value = form.buyer_hphone03.value;
	   form.recipient_zipcode01.value = form.buyer_zipcode01.value;
	   form.recipient_zipcode02.value = form.buyer_zipcode02.value;
	   form.recipient_address01.value = form.buyer_address01.value;
	   form.recipient_address02.value = form.buyer_address02.value;
	}
	if(form.equ.checked == false){
		form.recipient_name.value = "";
	   form.recipient_phone01.value = "";
	   form.recipient_phone02.value = "";
	   form.recipient_phone03.value = "";
	   form.recipient_hphone01.value = "";
	   form.recipient_hphone02.value = "";
	   form.recipient_hphone03.value = "";
	   form.recipient_zipcode01.value = "";
	   form.recipient_zipcode02.value = "";
	   form.recipient_address01.value = "";
	   form.recipient_address02.value = "";
	}

}


function mny_function(){

  form = document.purchase;

   var cost1,cost2,cost3,cost4;

	if(form.mileage_use.value) {
	  if(!IsNumber1(form.mileage_use.name)){
         alert("포인트는 숫자로 입력하셔야 합니다!");
		 form.mileage_use.value="";
	     form.mileage_use.focus();
	     return;
	  }
     cost1 = parseInt(form.mileage_use.value);
    }
    else{
      cost1 = 0;
     }

    cost2 = parseInt(form.mileage_tot.value);

    if(cost1 > cost2){
	  alert("포인트 사용금액이 보유액보다 클 수 없습니다!");
	  form.mileage_use.value="";
	  form.mileage_use.focus();
	  return;
	}
	else{
	  cost3 = parseInt(form.amount.value);
      cost4 = cost3 - cost1;
	  form.real_mny.value=cost4;
	}

}


// 사입주문
function sendOrder(form)
{
    if(!confirm('주문하신 내용이 정확합니까?')){
        return;
    }
/*
	if(!form.buyer_phone01.value){
		alert('구매자 전화번호를 입력하지 않았습니다.');
		form.buyer_phone01.focus();
		return;
	}
    if(!form.buyer_phone02.value){
		alert('구매자 전화번호를 입력하지 않았습니다.');
		form.buyer_phone02.focus();
		return;
	}
	if(!form.buyer_phone03.value){
		alert('구매자 전화번호를 입력하지 않았습니다.');
		form.buyer_phone03.focus();
		return;
	}
	if(!form.buyer_email.value){
		alert('이메일을 입력하지 않았습니다.');
		form.buyer_email.focus();
		return;
	}
    if (form.buyer_email.value.indexOf("@") < 0){
       alert('이메일 주소 형식이 틀립니다.');
       form.buyer_email.focus();
	   return;
     }

   if (form.buyer_email.value.indexOf("/") >= 0){
      alert('이메일 주소 형식이 틀립니다.');
      form.buyer_email.focus();
      return;
   }
   if(!form.buyer_address01.value){
		alert('구매자 주소를 입력하지 않았습니다.');
		form.buyer_address01.focus();
		return;
	}
 	if(!form.buyer_address02.value){
		alert('구매자 주소를 입력하지 않았습니다.');
		form.buyer_address02.focus();
		return;
	}

	if(!form.recipient_name.value){
		alert('수령자명을 입력하지 않았습니다.');
		form.recipient_name.focus();
		return;
	}
	if(!form.recipient_phone01.value){
		alert('수령자 전화번호를 입력하지 않았습니다.');
		form.recipient_phone01.focus();
		return;
	}
	if(!form.recipient_phone02.value){
		alert('수령자 전화번호를 입력하지 않았습니다.');
		form.recipient_phone02.focus();
		return;
	}
	if(!form.recipient_phone03.value){
		alert('수령자 전화번호를 입력하지 않았습니다.');
		form.recipient_phone03.focus();
		return;
	}
	if(!form.recipient_zipcode01.value || !form.recipient_zipcode02.value){
		alert('수령자 우편번호를 입력하지 않았습니다.');
		form.recipient_zipcode01.focus();
		return;
	}
	if(!form.recipient_address01.value){
		alert('수령자 주소를 입력하지 않았습니다.');
		form.recipient_address01.focus();
		return;
	}
*/
	form.submit();
}

// 위탁, 퀵배송 시
function sendDOrder(form)
{
	if(!form.recipient_name.value){
		alert('수령자명을 입력하지 않았습니다.');
		form.recipient_name.focus();
		return;
	}
	if(!form.recipient_hphone02.value){
		alert('수령자 휴대전화 번호를 입력하지 않았습니다.');
		form.recipient_hphone02.focus();
		return;
	}
	if(!form.recipient_hphone03.value){
		alert('수령자 휴대전화 번호를 입력하지 않았습니다.');
		form.recipient_hphone03.focus();
		return;
	}

	// if(!form.recipient_zipcode01.value || !form.recipient_zipcode02.value){
	// 	alert('수령자 우편번호를 입력하지 않았습니다.');
	// 	form.recipient_zipcode01.focus();
	// 	return;
	// }

	if(!form.recipient_address02.value){
		alert('수령자 주소를 입력하지 않았습니다.');
		form.recipient_address02.focus();
		return;
	}

    if(!confirm('주문수량을 다시 한번 확인하시기 바랍니다.')){
        return;
    }

	form.submit();
}

  function IsNumber(form, formname) {
     var form=eval("form." + formname);

	 for(var i=0; i < form.value.length; i++) {
	     var chr = form.value.substr(i,1);
		 if((chr < '0' || chr > '9')) {
		    return false;
		 }
     }
     return true;
  }

  function IsNumber1(formname) {
     var form=eval("document.purchase." + formname);

	 for(var i=0; i < form.value.length; i++) {
	     var chr = form.value.substr(i,1);
		 if((chr < '0' || chr > '9')) {
		    return false;
		 }
     }
     return true;
  }

function ZipWindow(ref,what) {
     var window_left = (screen.width-640)/2;
	 var window_top = (screen.height-480)/2;
	 ref = ref + "?from=" + what;
	 window.open(ref,"zipWin",'width=600,height=400,status=no,scrollbars=yes,top=' + window_top + ',left=' + window_left + '');
  }

function TrackInfo(x) {
    var no = x;
	// var url = 'http://www.hydex.net/ehydex/jsp/home/distribution/tracking/trackingViewCus.jsp?InvNo='+no;
	var url = 'https://www.ilogen.com/iLOGEN.Web.New/TRACE/TraceView.aspx?slipno='+no+'&gubun=slipno';
	var name = 'popup';
	var option = 'width=700, height=600, scrollbars=yes';

	window.open(url,name,option);
}

//레이어 열고 닫기
function ViewlayerPop(id){
	document.getElementById("layerPop"+id).style.display='inline';
}

function CloselayerPop(id){
    document.getElementById("layerPop"+id).style.display='none';
}

// 우편번호 검색창 자바스크립트
function checkInput(form){
   var form = document.zipsearch;
   if(!form.dong.value) {
      alert("찾기를 원하는 동을 입력하세요");
      form.dong.focus();
	    return false;
   }else{
       form.submit();
   }
}
//-->

<!-- 회원가입에서 호출  -->
function open_move1(zipcode,adr) {

   var form_object = eval("opener.document.form1");

      zip1=zipcode.substring(0,3);
      zip2=zipcode.substring(4,7);
      b=adr

      form_object.o_zipcode1.value = zip1;
      form_object.o_zipcode2.value = zip2;
      form_object.o_addr1.value = b;
	    form_object.o_addr2.focus();

      self.close();
}

<!-- 구매에서 호출 -->
function open_move2(zipcode,adr) {

   var form_object = eval("opener.document.purchase");

      zip1=zipcode.substring(0,3);
      zip2=zipcode.substring(4,7);
      b=adr

      form_object.buyer_zipcode01.value = zip1;
      form_object.buyer_zipcode02.value = zip2;
      form_object.buyer_address01.value = b;
	    form_object.buyer_address02.focus();

      self.close();
}

<!-- 구매에서 호출 -->
function open_move3(zipcode,adr) {

   var form_object = eval("opener.document.purchase");

      zip1=zipcode.substring(0,3);
      zip2=zipcode.substring(4,7);
      b=adr

      form_object.recipient_zipcode01.value = zip1;
      form_object.recipient_zipcode02.value = zip2;
      form_object.recipient_address01.value = b;
	  form_object.recipient_address02.focus();

      self.close();
}

<!-- 회원가입 배송지에서 호출  -->
function open_move4(zipcode,adr) {

   var form_object = eval("opener.document.form1");

      zip1=zipcode.substring(0,3);
      zip2=zipcode.substring(4,7);
      b=adr

      form_object.d_zipcode1.value = zip1;
      form_object.d_zipcode2.value = zip2;
      form_object.d_addr1.value = b;
	  form_object.d_addr2.focus();

      self.close();
}
<!-- 개인회원가입 배송지에서 호출  -->
function open_move5(zipcode,adr) {

   var form_object = eval("opener.document.form1");

      zip1=zipcode.substring(0,3);
      zip2=zipcode.substring(4,7);
      b=adr

      form_object.zipcode1.value = zip1;
      form_object.zipcode2.value = zip2;
      form_object.addr1.value = b;
	  form_object.addr2.focus();

      self.close();
}

function show_ssub(up) {
	form = document.category;

	val = form.mcode.value;
	location = 'm_sub_list.php?lcode='+up+'&mcode='+val;
}

function show_last(l, m) {
	form = document.category;

	val = form.scode.value;
	location = 'm_sub_list.php?lcode='+l+'&mcode='+m+'&scode='+val;
}



//-->
