<!--
//사업장 주소 사용하기
function useSameAddr(){
	var form = document.form1;

	if(form.same_info.checked == true){
			form.d_zipcode1.value = form.o_zipcode1.value;
			// form.d_zipcode2.value = form.o_zipcode2.value;
			form.d_addr1.value = form.o_addr1.value;
			form.d_addr2.value = form.o_addr2.value;
      form.d_phone.value = form.o_phone.value;
      form.d_fax.value = form.o_fax.value;
	}else{
			form.d_zipcode1.value ="";
			// form.d_zipcode2.value = "";
			form.d_addr1.value = "";
			form.d_addr2.value = "";
			form.d_phone.value = "";
			form.d_fax.value = "";
	}
}

function checkRegister(){
   var form = document.form1;

  if(!form.id.value) {
     alert("아이디(ID)를 입력하세요.");
	 form.id.focus();
	 return ;
  }
  if(!IsID(form.id.name)) {
     alert("아이디는 4~10자의 영문소문자 숫자 또는 조합된 문자열이어야 합니다.");
     form.id.focus();
	 form.id.select();
	 return ;
  }

  if(!form.passwd.value) {
     alert("비밀번호를 입력하세요.");
	 form.passwd.focus();
	 return ;
  }
    if(!IsPW(form.passwd.name)) {
     alert("비밀번호는 4~10자의 영문자나 숫자 또는 조합된 문자열이어야 합니다.");
	 form.passwd.focus();
	 form.passwd.select();
	 return;
  }

  if(form.passwd.value != form.passwd2.value) {
     alert("입력하신 비밀번호가 일치하지 않습니다.\n다시 확인하시고 넣어주세요.");
	 form.passwd2.focus();
	 form.passwd2.select();
	 return;
  }

  if(!form.md_name.value) {
     alert("담당자를 기재해 주세요.");
   form.md_name.focus();
   return;
  }

  if(!form.md_hphone2.value) {
     alert("담당자 연락처를 기재해 주세요.");
   form.md_hphone2.focus();
   return;
  }

  if(!form.license_no1.value) {
     alert("사업자등록번호를 입력하세요.");
	 form.license_no1.focus();
	 return;
  }

   if(form.license_no1.value) {
	  if(!IsNumber(form.license_no1.name)){
         alert("사업자등록번호는 숫자이어야 합니다.");
	     form.license_no1.focus();
	     return;
	  }
   }

  if(!form.license_no2.value) {
     alert("사업자등록번호를 입력하세요.");
	 form.license_no2.focus();
	 return;
  }

   if(form.license_no2.value) {
	  if(!IsNumber(form.license_no2.name)){
         alert("사업자등록번호는 숫자이어야 합니다.");
	     form.license_no2.focus();
	     return;
	  }
   }

  if(!form.license_no3.value) {
     alert("사업자등록번호를 입력하세요.");
	 form.license_no3.focus();
	 return;
  }

   if(form.license_no3.value) {
	  if(!IsNumber(form.license_no3.name)){
         alert("사업자등록번호는 숫자이어야 합니다.");
	     form.license_no3.focus();
	     return;
	  }
   }

  if(!form.company_name.value) {
     alert("상호명(법인명)을 입력하세요.");
   form.company_name.focus();
   return;
  }

  if(!form.open_year.value) {
     alert("개업년월일을 입력하세요.");
   form.ceo.focus();
   return;
  }

  if(!form.ceo.value) {
     alert("대표자 성명을 입력하세요.");
	 form.ceo.focus();
	 return;
  }

  if(!form.o_zipcode1.value) {
     alert("사업장 소재지 우편번호를 입력하세요.");
   form.o_zipcode1.focus();
   return;
  }

  if(!form.o_addr1.value) {
     alert("사업장 소재지를 입력하세요.");
	 form.o_addr1.focus();
	 return;
  }

  if(!form.category1.value) {
     alert("업태를 입력하세요.");
	 form.category1.focus();
	 return;
  }

  if(!form.category2.value) {
     alert("종목을 입력하세요.");
	 form.category2.focus();
	 return;
  }


  if(!form.o_phone1.value) {
     alert("전화번호를 입력하세요.");
     form.o_phone1.focus();
	 return;
  }

  if(!form.o_phone2.value) {
     alert("전화번호를 입력하세요.");
     form.o_phone2.focus();
	 return;
  }
  if(!form.o_phone3.value) {
     alert("전화번호를 입력하세요.");
     form.o_phone3.focus();
	 return;
  }

  if(form.o_phone1.value) {
     if(!IsNumber(form.o_phone1.name)){
         alert("전화번호는 숫자이어야 합니다.");
	     form.o_phone1.focus();
	     return;
	  }
   }

  if(form.o_phone2.value) {
     if(!IsNumber(form.o_phone2.name)){
         alert("전화번호는 숫자이어야 합니다.");
	     form.o_phone2.focus();
	     return;
	  }
  }

   if(form.o_phone3.value) {
     if(!IsNumber(form.o_phone3.name)){
         alert("전화번호는 숫자이어야 합니다.");
	     form.o_phone3.focus();
	     return;
	  }
   }

 if(!form.d_zipcode1.value) {
     alert("배송지 우편번호를 입력하세요.");
   form.d_zipcode1.focus();
   return;
  }

  if(!form.d_addr1.value) {
     alert("배송지를 입력하세요.");
   form.d_addr1.focus();
   return;
  }


  if(!form.md_email.value) {
     alert("이메일을 입력하세요.");
     form.email.focus();
	 return;
   }

 //   if (form.md_email.value.indexOf("@") < 0){
 //    alert('이메일 주소 형식이 틀립니다.');
 //    form.md_email.focus();
	// return;
 //   }

 //   if (form.md_email.value.indexOf("/") >= 0){
 //     alert('이메일 주소 형식이 틀립니다.');
 //     form.md_email.focus();
 //     return;
 //    }


   if (form.uploadedfile.value.indexOf("/") >= 0){
     alert('사업자등록증 사본을 첨부해 주세요.');
     form.uploadedfile.focus();
     return;
  }

  form.submit();
  }


function checkRegisterP(){
   var form = document.form1;

  if(!form.id.value) {
     alert("아이디(ID)를 입력하세요!");
	 form.id.focus();
	 return ;
  }
  if(!IsID(form.id.name)) {
     alert("아이디는 4~10자의 영문소문자 숫자 또는 조합된 문자열이어야 합니다!");
     form.id.focus();
	 form.id.select();
	 return ;
  }

  if(!form.passwd.value) {
     alert("비밀번호를 입력하세요!");
	 form.passwd.focus();
	 return ;
  }
    if(!IsPW(form.passwd.name)) {
     alert("비밀번호는 4~10자의 영문자나 숫자 또는 조합된 문자열이어야 합니다!");
	 form.passwd.focus();
	 form.passwd.select();
	 return;
  }

  if(form.passwd.value != form.passwd2.value) {
     alert("입력하신 비밀번호가 일치하지 않습니다.\n다시 확인하시고 넣어주세요.");
	 form.passwd2.focus();
	 form.passwd2.select();
	 return;
  }

  if(!form.addr1.value) {
     alert("배송지를 입력하세요.");
	 form.addr1.focus();
	 return;
  }


  if(!form.hphone1.value) {
     alert("전화번호를 입력하세요!");
     form.hphone1.focus();
	 return;
  }

  if(!form.hphone2.value) {
     alert("전화번호를 입력하세요!");
     form.hphone2.focus();
	 return;
  }
  if(!form.hphone3.value) {
     alert("전화번호를 입력하세요!");
     form.hphone3.focus();
	 return;
  }


  if(form.hphone2.value) {
     if(!IsNumber(form.hphone2.name)){
         alert("전화번호는 숫자이어야 합니다!");
	     form.hphone2.focus();
	     return;
	  }
  }

   if(form.hphone3.value) {
     if(!IsNumber(form.hphone3.name)){
         alert("전화번호는 숫자이어야 합니다!");
	     form.hphone3.focus();
	     return;
	  }
   }


  if(!form.email.value) {
     alert("이메일을 입력하세요!");
     form.email.focus();
	 return;
   }

   if (form.email.value.indexOf("@") < 0){
    alert('이메일 주소 형식이 틀립니다.');
    form.email.focus();
	return;
   }

  form.submit();
  }


function checkEdit(){
   var form = document.form1;

  if(!form.passwd.value) {
     alert("비밀번호를 입력하세요.");
	 form.passwd.focus();
	 return ;
  }
    if(!IsPW(form.passwd.name)) {
     alert("비밀번호는 4 ~ 10자의 영문자나 숫자 또는 조합된 문자열이어야 합니다.");
	 form.passwd.focus();
	 form.passwd.select();
	 return;
  }

  if(!form.o_phone1.value) {
     alert("전화번호를 입력하세요!");
     form.o_phone1.focus();
	 return;
  }

  if(!form.o_phone2.value) {
     alert("전화번호를 입력하세요!");
     form.o_phone2.focus();
	 return;
  }
  if(!form.o_phone3.value) {
     alert("전화번호를 입력하세요!");
     form.o_phone3.focus();
	 return;
  }

  if(form.o_phone1.value) {
     if(!IsNumber(form.o_phone1.name)){
         alert("전화번호는 숫자이어야 합니다!");
	     form.o_phone1.focus();
	     return;
	  }
   }

  if(form.o_phone2.value) {
     if(!IsNumber(form.o_phone2.name)){
         alert("전화번호는 숫자이어야 합니다!");
	     form.o_phone2.focus();
	     return;
	  }
  }

   if(form.o_phone3.value) {
     if(!IsNumber(form.o_phone3.name)){
         alert("전화번호는 숫자이어야 합니다!");
	     form.o_phone3.focus();
	     return;
	  }
   }


  if(!form.md_email.value) {
     alert("이메일을 입력하세요!");
     form.md_email.focus();
	 return;
   }

   if (form.md_email.value.indexOf("@") < 0){
    alert('이메일 주소 형식이 틀립니다.');
    form.md_email.focus();
	return;
   }

   if (form.md_email.value.indexOf("/") >= 0){
     alert('이메일 주소 형식이 틀립니다.');
     form.md_email.focus();
     return;
    }

  form.submit();

 }

//개인회원정보 수정
function checkEdit2(){
   var form = document.form1;

  if(!form.passwd.value) {
     alert("비밀번호를 입력하세요.");
	 form.passwd.focus();
	 return ;
  }
    if(!IsPW(form.passwd.name)) {
     alert("비밀번호는 4 ~ 10자의 영문자나 숫자 또는 조합된 문자열이어야 합니다.");
	 form.passwd.focus();
	 form.passwd.select();
	 return;
  }

  if(!form.phone1.value) {
     alert("전화번호를 입력하세요!");
     form.phone1.focus();
	 return;
  }

  if(!form.phone2.value) {
     alert("전화번호를 입력하세요!");
     form.phone2.focus();
	 return;
  }
  if(!form.phone3.value) {
     alert("전화번호를 입력하세요!");
     form.phone3.focus();
	 return;
  }

  if(form.phone1.value) {
     if(!IsNumber(form.phone1.name)){
         alert("전화번호는 숫자이어야 합니다!");
	     form.phone1.focus();
	     return;
	  }
   }

  if(form.phone2.value) {
     if(!IsNumber(form.phone2.name)){
         alert("전화번호는 숫자이어야 합니다!");
	     form.phone2.focus();
	     return;
	  }
  }

   if(form.phone3.value) {
     if(!IsNumber(form.phone3.name)){
         alert("전화번호는 숫자이어야 합니다!");
	     form.phone3.focus();
	     return;
	  }
   }


  if(!form.email.value) {
     alert("이메일을 입력하세요!");
     form.email.focus();
	 return;
   }

   if (form.email.value.indexOf("@") < 0){
    alert('이메일 주소 형식이 틀립니다.');
    form.email.focus();
	return;
   }

   if (form.email.value.indexOf("/") >= 0){
     alert('이메일 주소 형식이 틀립니다.');
     form.email.focus();
     return;
    }

  form.submit();

 }

function changePasswd() {
	var form = document.form2;

    if(!form.ch.checked) {
      alert("체크박스에 체크해 주세요.");
      return;
    }

	  if(form.passwd2.value != form.passwd3.value) {
     alert("입력하신 비밀번호가 일치하지 않습니다.\n다시 확인하시고 넣어주세요.");

  	 form.passwd3.focus();
  	 form.passwd3.select();
  	 return;
  }

  form.submit();
}


//개인회원 비번 변경
function changePasswd2() {
	var form = document.form2;
	  if(form.passwd2.value != form.passwd3.value) {
     alert("입력하신 비밀번호가 일치하지 않습니다.\n다시 확인하시고 넣어주세요.");
	 form.passwd2.focus();
	 form.passwd2.select();
	 return;
  }

  form.submit();
}

function lost_checkInput1(){
   var form = document.form1;

  if(!form.md_email.value) {
     alert("이메일 주소를 입력하세요");
	 form.md_email.focus();
	 return ;
  }

  if(!form.license_no1.value) {
     alert("사업자등록번호를 입력하세요");
	 form.license_no1.focus();
	 return;
  }

   if(form.license_no1.value) {
	  if(!IsNumber(form.license_no1.name)){
         alert("사업자등록번호는 숫자이어야 합니다");
	     form.license_no1.focus();
	     return;
	  }
   }

  if(!form.license_no2.value) {
     alert("사업자등록번호를 입력하세요");
	 form.license_no2.focus();
	 return;
  }

   if(form.license_no2.value) {
	  if(!IsNumber(form.license_no2.name)){
         alert("사업자등록번호는 숫자이어야 합니다");
	     form.license_no2.focus();
	     return;
	  }
   }

  if(!form.license_no3.value) {
     alert("사업자등록번호를 입력하세요");
	 form.license_no3.focus();
	 return;
  }

   if(form.license_no3.value) {
	  if(!IsNumber(form.license_no3.name)){
         alert("사업자등록번호는 숫자이어야 합니다");
	     form.license_no3.focus();
	     return;
	  }
   }

   form.submit();
}


function lost_checkInput2(){
	   var form = document.form2;

	  if(!form.id.value) {
		 alert("ID를 입력하세요!");
		 form.id.focus();
		 return ;
	  }

  if(!form.license_no1.value) {
     alert("사업자등록번호를 입력하세요!");
	 form.license_no1.focus();
	 return;
  }

   if(form.license_no1.value) {
	  if(!IsNumber(form.license_no1.name)){
         alert("사업자등록번호는 숫자이어야 합니다!");
	     form.license_no1.focus();
	     return;
	  }
   }

  if(!form.license_no2.value) {
     alert("사업자등록번호를 입력하세요!");
	 form.license_no2.focus();
	 return;
  }

   if(form.license_no2.value) {
	  if(!IsNumber(form.license_no2.name)){
         alert("사업자등록번호는 숫자이어야 합니다!");
	     form.license_no2.focus();
	     return;
	  }
   }

  if(!form.license_no3.value) {
     alert("사업자등록번호를 입력하세요!");
	 form.license_no3.focus();
	 return;
  }

   if(form.license_no3.value) {
	  if(!IsNumber(form.license_no3.name)){
         alert("사업자등록번호는 숫자이어야 합니다!");
	     form.license_no3.focus();
	     return;
	  }
   }

   form.submit();
  }


function focus_move(){
 var str = document.form1.license_no1.value.length;
 var str2 = document.form1.license_no2.value.length;

  if(str == 3)
	 document.form1.license_no2.focus();
  if(str2 == 2)
	document.form1.license_no3.focus();

}

function focus_move2(){
 var str = document.form2.jumin1.value.length;
  if(str == 6)
	document.form2.jumin2.focus();
}


 function IsID(formname) {
     var form=eval("document.form1." + formname);

     if(form.value.length < 4 || form.value.length > 10) {
         return false;
     }
     for(var i=0; i < form.value.length; i++) {
         var chr = form.value.substr(i,1);
         if((chr < '0' || chr > '9') && (chr < 'a' || chr > 'z')) {
            return false;
         }
     }
     return true;
  }

  function IsPW(formname) {
     var form=eval("document.form1." + formname);

     if(form.value.length < 4) {
         return false;
     }
     for(var i=0; i < form.value.length; i++) {
         var chr = form.value.substr(i,1);
         if((chr < '0' || chr > '9') && (chr < 'a' || chr > 'z') && ( chr < 'A' || chr > 'Z')) {
            return false;
         }
     }
     return true;
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
	  window.open(ref,"checkIDWin",'width=400,height=200,scrollbars=no,status=no,top=' + window_top + ',left=' + window_left + '');
   }
}

  function ZipWindow(ref, what) {
     var window_left = (screen.width-640)/2;
     var window_top = (screen.height-480)/2;
	 ref = ref+"?from="+what;
     window.open(ref,"zipWin",'scrollbars=yes,width=420,height=250,status=no,top=' + window_top + ',left=' + window_left + '');
  }

function registerConfirm() {
  $.validator.addMethod('license_no', function (value, element) {
    return this.optional(element) || /^\d{3}-\d{2}-\d{5}$/.test(value);
  }, "형식에 맞게 입력해 주세요");

  $.validator.addMethod('phonenum', function (value, element) {
    return this.optional(element) || /^\d{2,4}-\d{3,4}-\d{4}$/.test(value);
  }, "형식에 맞게 입력해 주세요");

  $.validator.addMethod('mobilenum', function (value, element) {
    return this.optional(element) || /^\d{3}-\d{3,4}-\d{4}$/.test(value);
  }, "형식에 맞게 입력해 주세요");

  $( "#form1" ).validate({
    rules: {
      userid      : { minlength: 4, maxlength: 10 },
      passwd2     : { equalTo: "#passwd" },
      license_no  : { license_no: true },
      md_hphone   : { mobilenum: true },
      o_phone     : { phonenum: true },
      o_fax       : { phonenum: true },
      d_phone     : { phonenum: true },
      d_fax       : { phonenum: true },
      homepage    : { url: true }
      // uploadedfile: { accept: "image/*" }
    },

    submitHandler: function(form) {
      form.submit();
    }

  });
}

function onopen(wrkr_no) {
  var url = "http://www.ftc.go.kr/info/bizinfo/communicationViewPopup.jsp?wrkr_no="+wrkr_no;
  window.open(url, "communicationViewPopup", "width=750, height=700;");
}

function goto(url) {
  location.href = url;
}
//-->

