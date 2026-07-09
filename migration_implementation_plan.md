# 토스페이먼츠 최신 API 결제 연동 마이그레이션 구현 계획

이 계획서는 서버 환경에 의존적이고 노후화된 구형 결제 모듈(LG U+ XPay 소켓 라이브러리)을 제거하고, 별도의 모듈 설치 없이 표준 HTTP(cURL) 통신을 사용하는 **토스페이먼츠 최신 API(SDK 및 REST API)**로 교체하기 위한 구현 계획입니다.

---

## User Review Required

> [!IMPORTANT]
> **데이터 보존 방식 (임시 세션 활용)**
> 기존 LG U+ 결제창 연동은 결제 전 입력한 수령인/주소/배송메모 등을 브라우저 폼을 통해 최종 승인 페이지로 이월(Form forwarding)하는 구조였습니다.
> 토스페이먼츠 최신 API는 클라이언트 SDK 호출 방식으로 리다이렉트되어 정보가 소실될 수 있으므로, 결제창을 띄우기 직전에 입력한 배송지 정보를 **PHP 세션(`$_SESSION['toss_temp_order']`)에 안전하게 백업**한 뒤 승인 완료 시점에서 복원하여 DB에 저장하는 우회 방식을 적용합니다.
> 이 방식을 통해 **데이터베이스 테이블 구조 변경(Schema 변경) 없이 안전하고 빠르게 마이그레이션을 완료**할 수 있습니다.

---

## Proposed Changes

### [Payment Gateway Migration]

#### [MODIFY] [shop/checkout.php](file:///e:/개인_백업/www/SOHO-market/shop/checkout.php)
- 모바일/PC 구분 없이 결제 요청 진입 URL을 신규 생성할 토스페이 결제 요청 페이지(`pay/payreq_toss.php`)로 통일합니다.

```diff
-if (preg_match('/.../i', $useragent)) {
-    $payUrl = "/smartpay/payreq_crossplatform.php";
-} else {
-    $payUrl = "/pay/payreq_crossplatform.php";
-}
+$payUrl = "/pay/payreq_toss.php";
```

---

#### [NEW] [pay/payreq_toss.php](file:///e:/개인_백업/www/SOHO-market/pay/payreq_toss.php)
- 새로운 결제 진입 파일입니다. (첫 줄 주석 규칙 준수)
- 역할: `checkout.php`에서 넘어온 배송지 정보(`$_POST`)를 `$_SESSION['toss_temp_order']`에 백업합니다.
- 토스페이먼츠 최신 JavaScript SDK를 연동해 자동으로 결제창(카드/가상계좌 등 고객 선택에 맞춤)을 호출합니다.

---

#### [NEW] [pay/success_toss.php](file:///e:/개인_백업/www/SOHO-market/pay/success_toss.php)
- 결제 인증 성공 시 호출되는 콜백 페이지입니다. (첫 줄 주석 규칙 준수)
- 역할:
  - 넘어온 `paymentKey`, `orderId`, `amount`를 사용해 토스페이먼츠 API 서버(`https://api.tosspayments.com/v1/payments/confirm`)로 최종 승인 cURL 요청을 보냅니다.
  - 승인이 성공하면, 세션에 저장해둔 주문 정보를 복원합니다.
  - 기존 `pay/payres.php`에 정의된 비즈니스 로직(DB `mall_order` 및 `pg_info` 저장, 장바구니 삭제, 이메일/SMS 전송)을 그대로 승계하여 실행하고 주문 완료 화면을 출력합니다.

---

#### [NEW] [pay/fail_toss.php](file:///e:/개인_백업/www/SOHO-market/pay/fail_toss.php)
- 결제창 취소 또는 한도 초과 등으로 결제 인증 실패 시 호출되는 안전장치 페이지입니다. (첫 줄 주석 규칙 준수)
- 역할: 실패 코드 및 에러 메시지를 표시하고, 장바구니/주문서 페이지로 되돌아가는 기능을 제공합니다.

---

#### [NEW] [pay/webhook_toss.php](file:///e:/개인_백업/www/SOHO-market/pay/webhook_toss.php)
- 가상계좌(무통장입금) 결제 완료 웹훅을 수신하는 전용 비동기 스크립트입니다. (첫 줄 주석 규칙 준수)
- 역할: 토스페이먼츠 웹훅 양식(`DEPOSIT_RECEIVED`)에 맞춰 가상계좌 입금 알림이 도달하면 DB 내 주문 상태를 '입금완료'로 즉시 갱신합니다.

---

## Verification Plan

### Manual Verification
1. **결제 테스트 진입 검증**
   - 상품을 장바구니에 담은 후 주문서(`checkout.php`) 페이지에서 주소 및 수령인 등을 입력하고 결제 버튼을 누릅니다.
   - 세션에 데이터가 정상 임시 적재되고, 토스페이먼츠 카드사 결제창 및 간편결제 팝업창이 올바르게 뜨는지 확인합니다.
2. **테스트 결제(API Sandbox) 및 승인 프로세스 검증**
   - 토스 테스트 결제창에서 테스트 카드로 인증을 완료합니다.
   - `success_toss.php`로 넘어와서 백엔드 승인이 성공하고, 세션 복원을 통해 DB의 `mall_order` 및 `pg_info` 테이블에 정상 입력되는지 데이터베이스를 대조합니다.
   - 장바구니가 올바르게 비워지고 완료 페이지가 표시되는지 확인합니다.
3. **가상계좌 웹훅 시뮬레이션**
   - 가상계좌 발급 후 토스 개발자센터 웹훅 시뮬레이터를 사용해 입금 완료 데이터를 전송하고, `webhook_toss.php`를 거쳐 DB 상태가 성공적으로 변경되는지 검증합니다.
