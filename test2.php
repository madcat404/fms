<?php
// 1. 데이터 구성 (기존과 동일)
$employees = [
    ['id' => 1, 'name' => '김대표', 'role' => 'CEO', 'parent_id' => 0, 'img' => 'https://ui-avatars.com/api/?name=CEO&background=0D8ABC&color=fff'],
    ['id' => 2, 'name' => '이전무', 'role' => 'CTO', 'parent_id' => 1, 'img' => 'https://ui-avatars.com/api/?name=CTO&background=34495e&color=fff'],
    ['id' => 3, 'name' => '박상무', 'role' => 'CFO', 'parent_id' => 1, 'img' => 'https://ui-avatars.com/api/?name=CFO&background=e67e22&color=fff'],
    ['id' => 4, 'name' => '최부장', 'role' => '개발 1팀장', 'parent_id' => 2, 'img' => 'https://ui-avatars.com/api/?name=DEV1&background=8e44ad&color=fff'],
    ['id' => 5, 'name' => '정차장', 'role' => '개발 2팀장', 'parent_id' => 2, 'img' => 'https://ui-avatars.com/api/?name=DEV2&background=2980b9&color=fff'],
    ['id' => 6, 'name' => '강과장', 'role' => '회계팀장', 'parent_id' => 3, 'img' => 'https://ui-avatars.com/api/?name=ACC&background=27ae60&color=fff'],
    ['id' => 7, 'name' => '조대리', 'role' => '백엔드', 'parent_id' => 4, 'img' => 'https://ui-avatars.com/api/?name=BE&background=f1c40f&color=333'],
    ['id' => 8, 'name' => '윤사원', 'role' => '프론트', 'parent_id' => 4, 'img' => 'https://ui-avatars.com/api/?name=FE&background=e74c3c&color=fff'],
    ['id' => 9, 'name' => '임인턴', 'role' => 'QA', 'parent_id' => 5, 'img' => 'https://ui-avatars.com/api/?name=QA&background=95a5a6&color=fff'],
];

// 2. PHP 함수: 평면 배열을 트리 구조로 변환
function buildTree(array $elements, $parentId = 0) {
    $branch = array();
    foreach ($elements as $element) {
        if ($element['parent_id'] == $parentId) {
            $children = buildTree($elements, $element['id']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }
    return $branch;
}

// 3. PHP 함수: 트리를 HTML로 렌더링
function renderTree($tree) {
    if (empty($tree)) return '';

    $html = '<ul>';
    foreach ($tree as $node) {
        $html .= '<li>';
        
        $html .= '<div class="member-card">';
        $html .= '  <div class="avatar"><img src="' . $node['img'] . '" alt="Avatar"></div>';
        $html .= '  <div class="info">';
        $html .= '    <div class="name">' . htmlspecialchars($node['name']) . '</div>';
        $html .= '    <div class="role">' . htmlspecialchars($node['role']) . '</div>';
        $html .= '  </div>';
        if (isset($node['children'])) {
            $html .= '<button class="toggle-btn" onclick="toggleNode(this)">-</button>';
        }
        $html .= '</div>';

        if (isset($node['children'])) {
            $html .= renderTree($node['children']);
        }
        
        $html .= '</li>';
    }
    $html .= '</ul>';
    
    return $html;
}

$treeData = buildTree($employees);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP 계층형 조직도 테마</title>
    <style>
        /* === 공통 레이아웃 및 리셋 === */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Noto Sans KR', sans-serif;
            background-color: #f4f6f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            transition: background-color 0.3s;
        }

        /* 컨트롤 패널 */
        .controls {
            margin-bottom: 30px;
            background: white;
            padding: 10px 20px;
            border-radius: 50px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            z-index: 100;
        }
        .controls button {
            border: none;
            background: none;
            padding: 8px 16px;
            margin: 0 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            border-radius: 20px;
            transition: all 0.2s;
        }
        .controls button.active {
            background-color: #3498db;
            color: white;
            box-shadow: 0 2px 5px rgba(52, 152, 219, 0.4);
        }

        /* 조직도 컨테이너 */
        .org-chart-container {
            width: 100%;
            overflow-x: auto;
            text-align: center;
            padding-bottom: 50px;
        }
        
        .org-chart {
            display: inline-block;
            transition: all 0.3s;
        }

        /* 공통: 토글 버튼 및 숨김 처리 */
        .toggle-btn { cursor: pointer; z-index: 20; }
        .collapsed ul { display: none !important; }
        .collapsed .toggle-btn::after { content: "+" !important; }
        .toggle-btn::after { content: "-"; } /* JS 대체 */


        /* =========================================
           THEME 1: DEFAULT (기본 - 연결선 중심)
           ========================================= */
        .theme-default .org-chart ul {
            display: flex; justify-content: center; padding-top: 20px; position: relative;
        }
        .theme-default .org-chart li {
            float: left; text-align: center; list-style-type: none; position: relative; padding: 20px 10px 0 10px;
        }
        /* 선 그리기 */
        .theme-default .org-chart li::before, .theme-default .org-chart li::after {
            content: ''; position: absolute; top: 0; right: 50%; border-top: 2px solid #ccc; width: 50%; height: 20px;
        }
        .theme-default .org-chart li::after { right: auto; left: 50%; border-left: 2px solid #ccc; }
        .theme-default .org-chart li:only-child::after, .theme-default .org-chart li:only-child::before { display: none; }
        .theme-default .org-chart li:only-child { padding-top: 0; }
        .theme-default .org-chart li:first-child::before, .theme-default .org-chart li:last-child::after { border: 0 none; }
        .theme-default .org-chart li:last-child::before { border-right: 2px solid #ccc; border-radius: 0 5px 0 0; }
        .theme-default .org-chart li:first-child::after { border-radius: 5px 0 0 0; }
        .theme-default .org-chart ul ul::before {
            content: ''; position: absolute; top: 0; left: 50%; border-left: 2px solid #ccc; width: 0; height: 20px;
        }
        /* 카드 스타일 */
        .theme-default .member-card {
            background: white; border: 1px solid #e1e4e8; padding: 15px; border-radius: 8px;
            display: inline-block; min-width: 140px; position: relative;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .theme-default .toggle-btn {
            position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%);
            width: 20px; height: 20px; border-radius: 50%; background: #3498db; color: white; border: none;
            display: flex; align-items: center; justify-content: center; font-size: 0; /* 텍스트 숨김 */
        }
        .theme-default .toggle-btn::after { font-size: 14px; line-height: 1; }


        /* =========================================
           THEME 2: MODERN DARK (네온 스타일)
           ========================================= */
        body.dark-mode { background-color: #1a1a2e; color: #fff; }
        
        .theme-dark .org-chart ul {
            display: flex; justify-content: center; padding-top: 30px; position: relative;
        }
        .theme-dark .org-chart li {
            list-style-type: none; position: relative; padding: 30px 15px 0 15px; text-align: center;
        }
        /* 네온 선 */
        .theme-dark .org-chart li::before, .theme-dark .org-chart li::after {
            content: ''; position: absolute; top: 0; right: 50%; border-top: 2px solid #0f3460; width: 50%; height: 30px;
        }
        .theme-dark .org-chart li::after { right: auto; left: 50%; border-left: 2px solid #0f3460; }
        .theme-dark .org-chart li:only-child::after, .theme-dark .org-chart li:only-child::before { display: none; }
        .theme-dark .org-chart li:only-child { padding-top: 0; }
        .theme-dark .org-chart li:first-child::before, .theme-dark .org-chart li:last-child::after { border: 0 none; }
        .theme-dark .org-chart li:last-child::before { border-right: 2px solid #0f3460; border-radius: 0 10px 0 0; }
        .theme-dark .org-chart li:first-child::after { border-radius: 10px 0 0 0; }
        .theme-dark .org-chart ul ul::before {
            content: ''; position: absolute; top: 0; left: 50%; border-left: 2px solid #0f3460; width: 0; height: 30px;
        }
        /* 다크 카드 */
        .theme-dark .member-card {
            background: #16213e; border: 1px solid #0f3460; padding: 20px 15px; border-radius: 12px;
            display: inline-block; min-width: 150px; position: relative;
            box-shadow: 0 0 15px rgba(233, 69, 96, 0.1); color: #fff;
            transition: transform 0.3s;
        }
        .theme-dark .member-card:hover { transform: scale(1.05); box-shadow: 0 0 20px rgba(233, 69, 96, 0.3); border-color: #e94560; }
        .theme-dark .member-card .name { font-size: 1.1rem; color: #e94560; margin-bottom: 5px; }
        .theme-dark .member-card .role { font-size: 0.8rem; color: #a2a8d3; }
        .theme-dark .avatar img { border: 2px solid #e94560; width: 60px; height: 60px; }
        /* 다크 토글 */
        .theme-dark .toggle-btn {
            position: absolute; bottom: -12px; left: 50%; transform: translateX(-50%);
            width: 24px; height: 24px; border-radius: 50%; background: #e94560; color: white; border: none;
            display: flex; align-items: center; justify-content: center; font-size: 0;
        }
        .theme-dark .toggle-btn::after { font-size: 16px; font-weight: bold; }


        /* =========================================
           THEME 3: CORPORATE (기업형)
           ========================================= */
        .theme-corporate .org-chart ul {
            display: flex; justify-content: center; padding-top: 20px; position: relative;
        }
        .theme-corporate .org-chart li {
            list-style-type: none; position: relative; padding: 20px 5px 0 5px; text-align: center;
        }
        /* 각진 선 */
        .theme-corporate .org-chart li::before, .theme-corporate .org-chart li::after {
            content: ''; position: absolute; top: 0; right: 50%; border-top: 1px solid #555; width: 50%; height: 20px;
        }
        .theme-corporate .org-chart li::after { right: auto; left: 50%; border-left: 1px solid #555; }
        .theme-corporate .org-chart li:only-child::after, .theme-corporate .org-chart li:only-child::before { display: none; }
        .theme-corporate .org-chart li:only-child { padding-top: 0; }
        .theme-corporate .org-chart li:first-child::before, .theme-corporate .org-chart li:last-child::after { border: 0 none; }
        .theme-corporate .org-chart li:last-child::before { border-right: 1px solid #555; border-radius: 0; } /* 라운드 제거 */
        .theme-corporate .org-chart li:first-child::after { border-radius: 0; } /* 라운드 제거 */
        .theme-corporate .org-chart ul ul::before {
            content: ''; position: absolute; top: 0; left: 50%; border-left: 1px solid #555; width: 0; height: 20px;
        }
        
        /* 기업형 카드: 명함 스타일 */
        .theme-corporate .member-card {
            background: white; border: 1px solid #aaa; padding: 0; border-radius: 0;
            display: inline-block; min-width: 160px; position: relative; text-align: left;
            box-shadow: 2px 2px 0px rgba(0,0,0,0.1);
        }
        .theme-corporate .member-card .avatar { display: none; } /* 아바타 숨김 */
        .theme-corporate .member-card .info { padding: 10px; border-left: 4px solid #2c3e50; }
        .theme-corporate .member-card .name { font-weight: 900; font-size: 1rem; color: #2c3e50; }
        .theme-corporate .member-card .role { font-size: 0.8rem; color: #7f8c8d; text-transform: uppercase; letter-spacing: 1px; }
        
        .theme-corporate .toggle-btn {
            position: absolute; top: 5px; right: 5px; bottom: auto; left: auto; transform: none;
            width: 18px; height: 18px; background: #2c3e50; color: white; border: none; font-size: 0;
        }
        .theme-corporate .toggle-btn::after { font-size: 12px; }


        /* =========================================
           THEME 4: TREE LIST (폴더 구조형 - 모바일 최적화)
           ========================================= */
        .theme-list { width: 100%; max-width: 600px; margin: 0 auto; }
        .theme-list .org-chart { display: block; width: 100%; }
        .theme-list .org-chart ul {
            display: block; padding-left: 20px; /* 들여쓰기 */
            position: relative;
        }
        /* 1단계(루트) UL의 패딩 제거 */
        .theme-list .org-chart > ul { padding-left: 0; }

        .theme-list .org-chart li {
            display: block; text-align: left; padding: 10px 0; margin: 0; position: relative;
        }
        
        /* 기존의 차트 연결선 모두 제거 */
        .theme-list .org-chart li::before, .theme-list .org-chart li::after, 
        .theme-list .org-chart ul ul::before { display: none; }

        /* 폴더 구조 선 만들기 */
        .theme-list .org-chart ul li::before {
            content: ''; position: absolute; top: 25px; left: -15px;
            width: 10px; height: 1px; background: #ccc; display: block; /* 가로선 */
        }
        .theme-list .org-chart ul {
            border-left: 1px solid #ccc; margin-left: 10px; /* 세로선 */
        }
        .theme-list .org-chart > ul { border-left: none; margin-left: 0; } /* 루트는 선 없음 */
        .theme-list .org-chart > ul > li::before { display: none; } /* 루트 자식 가로선 없음 */

        /* 리스트형 카드 스타일 */
        .theme-list .member-card {
            display: flex; align-items: center; width: 100%;
            background: #fff; border: 1px solid #eee; padding: 10px; border-radius: 4px;
            box-shadow: none; min-width: auto;
        }
        .theme-list .member-card .avatar img { width: 35px; height: 35px; margin-right: 15px; margin-bottom: 0; }
        .theme-list .member-card .info { text-align: left; flex-grow: 1; }
        .theme-list .member-card .name { font-size: 0.95rem; margin-bottom: 0; }
        .theme-list .member-card .role { font-size: 0.8rem; color: #888; }
        
        /* 리스트형 토글 버튼 (오른쪽에 배치) */
        .theme-list .toggle-btn {
            position: static; transform: none; width: 25px; height: 25px; 
            margin-left: 10px; background: #f1f2f6; color: #333;
            font-size: 0;
        }
        .theme-list .toggle-btn:hover { background: #e1e2e6; }
        .theme-list .toggle-btn::after { font-size: 16px; }

    </style>
</head>
<body class="theme-default">

    <!-- 테마 컨트롤러 -->
    <div class="controls">
        <button onclick="setTheme('default', this)" class="active">기본형</button>
        <button onclick="setTheme('dark', this)">Modern Dark</button>
        <button onclick="setTheme('corporate', this)">Corporate</button>
        <button onclick="setTheme('list', this)">Tree List</button>
    </div>

    <!-- 조직도 컨테이너 -->
    <div class="org-chart-container">
        <div class="org-chart">
            <?php echo renderTree($treeData); ?>
        </div>
    </div>

    <script>
        // 테마 변경 로직
        function setTheme(themeName, btn) {
            const body = document.body;
            
            // 모든 클래스 제거
            body.classList.remove('theme-default', 'theme-dark', 'theme-corporate', 'theme-list');
            
            // 선택된 테마 클래스 추가
            body.classList.add('theme-' + themeName);
            
            // 다크 모드일 때만 body 배경색 변경을 위한 클래스
            if(themeName === 'dark') {
                body.classList.add('dark-mode');
            } else {
                body.classList.remove('dark-mode');
            }

            // 버튼 활성화 스타일
            document.querySelectorAll('.controls button').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }

        // 노드 접기/펼치기 로직
        function toggleNode(btn) {
            const li = btn.closest('li');
            li.classList.toggle('collapsed');
            
            // Tree List 테마에서는 버튼이 relative 위치일 수 있으므로 텍스트 업데이트 방식 통일
            // CSS ::after content로 처리하므로 JS에서는 클래스 토글만 하면 됨
        }
    </script>
</body>
</html>