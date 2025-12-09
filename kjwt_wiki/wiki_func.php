<?php
// kjwt_wiki/wiki_func.php

// 1. [기존 함수] 계층형 카테고리 트리 가져오기 (사이드바용)
function getWikiCategoryTree($connect, $parentId = 0, $depth = 0) {
    if (!$connect) return '';

    $query = "SELECT CAT_ID, CAT_NAME FROM CONNECT.dbo.WIKI_CATEGORY WHERE PARENT_ID = ? AND USE_YN = 'Y' ORDER BY SORT_ORDER, CAT_NAME";
    $params = [$parentId];
    $stmt = sqlsrv_query($connect, $query, $params);
    
    $html = '';
    if ($stmt) {
        $html .= ($depth == 0) ? '<ul class="list-unstyled components pl-2">' : '<ul class="pl-3 list-unstyled">';
        
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $catId = $row['CAT_ID'];
            $catName = $row['CAT_NAME'];
            
            $html .= '<li class="mb-1">';
            $html .= '<a href="wiki_view.php?cat_id=' . $catId . '" class="text-dark wiki-tree-link">';
            $html .= '<i class="fas fa-folder text-warning mr-2"></i>' . $catName . '</a>';
            $html .= getWikiCategoryTree($connect, $catId, $depth + 1); // 재귀 호출
            $html .= '</li>';
        }
        $html .= '</ul>';
    }
    return $html;
}

// 2. [신규 추가] 카테고리 선택 옵션 가져오기 (폴더 추가 모달용)
function getCategoryOptions($connect, $parentId = 0, $depth = 0) {
    if (!$connect) return '';

    $query = "SELECT CAT_ID, CAT_NAME FROM CONNECT.dbo.WIKI_CATEGORY WHERE PARENT_ID = ? AND USE_YN = 'Y' ORDER BY SORT_ORDER, CAT_NAME";
    $params = [$parentId];
    $stmt = sqlsrv_query($connect, $query, $params);
    
    $html = '';
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $catId = $row['CAT_ID'];
        $catName = $row['CAT_NAME'];
        
        // 깊이에 따라 들여쓰기 표시 (예: └ 하위폴더)
        $prefix = str_repeat('&nbsp;&nbsp;&nbsp;', $depth) . ($depth > 0 ? '└ ' : '');
        
        $html .= "<option value='$catId'>$prefix $catName</option>";
        
        // 재귀 호출
        $html .= getCategoryOptions($connect, $catId, $depth + 1);
    }
    return $html;
}

// 3. [기존 함수] 첨부파일 아이콘
function getFileIcon($ext) {
    $ext = strtolower($ext);
    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) return 'fa-image';
    if ($ext == 'pdf') return 'fa-file-pdf text-danger';
    if (in_array($ext, ['xls', 'xlsx'])) return 'fa-file-excel text-success';
    if (in_array($ext, ['doc', 'docx'])) return 'fa-file-word text-primary';
    if (in_array($ext, ['ppt', 'pptx'])) return 'fa-file-powerpoint text-warning';
    return 'fa-file';
}
?>