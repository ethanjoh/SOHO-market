<!-- 이 파일은 SOHO-market 프로젝트의 변경 이력을 기록하는 CHANGELOG 파일입니다. -->

# CHANGELOG

이 문서는 SOHO-market 프로젝트의 최초 시작부터 현재까지의 전체 개발 변경 이력을 기록합니다. 주요 개발 마일스톤과 커밋 히스토리를 바탕으로 구조화되었습니다.

## [v1.5.4] - 2026-07-10 (admin/css 미사용 파일 8개 삭제)

### 아키텍처 개선 및 리팩토링 (Architecture & Refactoring)

- **`admin/css` 디렉토리 내 미사용 파일 정리**
  - PHP/HTML/JS 전체를 분석하여 단 한 곳에서도 참조되지 않는 파일 8개를 삭제하였습니다.
  - 삭제된 파일: `.DS_Store`, `autocomplete.css`, `bg_button_a.gif`, `bg_button_span.gif`, `shade.gif`, `shadeactive.gif`, `tabcontent.css`, `table.css`
  - 잔존 파일: 10개 (모두 실제 사용 중)

## [v1.5.3] - 2026-07-10 (admin/js 미사용 파일 13개 삭제)

### 아키텍처 개선 및 리팩토링 (Architecture & Refactoring)

- **`admin/js` 디렉토리 내 미사용 파일 정리**
  - PHP/HTML/CSS 전체를 분석하여 단 한 곳에서도 참조되지 않는 파일 13개를 삭제하였습니다.
  - 삭제된 파일: `autocomplete.js`, `custom.js`, `down.gif`, `external-dragging-calendar.js`, `floating-1.12.js`, `jquery-1.2.6.pack.js`, `jquery-ui-1.9.2.custom.min.js`, `jquery-ui.js`, `jquery.ui.autocomplete.html.js`, `morris-script.js`, `prototype-1.6.0.3.js`, `tabcontent.js`, `table.js`
  - 잔존 파일: 22개 (모두 실제 사용 중)

## [v1.5.2] - 2026-07-10 (미사용 tabcontent.js/css Dead Code 제거)

### 아키텍처 개선 및 리팩토링 (Architecture & Refactoring)

- **`tabcontent.js` 및 `tabcontent.css` 미사용 로드 구문 제거**
  - 세 파일에서 로드는 하고 있으나 실제 탭 메뉴 구조(`ddtabcontent()` 호출, 탭 HTML 구조)가 전혀 존재하지 않아 아무 기능도 하지 않는 Dead Code로 판명된 로드 구문을 제거하였습니다.
  - **대상 파일:** [pmem_sendmail_list.php](/admin/member/pmem_sendmail_list.php), [pmember_list.php](/admin/member/pmember_list.php), [main_setup.php](/admin/setting/main_setup.php)

## [v1.5.1] - 2026-07-10 (관리자단 구형 HTML 마크업 표준화 일괄 정리)

### 아키텍처 개선 및 리팩토링 (Architecture & Refactoring)

- **구형 HTML 마크업 패턴 3종 일괄 Cleanup**
  - 관리자단(`admin`) 전체 PHP/HTML 파일에 잔존하던 하위 호환 목적의 구형 마크업 패턴들을 HTML5 웹 표준에 맞게 일괄 정리하였습니다.
  - **① charset meta 태그 현대화:**
    - 변경 전: `<meta http-equiv="content-type" content="text/html; charset=UTF-8" />`
    - 변경 후: `<meta charset="UTF-8" />`
  - **② `<script>` 태그의 `language` 속성 제거:**
    - 변경 전: `<script language="JavaScript" src="...">`
    - 변경 후: `<script src="...">`
    - HTML5에서 JavaScript는 기본 스크립트 언어이므로 명시 불필요.
  - **③ 외부 스크립트 태그 내부 라이선스 주석 제거 (비표준 구조 정정):**
    - 변경 전: `<script src="...">/\* 라이선스 주석 \*/</script>`
    - 변경 후: `<script src="..."></script>`
    - 소스 `src` 속성이 있는 스크립트 태그 내부에 인라인 콘텐츠를 포함하는 것은 HTML 표준 위반이므로 제거.
  - **영향을 받은 파일:** 관리자단 내 PHP/HTML 파일 총 93개.

## [v1.5.0] - 2026-07-10 (관리자단 HTML 마크업 HTML5 표준화 일괄 적용)

### 아키텍처 개선 및 리팩토링 (Architecture & Refactoring)

- **XHTML 혼용 선언 → HTML5 표준 마크업 일괄 정규화**
  - 관리자단(`admin`) 전체 PHP/HTML 파일에서 구형 XHTML 혼용 방식으로 선언되어 있던 HTML 시작 태그를 HTML5 웹 표준에 맞게 일괄 정리하였습니다.
  - **변경 전:** `<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">`
  - **변경 후:** `<html lang="ko">`
  - XHTML의 XML 네임스페이스(`xmlns`) 속성 및 XML 다국어(`xml:lang`) 속성은 HTML5 문서에서는 불필요하므로 제거하여, 브라우저가 올바른 HTML5 렌더링 모드로 동작하고 마크업 유효성 검사 오류가 발생하지 않도록 정비하였습니다.
  - **영향을 받은 파일:** 관리자단 내 PHP/HTML 파일 총 50개.

## [v1.4.9] - 2026-07-10 (유실된 chromestyle.css 및 chrome.js 참조 구문 일괄 제거)

### 아키텍처 개선 및 리팩토링 (Architecture & Refactoring)

- **유실된 외부 라이브러리 참조 구문 일괄 Cleanup**
  - 실제 워크스페이스 내에서 파일이 유실되어 브라우저 콘솔에서 `404 Not Found` 및 자바스크립트 미동작 오류를 발생시키던 구형 드롭다운 메뉴용 `chromestyle.css` 및 `chrome.js` 로딩 구문을 일괄 삭제하였습니다.
  - **작업 방법:** 정규식(Regex) 기반의 일괄 소스코드 치환 스크립트([cleanup_chrome_menu.py](/scratch/cleanup_chrome_menu.py))를 작성하여 인코딩 깨짐 없이 안전하게 처리하였습니다.
  - **영향을 받은 파일:** 관리자단(`admin`) 내 공급업체 관리, 회원 관리, 주문 관리, 카테고리 관리 등 관련 PHP/HTML 파일 총 36개.

## [v1.4.8] - 2026-07-10 (스마트에디터를 공통 CKEditor로 전면 교체 및 구형 자산 제거)

### 아키텍처 개선 및 리팩토링 (Architecture & Refactoring)

- **네이버 스마트에디터(SmartEditor) ➡️ CKEditor 교체 마이그레이션**
  - 관리자단 내 스마트에디터를 사용 중이던 모든 폼을 이전에 구축한 단일 공통 [CKEditor](/bbs/ckeditor/ckeditor.js) 경로로 전면 이관하였습니다.
  - **대상 파일:**
    - 공급업체 관리: [sendmail_form.php](/admin/supplier/sendmail_form.php), [sp_pro_register.php](/admin/supplier/sp_pro_register.php)
    - 회원 관리: [pmem_sendmail_list.php](/admin/member/pmem_sendmail_list.php), [sendmail_each.php](/admin/member/inc/sendmail_each.php)
- **자바스크립트 전송 검증 함수 보강**
  - [admin/js/admin.js](/admin/js/admin.js)의 상품 등록용 `send_post()` 및 각 메일 전송 검증 함수 내부에서 폼 제출(Submit) 직전에 CKEditor 인스턴스의 변경 상태를 강제 바인딩하도록 `CKEDITOR.instances.contents.updateElement()` 구문을 추가하여 입력 데이터 유실 오류를 원천 차단했습니다.
- **네이버 스마트에디터 잔여 자산 완전 삭제 (Cleanup)**
  - 마이그레이션 완료 후 더 이상 참조되지 않는 스마트에디터 스킨 및 라이브러리 디렉토리 전체(`admin/supplier/SEditorSkin.html`, `admin/supplier/js/`, `admin/member/js/`, `admin/setting/js/` 등)를 완전히 제거하여 저장소 용량을 최적화하고 코드 파편화를 해결했습니다.

## [v1.4.7] - 2026-07-10 (CKEditor 공통 라이브러리 디렉토리 통합)

### 아키텍처 개선 및 리팩토링 (Architecture & Refactoring)

- **CKEditor 중복 자산 통합 및 정리**
  - 관리자단([admin/ckeditor](/admin/ckeditor))과 사용자 게시판단([bbs/ckeditor](/bbs/ckeditor))으로 중복 적재되어 대용량 리소스(약 15MB, 수천 개 파일)를 양분하고 있던 CKEditor 라이브러리를 `bbs/ckeditor` 경로 하나로 통합하였습니다.
  - 이를 통해 중복된 타사(Third-party) 정적 자산을 제거하여 소스 저장소 크기를 절감하고 개발 형상 관리를 최적화하였습니다.
- **관리자 공통 헤더 로드 경로 재매핑**
  - 관리자단 공통 헤더 파일([admin/include/header.php](/admin/include/header.php))에서 CKEditor 스크립트를 호출하던 경로를 새로운 통합 공통 경로인 `/bbs/ckeditor/ckeditor.js`로 변경하여, 관리자 내 모든 CKEditor 호출 프로세스가 공통 라이브러리를 안전하게 공유하도록 리팩토링하였습니다.

## [v1.4.6] - 2026-07-10 (장바구니 연산 중복 제거 및 결제 정보 구조 리팩토링)

### 아키텍처 개선 및 리팩토링 (Architecture & Refactoring)

- **장바구니 비즈니스 로직 단일 헬퍼 함수 분리 (`get_cart_items_data`)**
  - 장바구니 렌더링([show_cart_item](/util/shop-functions.php))과 주문서 요약([show_checkout_item](/util/shop-functions.php))에서 중복하여 사용하던 JOIN SQL 쿼리, 품절 상태 체크, 옵션 재고 파싱, 회원 그룹별 공급단가 결정 및 아이템 소계 연산 로직을 `get_cart_items_data()` 공통 데이터 공급 헬퍼 함수로 통합/추출하였습니다.
  - 이를 통해 유지보수 단일 지점을 생성하고 결합도를 크게 낮췄습니다.
- **`show_cart_item` & `show_checkout_item` 화면 출력 기능 정비**
  - 두 렌더링 함수 내부의 중복 연산 코드를 걷어내고, 공통 헬퍼 `get_cart_items_data()`가 공급해 주는 데이터 구조를 활용하여 HTML 템플릿(Table/Foot) 렌더링에만 순수하게 전담하도록 리팩토링하였습니다.
- **`show_buyer_info` 주문번호 생성 결합 해제 및 하위 호환성 마련**
  - 내부에서 임의로 OID 주문번호를 강제 발급하여 출력하던 타이트한 결합 구조에서, 매개변수 `$r_oid`를 전달받는 매개변수 주입식(Dependency Injection) 방식으로 개선하였습니다.
  - 매개변수가 생략된 경우에만 예외적으로 Fallback 자동 생성을 적용하여, 외부 호출 파일에 사이드 이펙트가 없도록 안전한 하위 호환성을 확보했습니다.

## [v1.4.5] - 2026-07-10 (금융기관 코드 공통 설정화 및 리팩토링)

### 아키텍처 개선 및 리팩토링 (Architecture & Refactoring)

- **금융기관 매핑 코드 분리 (`bank-codes.php` 신설)**
  - 결제(PG) 연동 시 은행 및 카드사 코드를 한글명으로 변환하기 위한 데이터를 관리하는 공통 설정 파일인 [bank-codes.php](/util/bank-codes.php) 파일을 신설하였습니다.
  - 가상계좌/실시간계좌이체용 `$BANK_CODES`, 일반 2자리 카드사용 `$CARD_CODES`, 5자리 상세 브랜드 카드사용 `$CARD_CODES_DETAIL` 전역 배열을 구성하였습니다.
- **`util/util.php` 내 하드코딩 제거 및 글로벌 변수 도입**
  - 기존 [util.php](/util/util.php) 파일의 `get_pg_info2` 및 `show_pay_data` 함수 내부에 중복 정의되어 있던 금융사 매핑 데이터를 제거하고, 신설된 `bank-codes.php`를 활용하는 구조로 리팩토링하였습니다.
  - 이를 통해 중복 코드를 제거하고 향후 신규 금융기관 및 카드 브랜드 추가 시 설정 파일 하나만 업데이트하면 되도록 구조적 유지보수성을 크게 강화하였습니다.

## [v1.4.4] - 2026-07-10 (공통 유틸리티 파일 버그 수정 및 리팩토링)

### 버그 수정 및 리팩토링 (Bug Fixes & Refactoring)

- **`get_pg_info2` 실시간계좌이체 금융사 매핑 오류 해결**
  - 실시간 계좌이체(`SC0030`) 처리 로직 내부에서 금융사 한글명 매핑 시 잘못 체크되던 신용카드(`SC0010`) 필터 조건을 `SC0030` 조건으로 수정하여 정상적으로 금융사명이 매핑되도록 버그를 수정하였습니다.
- **`make_thumbnail` 리소스 관리 및 메모리 누수 방지**
  - 썸네일 리샘플링(`else`) 처리 경로 등에서 누락되었던 원본 이미지 리소스 소멸 함수 `imagedestroy($img_sour)`를 공통 해제 구문으로 보강하여 대량 처리 시의 메모리 누수를 해결하였습니다.
  - WBMP 이미지 생성 및 출력 시 잘못 호출되던 `imagebmp` 함수를 규격에 맞춰 `imagewbmp` 함수로 정정하였습니다.
- **`del_html` XSS 필터링 보안 및 성능 강화**
  - 기존 수동 문자열 치환 방식 대신 싱글 쿼테이션과 앰퍼샌드를 포함해 안전하게 HTML 엔티티 치환을 수행하는 PHP 내장 함수 `htmlspecialchars($str, ENT_QUOTES, 'UTF-8')`로 변경하여 성능 및 보안 완성도를 높였습니다.

## [v1.4.3] - 2026-07-10 (쇼핑 유틸리티 함수 주석 문서화 및 검증)

### 문서화 및 가독성 개선 (Documentation & Readability)

- **쇼핑 유틸리티 함수 주석 표준화 및 보강**
  - [shop-functions.php](/util/shop-functions.php) 파일 내에 정의된 모든 사용자 정의 함수(총 39개)에 대해 PHPDoc 표준 포맷(`/** ... */`)의 상세한 한국어 주석을 추가 및 수정하였습니다.
  - 각 함수의 상세한 역할 설명과 매개변수(`@param`), 반환값(`@return`) 사양을 명시하였습니다.
  - 주석이 누락되었던 일부 함수(`show_horizon_brands`, `check_approved_id` 등)에 대해 신규 한국어 PHPDoc 주석을 작성하였습니다.
  - PHP syntax check(`php -l`)를 통해 구문 오류가 없음을 검증 완료하였습니다.

## [v1.4.2] - 2026-07-10 (유틸리티 함수 주석 문서화 및 가독성 개선)

### 문서화 및 가독성 개선 (Documentation & Readability)

- **유틸리티 함수 주석 표준화 및 보강**
  - [util.php](/util/util.php) 파일 내에 정의된 모든 사용자 정의 함수(총 67개)에 대해 PHPDoc 표준 포맷(`/** ... */`)의 상세한 한국어 주석을 추가하였습니다.
  - 각 함수의 상세한 역할 설명과 매개변수(`@param`), 반환값(`@return`), 사용되는 전역 변수(`global`) 사양을 명시하였습니다.
  - 인코딩 깨짐 현상으로 손상되어 읽기 어렵던 기존 구형 주석(예: `// ûϴ  ̵`, `// MYSQL` 등)을 맥락에 맞추어 정상적인 한국어로 복원 및 정비하였습니다.

## [v1.4.1] - 2026-07-10 (보안 리팩토링, PHP 호환성 확보 및 후이즈 SMS API 모듈 업데이트)

### 보안 및 히스토리 관리 (Security & Git History)

- **구글 API 키 히스토리 노출 제거**
  - 과거 커밋 히스토리에 노출되어 있던 구글 API 키를 `git-filter-repo` 도구를 사용하여 안전하게 제거(마스킹)하였습니다.
  - 해당 키는 모든 과거 커밋에서 `GOOGLE_API_KEY_REMOVED` 문자열로 영구 치환되었습니다.

### 후이즈 SMS API 모듈 업데이트 (Whois SMS API Integration)

- **후이즈 SMS 연동 방식 현대화 및 디버깅**
  - 기존 xmlrpc 연동 방식에서 JSON 및 HTTP POST 기반의 최신 후이즈 SMS API 규격으로 `class.EmmaSMS.php` 모듈을 전면 갱신하였습니다.
  - 최신 PHP 8.0 이상에서 객체 초기화가 누락되던 생성자 구조(`__construct`) 문제를 표준 생성자 방식으로 이전하여 호환성 오류를 방지하였습니다.
  - base64 인코딩을 거친 데이터를 전송하지 않고 원본 매개변수를 전송하여 문자 전송 실패를 유발하던 치명적인 변수 누락 버그(`json_encode($this->Args)` ➡️ `json_encode($args)`)를 수정하였습니다.
  - 모듈 상속 의존성 보장을 위해 `class.EmmaSMS.php` 내에 `class.http.php` 자동 포함 코드를 삽입하였습니다.

### 최신 PHP 버전 호환성 리팩토링 (PHP 7.x/8.x Compatibility)

- **구형 DB 함수 제거 및 에러 처리 표준화**
  - `bbs/db_connect.php`, `create_db.php` 등에서 호환성을 무너뜨리던 `mysql_error()`, `mysql_close()` 함수를 `mysqli_connect_error()`, `mysqli_error()` 등으로 표준화하였습니다.
  - BBS 처리 관련 6개 파일의 에러 수집 함수를 `mysqli_error($connect)`로 변경하였습니다.
- **삭제된 정규식 및 문자열 관련 함수 현대화**
  - `download.php`, `util.php`의 `ereg`/`eregi` 정규식 함수를 `preg_match` 및 `str_ireplace`로 변경하여 PHP 7.x 이상 환경에서의 Fatal Error를 방지하였습니다.
  - 메일 발송 유틸리티 파일 5개에서 매 80자마다 줄바꿈을 추가하던 구형 `ereg_replace` 코드를 표준 함수인 `chunk_split`으로 전면 교체하였습니다.
  - `util/xmlrpc.inc.php` 모듈 내에 잔존하던 구형 `ereg`, `split` 구문을 `preg_match`, `preg_replace`, `explode`, `preg_split`으로 치환하여 라이브러리 정상 동작을 유지시켰습니다.

---

## [v1.4.0] - 2016-09-22 ~ 2026-07-09 (결제 안정성 및 재고 정합성 강화, 보안 리팩토링, 토스페이먼츠 마이그레이션)

### 결제 게이트웨이(PG) 마이그레이션 (Toss Payments Migration)

- **토스페이먼츠(Toss Payments API v1) 도입**
  - 기존의 구형 LG U+ XPay 소켓 모듈(`XPayClient.php`)을 완전히 제거하고, 별도 바이너리나 서버 환경 의존성이 없는 표준 HTTP(cURL) REST API 기반의 토스페이먼츠 승인 연동 구조로 마이그레이션 완료
  - PC와 모바일의 개별 결제 진입점을 `/pay/payreq_toss.php` 경로로 단일화 및 최신 JavaScript SDK를 통한 크로스 플랫폼 결제창 호출 구현
  - 결제 진행 중 리다이렉션으로 유실되기 쉬운 주문서 정보(배송 메모, 수령인 주소 및 수동 입력 정보 등)를 결제 전 PHP 세션(`$_SESSION['toss_temp_order']`)에 임시 보존한 후, 승인 시점에서 복원(Post Mocking)하여 처리하는 데이터 이월 안전 구조 설계
  - 서버 간 안전한 결제 승인을 담당하는 `/pay/success_toss.php` 개발 및 U+ 변수 규격으로 역매핑하여 기존 주문 완료/SMS/이메일 후처리 로직의 안정적인 재사용 구현
  - 결제 실패 및 고객의 결제 취소 사유를 처리하고 장바구니로 안전하게 되돌려주는 `/pay/fail_toss.php` 개발
  - 가상계좌(무통장입금)의 비동기 입금 알림(`DEPOSIT_RECEIVED`) 및 가상계좌 발급 대기(`WAITING_FOR_DEPOSIT`) 이벤트를 수신하여 입금 상태 및 DB 주문 status를 실시간 갱신하는 웹훅 스크립트 `/pay/webhook_toss.php` 개발

### 버그 수정 (Bug Fixes)

- **결제 및 PG 연동**
  - UTF-8 BOM(Byte Order Mark) 헤더 문제로 인해 결제 수신 메시지(`resultMSG OK`)가 PG사(TossPayments) 서버에 전달되지 않던 결제 완료 통보 처리 버그 해결 (BOM 없는 UTF-8 포맷 파일 저장 적용)
  - 카드 전표 출력 포트 오류 수정 및 개발 환경용 테스트 포트 정리
  - 현금영수증 발행 표시 오류 정정
  - 주소 검색 API(우편번호 검색) 관련 오류 수정 및 회원가입 폼 프로토콜(HTTP/HTTPS) 보완
- **옵션 및 재고 관리**
  - 장바구니 담기 시점에 상품 옵션 재고 수량을 실시간 체크하여 초과 주문을 사전에 제어하는 로직 도입
  - 사용자 페이지에서 주문 취소 처리 시 옵션별 재고가 비정상적으로 복구되던 버그 정정
  - 단일 옵션 및 다중 옵션 품절(Sold Out) 표시가 노출되지 않던 오류 해결
  - 개인 구매 시 특정 조건에서 주문 가격이 잘못 산정되던 정합성 버그 수정
- **UI 및 웹 리소스**
  - 모바일 뷰포트에서 유튜브 임베디드 동영상의 너비(width)가 비정상적으로 늘어나던 반응형 버그 수정
  - 메인화면 공지사항 팝업 창 크기 조절
  - 배송조회 외부 링크 URL 수정

### 환경 설정 및 보안 (Security & Config)

- **환경 설정 파일 경로 보안화**
  - `util/util.php` 내 설정 파일 경로 파싱 방식을 절대 경로 하드코딩에서 `/[root]/config/config.ini` 형태의 일반화된 경로로 전환하여 실 운영 서버 환경 보안성 강화
- **파일 제외 및 문서화**
  - FTP 설정 파일(`sftp-config.json`), DB 접속 정보 및 PG사 API Key(`util/config.ini`), 백업 덤프 파일(`db_backup/`), 결제 로그 및 일반 로그(`pay/log/`, `pay/r_log.txt`)를 Git 추적에서 해제 및 `.gitignore` 설정 보완
  - 프로젝트 핵심 특징 및 웹호스팅 외부 DB 설정 가이드를 담은 [README.md](README.md) 작성

---

## [v1.3.0] - 2016-05-02 ~ 2016-07-22 (모바일 결제 확장 및 배송 시스템 세분화)

### 기능 추가 및 개선 (Features & Improvements)

- **모바일 결제 연동**
  - 모바일 디바이스에 대응하기 위한 스마트폰 전용 결제 모듈(`smartpay/`) 신설 및 결제 수단 변경 처리 지원
  - 모바일 페이지용 전용 로그인 폼 및 주문 리스트 반응형 화면 최적화
- **배송 시스템 고도화**
  - 제주 및 도서산간 지역 배송비(추가 배송비) 설정 및 정산 처리 추가
  - 기업 회원 전용 택배비 선불/착불 분리 처리 구현
  - 운송장 대량 업로드 및 운송장 발송 날짜 포맷팅 에러 수정

---

## [v1.2.0] - 2016-03-05 ~ 2016-04-30 (개인 회원 체계 및 메일링 시스템 도입)

### 기능 추가 및 개선 (Features & Improvements)

- **개인 회원 관리 체계 신설**
  - 기존 회원 체계에서 분리된 개인(소매) 회원 전용 로그인, 회원가입 폼, 정보 수정 기능 설계
  - 개인 회원 전용 구매 단가 책정 시스템 적용
  - 어드민 페이지 내 개인 회원 전용 주문 조회 목록 뷰 개발
- **메일링 및 편의 기능**
  - 가입 환영 이메일(HTML 템플릿), 아이디/비밀번호 찾기 메일, 주문 완료 및 명세서 자동 이메일 발송 기능 연동
  - 비밀번호 찾기 시 임시 비밀번호 메일 발송 및 초기화 보안 프로세스 보완
  - 사업자등록번호 유효성 검사 모듈 연동
- **어드민 및 통계**
  - 어드민 메인 대시보드 매출 통계용 차트 데이터 버그 수정
  - 주문 목록 조회 페이지(`order-list.php`) 로드 시 초기화 로직(`init()`) 탑재
  - 이용약관 및 개인정보처리방침(Privacy Policy) 개정 사항 반영

---

## [v1.1.0] - 2016-02-18 ~ 2016-03-05 (PG 결제 연동 및 데이터 관리 시스템 구축)

### 기능 추가 및 개선 (Features & Improvements)

- **토스페이먼츠(구 LG U+ XPay) 연동**
  - 신용카드 결제, 가상계좌 발급 및 에스크로 자동 구매 확인 연동 모듈 탑재
  - 가상계좌 입금 확인 시 중복 주문 데이터가 발생하는 예외 처리 해결
  - 결제 보안 프로토콜 및 결제창 팝업 z-index 충돌 오류 수정
- **상품 스키마 마이그레이션**
  - 상품명 필드를 옵션명으로 전환하고, 규격 정보를 `shortDesc` 필드로 이전하는 데이터 마이그레이션 실시
  - 상품 복사 기능 및 대표 이미지 노출 관련 오류 수정
- **데이터 반출입 및 어드민 고도화**
  - [PHPExcel] 엔진 연동을 통한 대량 상품 등록 및 정산 엑셀 반출입 기능 신설
  - 게시판(BBS) 모듈 탑재 및 본문 작성을 위한 [CKEditor] 통합
  - 쿠키(Cookie)를 활용한 팝업 "오늘 하루 이 창을 열지 않음" 숨김 기능 보완

---

## [v1.0.0] - 2016-01-19 ~ 2016-02-18 (초기 빌드 및 기본 커머스 아키텍처 수립)

### 기능 추가 (Core Setup)

- PHP 및 MySQL 환경 기반의 쇼핑몰/마켓 서비스 기본 아키텍처 설계
- 상품 기본 정보 등록, 카테고리 구성 및 전시 목록 페이지 구현
- 장바구니(Cart) 적재 및 회원/비회원 주문 결제 정보 매칭 비즈니스 로직 작성
- 어드민 기본 프레임워크 셋팅 및 주문 제어/접수 목록 관리자 페이지 구현
- 웹호스팅 환경에 대응하는 공통 데이터베이스 커넥터(`util/util.php`) 구성
