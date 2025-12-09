<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.10.25>
	// Description:	<메뉴>	
    // Update: Fix Mobile Browser Bottom Bar Issue (100dvh & Padding)
	// =============================================
?>

<style>
    /* [중요] 페이지 전체에서 '당겨서 새로고침' 방지 */
    html, body {
        overscroll-behavior-y: none !important;
    }

    /* 모바일 사이드바 디자인 및 오버레이 설정 */
    @media (max-width: 768px) {
        /* 1. 사이드바 컨테이너: 오버레이 및 확장 설정 */
        #accordionSidebar {
            position: fixed !important;
            top: 0;
            left: 0;
            width: 70vw !important;     /* 화면의 70% 너비 */
            
            /* [핵심 수정] 높이 설정 변경 */
            height: 100vh;              /* 기본값 */
            height: 100dvh;             /* 모바일 브라우저 툴바를 제외한 '실제 보이는 높이' 적용 */
            
            z-index: 2000;              /* 최상단 표시 */
            box-shadow: 10px 0 30px rgba(0,0,0,0.5); /* 그림자 효과 */
            overflow-y: auto;           /* 내부 스크롤 허용 */
            
            /* 사이드바 내부 스크롤 체이닝 방지 */
            overscroll-behavior-y: contain; 
            
            transition: all 0.3s ease;  /* 부드러운 효과 */
            padding-top: 10px;

            /* [핵심 수정] 하단 툴바에 가려지지 않도록 충분한 여백 추가 */
            padding-bottom: 120px !important; 
        }

        /* 닫힘 상태 (숨김) */
        #accordionSidebar.toggled {
            width: 0 !important;
            padding: 0 !important;
            overflow: hidden;
            box-shadow: none;
            opacity: 0;
        }

        /* 2. 디자인 개선 (로고, 메뉴 등) */
        #accordionSidebar .sidebar-brand {
            height: auto !important;    
            padding: 1.5rem 1rem !important;
            justify-content: flex-start !important;
            margin-bottom: 0.5rem;
        }
        
        #accordionSidebar .sidebar-brand .sidebar-brand-icon {
            margin-right: 10px;
        }

        #accordionSidebar .sidebar-brand .sidebar-brand-text {
            display: inline-block !important;
            font-size: 1.2rem !important;
            letter-spacing: 1px;
        }

        #accordionSidebar .nav-item .nav-link {
            display: flex !important;
            align-items: center;
            text-align: left !important;
            width: 100% !important;
            padding: 1rem 1.5rem !important;
        }

        #accordionSidebar .nav-item .nav-link i {
            font-size: 1.2rem !important;
            margin-right: 1rem !important;
            width: 1.5rem;
            text-align: center;
        }

        #accordionSidebar .nav-item .nav-link span {
            font-size: 1.05rem !important;
            display: inline-block !important;
            font-weight: 500;
        }

        #accordionSidebar .sidebar-heading {
            text-align: left !important;
            padding: 0 1.5rem !important;
            margin-top: 1rem;
        }
        
        #accordionSidebar hr.sidebar-divider {
            margin: 0.5rem 1.5rem !important;
        }

        /* 3. 모바일용 닫기 버튼 표시 및 위치 조정 */
        #accordionSidebar .mobile-toggler {
            display: flex !important;
            justify-content: center;
            margin-top: 2rem;
            /* 여백은 #accordionSidebar의 padding-bottom으로 확보함 */
        }
    }
</style>

<ul class="navbar-nav toggled bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <li class="nav-item">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="https://fms.iwin.kr/index.php" title="main">
            <div class="sidebar-brand-icon">
                <img src="https://fms.iwin.kr/icon/kjwt_ci_32.png" alt="iwin">
            </div>
            <div class="sidebar-brand-text mx-3">FMS</div>
        </a>
    </li>

    <li class="nav-item">
        <hr class="sidebar-divider">    
    </li>

    <li class="nav-item">
        <div class="sidebar-heading">
            Menu
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="https://fms.iwin.kr/index_car.php" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-car"></i>
            <span>차량</span>
        </a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="https://fms.iwin.kr/index_field.php" aria-expanded="true" aria-controls="collapseTwo2">
            <i class="fas fa-screwdriver"></i>
            <span>현장</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="https://fms.iwin.kr/index_warehouse.php" aria-expanded="true" aria-controls="collapseTwo8">
            <i class="fas fa-boxes"></i>
            <span>창고</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="https://fms.iwin.kr/index_management.php" aria-expanded="true" aria-controls="collapseTwo3">
            <i class="fas fa-user"></i>
            <span>경영관리</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="https://fms.iwin.kr/index_finance.php" aria-expanded="true" aria-controls="collapseTwo7">               
            <i class="fas fa-won-sign"></i>
            <span>재무관리</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="https://fms.iwin.kr/index_auto.php" aria-expanded="true" aria-controls="collapseTwo4">
            <i class="fas fa-microchip"></i>
            <span>자동화</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="https://fms.iwin.kr/index_global.php" aria-expanded="true" aria-controls="collapseTwo6">               
            <i class="fas fa-globe-asia"></i>
            <span>Việt Nam</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="https://fms.iwin.kr/logout.php" aria-expanded="true" aria-controls="collapseTwo7">               
            <i class="fas fa-sign-out-alt"></i>
            <span>로그아웃</span>
        </a>
    </li>

    <li class="nav-item mt-auto mb-3">
        <a class="nav-link" href="https://fms.iwin.kr/my_page.php" title="설정">
            <i class="fas fa-cog"></i>
            <span>설정</span>
        </a>
    </li>
    <div class="text-center d-none d-md-inline mobile-toggler">
        <button class="rounded-circle border-0" id="sidebarToggle" title="SidebarTOGGLE"></button>
    </div>   
</ul>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var sidebar = document.getElementById('accordionSidebar');
        var topBtn = document.getElementById('sidebarToggleTop'); 
        var bottomBtn = document.getElementById('sidebarToggle');

        // [핵심 기능 1] 메뉴 상태 감시 -> 메인 화면 스크롤 잠금/해제
        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === "class") {
                    var isClosed = sidebar.classList.contains('toggled');
                    
                    if (window.innerWidth <= 768) {
                        if (!isClosed) {
                            // 메뉴 열림 -> 메인 화면 스크롤 잠금
                            document.body.style.overflow = 'hidden';
                        } else {
                            // 메뉴 닫힘 -> 메인 화면 스크롤 해제
                            document.body.style.overflow = '';
                        }
                    } else {
                        document.body.style.overflow = '';
                    }
                }
            });
        });
        
        observer.observe(sidebar, { attributes: true });

        // [핵심 기능 2] 배경 터치 시 닫기
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                var isOpen = !sidebar.classList.contains('toggled');
                
                if (isOpen) {
                    var isClickInside = sidebar.contains(e.target);
                    var isTopBtn = topBtn && topBtn.contains(e.target);
                    var isBottomBtn = bottomBtn && bottomBtn.contains(e.target);

                    if (!isClickInside && !isTopBtn && !isBottomBtn) {
                        sidebar.classList.add('toggled');
                    }
                }
            }
        });

        // [핵심 기능 3] 메뉴 내부 터치 전파 차단
        sidebar.addEventListener('touchmove', function(e) {
            e.stopPropagation(); 
        }, { passive: false });
    });
</script>