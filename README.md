<!-- 이 파일은 SOHO-market 쇼핑몰 프로젝트의 메인 소개 및 개발 문서인 README 파일입니다. -->

# SOHO-market

SOHO-market은 PHP 및 MySQL 환경 기반의 반응형 쇼핑몰(Commerce) 웹 서비스입니다. 다중 브랜드 관리, 옵션별 실시간 재고 관리, 토스페이먼츠(LG XPay) 결제 게이트웨이 연동 등의 핵심 커머스 기능이 탑재되어 있습니다.

기존에 10년 정도 실제 운영이 되었던 도/소매 쇼핑몰의 소스입니다. 현재는 운영되지 않고 보관용으로 리포지토리에 올렸습니다.
누구나 수정가능하며, 가져다 쓸 수 있는 오픈소스입니다.

현재는 개인 취미 차원에서 PHP 버전 업그레이드 작업을 할 예정입니다

![메인화면](soho-market.png)

---

## 🛠️ 기술 스택 (Tech Stack)

- **Backend**: PHP 8.x+ (mysqli 확장을 활용한 데이터베이스 핸들링)
- **Database**: MySQL / MariaDB
- **Frontend**: HTML5, CSS3, JavaScript (jQuery 기반 동적 UI 제어)
- **Libraries & Modules**:
  - [CKEditor](bbs/ckeditor): 게시판 및 관리자용 Rich Text 에디터 탑재
  - [TossPayments (구 LG U+ XPay)](lgpay): 신용카드, 에스크로, 현금영수증 API 연동 모듈 직접 탑재

---

## 🌟 핵심 기능 (Key Features)

1. **상품 및 브랜드 관리**
   - 다중 서브 카테고리를 활용한 정교한 상품 전시 구조
   - 브랜드별 전용 상품 필터링 및 관리자 제어 기능
2. **정밀한 옵션/재고 시스템**
   - 다중 옵션 적용 상품에 대한 실시간 재고 차감 및 주문 정합성 검증
   - 장바구니 적재 및 주문 시점의 초과 주문 차단 정책 반영
3. **통합 결제 시스템 (PG)**
   - 토스페이먼츠 API 연동을 통한 웹/모바일 결제 지원
   - 가상계좌 발급 통보 콜백 처리 및 현금영수증 발행 기능
   - 카드 매출전표 즉시 출력 및 부분 취소, 자동 에스크로 연동
4. **회원 서비스 및 보안 정책**
   - 일반 회원 및 개인 사업자 회원 체계 분리
   - 우편번호/주소 API 연동 및 세션 기반의 페이지 접근 제어 (`auth.php`)

---

## 📂 디렉토리 구조 (Directory Structure)

```bash
SOHO-market/
├── admin/          # 쇼핑몰 관리자 전용 제어 페이지 및 데이터 처리 (PHPExcel 포함)
├── bbs/            # 공통 게시판 모듈 및 CKEditor 엔진
├── css/ / fonts/   # 프론트엔드 스타일 및 레이아웃 웹폰트
├── db_backup/      # 데이터베이스 백업 덤프 저장 경로 (.gitignore 적용)
├── images/ / img/  # 공통 레이아웃용 정적 이미지 리소스
├── include/        # 헤더, 푸터 등 반복 레이아웃 조각 템플릿
├── js/             # 공통 스크립트 및 UI 제어 라이브러리
├── lib/            # 부가적인 프론트엔드/백엔드 공통 라이브러리
├── member/         # 회원가입, 로그인, 아이디/비밀번호 찾기 기능
├── pay/            # 일반 PC 결제 요청 및 응답(결제완료/취소) 처리 페이지
├── shop/           # 상품 전시, 장바구니, 주문 결제 정보 매칭 비즈니스 로직
├── smartpay/       # 모바일 최적화 결제 처리 모듈
├── upload/         # 상품 대표/상세 이미지 및 데이터 업로드 경로 (.gitignore 적용)
└── util/           # DB 커넥터 및 공통 헬퍼 함수 라이브러리 (config.ini 포함)
```

---

## 🔒 보안 및 초기 설정 가이드 (Security & Setup)

### 1. 데이터베이스 설정 (`config.ini`)

데이터베이스 설정 파일은 프로젝트 소스코드 내부가 아닌, **웹 루트 서버 디렉토리 외부**에 보관하여 정보가 웹상에 직간접적으로 노출되지 않도록 하는 아키텍처를 권장합니다.

실제 소스코드(`util/util.php`)는 아래와 같이 호스팅 디렉토리 외부 경로의 설정을 파싱하도록 설계되어 있습니다.

```php
$config = parse_ini_file('[웹호스팅 루트폴더]/config/config.ini');
```

만약 로컬/개발 환경에서 설정이 필요하다면 아래 내용을 참고하여 `util/config.ini`를 생성하되, 해당 설정 파일은 절대로 Git 저장소에 포함시키지 말아야 합니다. (이미 `.gitignore`에 제외 규칙이 등록되어 있습니다.)

#### `config.ini` 설정 예시

```ini
;db 셋팅
[db]
host   = "localhost"
dbid   = "DB_ID"
dbpass = "DB_PASSWORD"
dbname = "DB_NAME"
port   = "PORT"

;pg사 관련 셋팅
[pg]
mertkey = "TOSS_PAYMENTS_MERT_KEY"
cst_mid = "MERCHANT_MID"
cst_platform = "service"
```

### 2. Git 동기화 제외 정책

민감한 패스워드와 기밀 정보의 유출을 막기 위해 아래의 항목들은 `.gitignore` 설정을 통해 원격 Git 저장소(GitHub 등) 동기화 대상에서 차단되어 있습니다.

- FTP 설정 파일 (`sftp-config.json`)
- 로컬 DB 및 PG 키 설정 파일 (`util/config.ini`, `lgpay/conf/*.conf` 등)
- DB 백업 폴더 (`db_backup/` 아래의 모든 `.sql` 파일)
- 결제 및 시스템 로그 (`pay/log/`, `pay/r_log.txt` 등)
- 미디어 및 상품 이미지 업로드 경로 (`upload/`)
