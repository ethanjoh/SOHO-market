
function chkLogin() {
	var id = document.getElementById("admin_id");
	var pw = document.getElementById("admin_pass");

  	if ( !id.value.length ) {
    	alert("관리자 아이디를 입력하세요.");
    	return false;
  	}else if ( !pw.value.length ) {
    	alert("관리자 비밀번호를 입력하세요");
    	return false;
	}
}

function init(){
  setTimeout("location.reload();",300000); // 5 mins. 시간을 설정.
 }

function copy_send() {
	var form = document.form1;
	var re = confirm('상품을 복사하시겠습니까? ');
	if(re ==  true)
		form.submit();
}

function show_msub() {
	form = document.category;

	val = form.lcode.value;

   location = 'top_pro_list.php?lcode='+val;
}

function show_ssub(up) {
	form = document.category;

	val = form.mcode.value;
	location = 'top_pro_list.php?lcode='+up+'&mcode='+val;
}

function show_last(l, m) {
	form = document.category;

	val = form.scode.value;
	location = 'top_pro_list.php?lcode='+l+'&mcode='+m+'&scode='+val;
}

function sp_show_msub() {
	form = document.category;

	val = form.lcode.value;
	location = 'sp_products_list.php?lcode='+val;
}

function sp_show_ssub(up) {
	form = document.category;

	val = form.mcode.value;
	location = 'sp_products_list.php?lcode='+up+'&mcode='+val;
}

function sp_show_last(l, m) {
	form = document.category;

	val = form.scode.value;
	location = 'sp_products_list.php?lcode='+l+'&mcode='+m+'&scode='+val;
}

function show_calist(l, m, s) {
	form = document.category;

	for(var i = 0; i < form.view.length; i++) {
		if(form.view[i].checked) {
			var opt = form.view[i].value;
            location = 'top_pro_list.php?mode=search&lcode='+l+'&mcode='+m+'&scode='+s+'&view='+opt;
			break;
		}
	}
}

//top_member_list.php 에서 호출
function open_win(theURL, winName, features) {
  window.open(theURL, winName, features);
}


//mem_sendmail_list.php 에서 호출
var checkflag = "false";

function checkAll() {
    var form = document.form1;
	if (checkflag == "false") {
		for (var j = 0; j < form.elements.length; j++) {
			if(form.elements[j].name == "num[]"){
					if(form.elements[j].checked == false)
						form.elements[j].checked = true;
					}
		    }
		checkflag="true";
	}
	else if (checkflag == "true"){
		for (var j = 0; j < form.elements.length; j++) {
			if(form.elements[j].name == "num[]"){
					if(form.elements[j].checked == true)
						form.elements[j].checked = false;
					}
		}
		checkflag="false";
	}
}

function mail_send(){
  var form = document.form1;
  var no_count = 0;
	for(i=0; i < form.elements.length; i++){
		if(form.elements[i].name == "num[]"){
			if(form.elements[i].checked == true){
				no_count++;
			}
		}
	}

	if(no_count == 0){
		alert('선택된 항목이 없습니다');
		return;
	}
	// MM_openBrWindow('','msend','width=660,height=500,resizable=yes,top=50,left=50');

	// form.target = "msend";
	form.action = "mem_sendmail_form.php";
	form.submit();
}

function mail_send2(){
  var form = document.form1;
  var no_count = 0;
	for(i=0; i < form.elements.length; i++){
		if(form.elements[i].name == "num[]"){
			if(form.elements[i].checked == true){
				no_count++;
			}
		}
	}

	if(no_count == 0){
		alert('선택된 항목이 없습니다');
		return;
	}
	MM_openBrWindow('','msend','width=660,height=500,resizable=yes,top=50,left=50');

	form.target = "msend";
	form.action = "sendmail_form.php";
	form.submit();
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  winName = window.open(theURL,winName,features);
  winName.focus();
}

//mem_sendmail_each.php에서 호출
function send_check() {
	var form = document.mail;
	if(!form.sender.value){
		alert('보내는 사람 이름을 입력하지 않았습니다.');
		form.sender.focus();
		return;
	}

	if(!form.sender_email.value){
		alert('보내는 사람 이메일을 입력하지 않았습니다.');
		form.sender_email.focus();
		return;
	}

	if(!form.receiver.value){
		alert('받는 사람 이름을 입력하지 않았습니다.');
		form.receiver.focus();
		return;
	}

	if(!form.receiver_email.value){
		alert('받는 사람 이메일을 입력하지 않았습니다.');
		form.receiver_email.focus();
		return;
	}

	if(!form.subject.value){
		alert('메일 제목을 입력하지 않았습니다.');
		form.subject.focus();
		return;
	}

	if(!form.contents.value){
		alert('발송 내용을 입력하지 않았습니다.');
		form.contents.focus();
		return;
	}
	form.submit();
}

//ca_register.php 에서 호출
function form_send(){
  var form = document.f;

  if(!form.code.value) {
     alert("코드를 입력하세요.");
	 form.code.focus();
	 return ;
  }

  if(!form.ca_name.value) {
     alert("브랜드명을 입력하세요.");
	 form.ca_name.focus();
	 return ;
  }
  form.submit();
}

//ca_msub_register.php 에서 호출
function mform_send(){
  var form = document.form1;

  if(!form.code.value) {
     alert("코드를 입력하세요!");
	 form.code.focus();
	 return ;
  }

  if(!form.ca_mname.value) {
     alert("중분류명을 입력하세요!");
	 form.name.focus();
	 return ;
  }
  form.submit();
}

//ca_ssub_register.php 에서 호출
function sform_send(){
  var form = document.form1;

  if(!form.code.value) {
     alert("코드를 입력하세요!");
	 form.code.focus();
	 return ;
  }

  if(!form.ca_sname.value) {
     alert("소분류명을 입력하세요!");
	 form.name.focus();
	 return ;
  }
  form.submit();
}

//pro_register.php 에서 호출
function change_code() {

    document.form1.action = "pro_register.php?mode=insert";
	document.form1.submit();

}

function change_lcode(p_num, lcode) {

    document.form1.action = 'pro_register.php?mode=update&p_num=' + p_num + '&lcode=' + lcode;
    document.form1.submit();

}

function change_mcode(p_num, lcode, mcode) {

    document.form1.action = 'pro_register.php?mode=update&p_num=' + p_num + '&lcode=' + lcode + '&mcode=' + mcode;;
    document.form1.submit();

}


function sp_change_code() {
    document.form1.action = "sp_pro_register.php";
	document.form1.submit();
}

// 전송버튼 클릭시 호출
//상품등록 시 호출
function send_post(id)
{
 var form = document.form1;


  if(!form.name.value) {
     alert("상품명을 입력하세요!");
	 form.name.focus();
	 return ;
  }

 /*
 if(!form.origin.value) {
     alert("원산지를 입력하세요!");
	 form.origin.focus();
	 return ;
  }
  */

 if(!form.retail_price.value) {
     alert("판매가를 입력하세요!");
	 form.retail_price.focus();
	 return ;
  }

 if(form.retail_price.value) {
     if(!IsNumber(form.retail_price.name)){
         alert("상품가격은 숫자이어야 합니다!");
	     form.retail_price.focus();
	     return;
	  }
  }

  oEditors.getById[id].exec("UPDATE_CONTENTS_FIELD", []);
  form.submit();
}

function send_popup()
{
    var editor_val = CKEDITOR.instances.contents.document.getBody().getChild(0).getText() ;

    if (editor_val == '') {
        alert('내용을 입력하세요');
        return false;
    }

    document.form1.submit();

}

//주문상세 화면에서 품절 처리 시 호출
function send_edit() {
	var form = document.form1;
	form.submit();

}

function IsNumber(formname) {
     var form=eval("document.form1." + formname);

	 for(var i=0; i < form.value.length; i++) {
	     var chr = form.value.substr(i,1);
		 if((chr < '0' || chr > '9')) {
		    return false;
		 }
     }
     return true;
  }


//환경설정에서 호출

function setup_check() {
        var check=document.form1;

		if ( !check.admin_pass.value ) {
        alert('관리자 패스워드를 입력해 주십시오.');
		check.admin_pass.focus();
        return false;
        }
        else if ( !check.admin_pass1.value ) {
        alert('관리자 패스워드를 다시한번 입력해 주십시오.');
		check.admin_pass1.focus();
        return false;
        }
        else if ( check.admin_pass.value != check.admin_pass1.value ) {
        alert('관리자 패스워드와 확인하신 패스워드가 다릅니다.');
        return false;
        }
        else if (confirm('\n입력하신 모든 값들이 정확합니까?')) return true;
        return false;
}

//사업장 주소 사용하기
function useSameAddr(){
	var form = document.form1;

	if(form.same_info.checked == true){
			form.d_zipcode1.value = form.o_zipcode1.value;
			form.d_zipcode2.value = form.o_zipcode2.value;
			form.d_addr1.value = form.o_addr1.value;
			form.d_addr2.value = form.o_addr2.value;
			form.d_phone1.value = form.o_phone1.value;
			form.d_phone2.value = form.o_phone2.value;
			form.d_phone3.value = form.o_phone3.value;
			form.d_fax1.value = form.o_fax1.value;
			form.d_fax2.value = form.o_fax2.value;
			form.d_fax3.value = form.o_fax3.value;
	}else{
			form.d_zipcode1.value ="";
			form.d_zipcode2.value = "";
			form.d_addr1.value = "";
			form.d_addr2.value = "";
			form.d_phone1.value = "";
			form.d_phone2.value = "";
			form.d_phone3.value = "";
			form.d_fax1.value = "";
			form.d_fax2.value = "";
			form.d_fax3.value = "";
	}
}

 function check_ID_Window(ref) {
   var id= eval(document.form1.id);

   if(!id.value) {
      alert('아이디(ID)를 입력하신 후에 확인하세요!');
	  id.focus();
	  return;
   }else {
      ref = ref + "?id=" + id.value;
	  var window_left = (screen.width-640)/2;
	  var window_top = (screen.height-480)/2;
	  window.open(ref,"checkIDWin",'width=400,height=260,scrollbars=no,status=no,top=' + window_top + ',left=' + window_left + '');
   }
}

  function ZipWindow(ref, what) {
     var window_left = (screen.width-640)/2;
     var window_top = (screen.height-480)/2;
	 ref = ref+"?from="+what;
     window.open(ref,"zipWin",'scrollbars=yes,width=600,height=400,status=no,top=' + window_top + ',left=' + window_left + '');
  }

/* 발주서 작성 시 호출 */
function change() {
	var val = document.f.id.value;
	location = 'pre_offer.php?id='+val;
}

function show_sales(date1, date2) {
	var val = document.f1.id.value;
	location = 'sale_list.php?mode=com&date1='+date1+'&date2='+date2+'&id='+val;
}

function sel() {
	var txt = document.f.val;
	var x=document.getElementById("id");
    txt.value = x.options[x.selectedIndex].value;
}

function save_offer(){
  var form = document.form1;
  var b=0;
     for (i=0; i < form.elements.length; i++) {
		 if (form.elements[i].name =="chk[]") {
            if (form.elements[i].checked == true) {
			  b++;
			 }
	     }
	 }

	if(b == 0) {
	 alert("적어도 하나의 항목은 선택하셔야 합니다.");
	     return;
    }

   form.submit();
}
/* 공급업체 상품관리에서 호출 */
function change_com() {
	val = document.com.id.value;
	location = 'sp_products_list.php?id='+val;
}

function save_offer(){
  var form = document.form1;
  var b=0;
     for (i=0; i < form.elements.length; i++) {
		 if (form.elements[i].name =="chk[]") {
            if (form.elements[i].checked == true) {
			  b++;
			 }
	     }
	 }

	if(b == 0) {
	 alert("적어도 하나의 항목은 선택하셔야 합니다.");
	     return;
    }

   form.submit();
}

function TrackInfo(x) {
    var no = x;
	// var url = 'http://www.hydex.net/ehydex/jsp/home/distribution/tracking/trackingViewCus.jsp?InvNo='+no;
	var url = 'https://www.ilogen.com/iLOGEN.Web.New/TRACE/TraceView.aspx?slipno='+no+'&gubun=slipno';
	var name = 'popup';
	var option = 'width=700, height=600, scrollbars=yes';

	window.open(url,name,option);
}

function d_change(mode, no, key, key_value, page, status) {
	location = 'or_changed.php?mode='+mode+'&oid='+no+'&key='+key+'&key_value='+key_value+'&page='+page+'&status='+status;
}

//레이어 열고 닫기
function ViewlayerPop(id){
	document.getElementById("layerPop"+id).style.display='inline';
}

function CloselayerPop(id){
    document.getElementById("layerPop"+id).style.display='none';
}

function pay_change(mode, no, key, key_value, page) {
	location = 'or_changed.php?mode='+mode+'&oid='+no+'&key='+key+'&key_value='+key_value+'&page='+page;
}

function save() {
	var form = document.offerSaveForm;
	re = confirm('입고 수량 등을 확인하셨습니까?\n확정된 금액으로 입력됩니다.');
	if(re == true)
		form.submit();
}
function save_notice() {
  var form = document.offerExcelForm;
  re = confirm('공지로 등록하시겠습니까?');
  if(re == true)
    form.submit();
}

function getRate () {
	var retail_price = parseInt(document.getElementById('retail_price').value);
	var fixed_price = parseInt(document.getElementById('fixed_price').value);

	var rate = (1-(fixed_price / retail_price)) * 100;
	document.getElementById('downRate').value = rate;
	// priceRate.innerHTML = rate + '%↓';

}

function setPrice () {
	var retail_price = parseInt(document.getElementById('retail_price').value);
	var downRate = parseInt(document.getElementById('downRate').value)  / 100;
	var changed_price = (1 - downRate) * retail_price;

	document.getElementById('fixed_price').value = changed_price;

}

function buy_save(){
  var form = document.form1;
  // checkboxToHidden(form, form.num);


	// form.target = "msend";
	form.action = "product_list_ok.php";
	form.submit();
}
