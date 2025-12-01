<?php
// 1. 데이터 구성 (실제로는 DB에서 가져오는 데이터)
// parent_id: 0은 최상위 노드를 의미합니다.
$employees = [
    ['id' => 1, 'name' => '김대표', 'role' => 'CEO', 'parent_id' => 0, 'img' => 'https://ui-avatars.com/api/?name=CEO&background=0D8ABC&color=fff'],
    ['id' => 2, 'name' => '이전무', 'role' => 'CTO', 'parent_id' => 1, 'img' => 'https://ui-avatars.com/api/?name=CTO&background=random'],
    ['id' => 3, 'name' => '박상무', 'role' => 'CFO', 'parent_id' => 1, 'img' => 'https://ui-avatars.com/api/?name=CFO&background=random'],
    ['id' => 4, 'name' => '최부장', 'role' => '개발 1팀장', 'parent_id' => 2, 'img' => 'https://ui-avatars.com/api/?name=DEV1&background=random'],
    ['id' => 5, 'name' => '정차장', 'role' => '개발 2팀장', 'parent_id' => 2, 'img' => 'https://ui-avatars.com/api/?name=DEV2&background=random'],
    ['id' => 6, 'name' => '강과장', 'role' => '회계팀장', 'parent_id' => 3, 'img' => 'https://ui-avatars.com/api/?name=ACC&background=random'],
    ['id' => 7, 'name' => '조대리', 'role' => '백엔드 개발', 'parent_id' => 4, 'img' => 'https://ui-avatars.com/api/?name=BE&background=random'],
    ['id' => 8, 'name' => '윤사원', 'role' => '프론트엔드', 'parent_id' => 4, 'img' => 'https://ui-avatars.com/api/?name=FE&background=random'],
    ['id' => 9, 'name' => '임인턴', 'role' => 'QA', 'parent_id' => 5, 'img' => 'https://ui-avatars.com/api/?name=QA&background=random'],
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

// 3. PHP 함수: 트리를 HTML로 렌더링 (재귀)
function renderTree($tree) {
    if (empty($tree)) return '';

    $html = '<ul>';
    foreach ($tree as $node) {
        $html .= '<li>';
        
        // 카드 디자인 영역
        $html .= '<div class="member-card">';
        $html .= '  <div class="avatar"><img src="' . $node['img'] . '" alt="Avatar"></div>';
        $html .= '  <div class="info">';
        $html .= '    <div class="name">' . htmlspecialchars($node['name']) . '</div>';
        $html .= '    <div class="role">' . htmlspecialchars($node['role']) . '</div>';
        $html .= '  </div>';
        
        // 하위 노드가 있다면 토글 버튼 추가
        if (isset($node['children'])) {
            $html .= '<button class="toggle-btn" onclick="toggleNode(this)">-</button>';
        }
        $html .= '</div>';

        // 자식 노드 재귀 호출
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
    <title>PHP 계층형 조직도</title>
    <style>
        /* 기본 리셋 및 스타일 */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Noto Sans KR', sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            padding: 50px;
            min-height: 100vh;
        }

        /* 조직도 트리 컨테이너 */
        .org-chart {
            display: inline-block; /* 내용물만큼 크기 잡기 */
        }

        .org-chart ul {
            padding-top: 20px; 
            position: relative;
            transition: all 0.5s;
            display: flex;
            justify-content: center;
        }

        .org-chart li {
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 10px 0 10px; /* 좌우 간격 조절 */
            transition: all 0.5s;
        }

        /* --- 연결 선 그리기 로직 (CSS Magic) --- */
        /* 세로 선 (부모로부터 내려오는 선) */
        .org-chart li::before, .org-chart li::after {
            content: '';
            position: absolute; top: 0; right: 50%;
            border-top: 2px solid #ccc;
            width: 50%; height: 20px;
        }
        .org-chart li::after {
            right: auto; left: 50%;
            border-left: 2px solid #ccc;
        }

        /* 첫 번째와 마지막 자식의 선 정리 */
        .org-chart li:only-child::after, .org-chart li:only-child::before {
            display: none;
        }
        .org-chart li:only-child { padding-top: 0; }

        .org-chart li:first-child::before, .org-chart li:last-child::after {
            border: 0 none;
        }
        
        /* 마지막 자식의 수직 선 연결 */
        .org-chart li:last-child::before{
            border-right: 2px solid #ccc;
            border-radius: 0 5px 0 0;
        }
        .org-chart li:first-child::after{
            border-radius: 5px 0 0 0;
        }

        /* 아래쪽으로 내려가는 선 (자식이 있는 경우) */
        .org-chart ul ul::before{
            content: '';
            position: absolute; top: 0; left: 50%;
            border-left: 2px solid #ccc;
            width: 0; height: 20px;
        }

        /* --- 멤버 카드 디자인 --- */
        .member-card {
            background: white;
            border: 1px solid #e1e4e8;
            padding: 15px;
            border-radius: 8px;
            display: inline-block;
            min-width: 140px;
            position: relative;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
            z-index: 10;
        }

        .member-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-color: #3498db;
        }

        .member-card .avatar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-bottom: 8px;
            border: 2px solid #f0f0f0;
        }

        .member-card .name {
            font-weight: 700;
            color: #333;
            font-size: 0.95rem;
            margin-bottom: 4px;
        }

        .member-card .role {
            color: #666;
            font-size: 0.8rem;
        }

        /* --- 토글 버튼 --- */
        .toggle-btn {
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
            line-height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 20;
        }
        
        .toggle-btn:hover { background: #2980b9; }

        /* 접혔을 때 스타일 */
        .collapsed ul {
            display: none; /* 하위 트리 숨김 */
        }
        
        .collapsed .toggle-btn::after {
            content: "+"; /* 버튼 텍스트 변경은 JS로 처리하거나 여기서 처리 */
        }
    </style>
</head>
<body>

    <div class="org-chart">
        <!-- PHP 렌더링 결과 출력 -->
        <?php echo renderTree($treeData); ?>
    </div>

    <script>
        function toggleNode(btn) {
            // 버튼이 속한 li 요소를 찾습니다.
            const li = btn.closest('li');
            
            // li에 'collapsed' 클래스를 토글합니다.
            li.classList.toggle('collapsed');
            
            // 버튼 텍스트 변경 (+ / -)
            if (li.classList.contains('collapsed')) {
                btn.textContent = '+';
            } else {
                btn.textContent = '-';
            }
        }
    </script>
</body>
</html>