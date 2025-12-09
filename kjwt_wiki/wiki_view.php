<?php
// [중요] 실행 위치 고정
chdir(dirname(__FILE__) . '/../');

require_once 'session/session_check.php';
include_once 'DB/DB2.php';
include_once 'FUNCTION.php';

// 함수 파일 로드
if(file_exists('kjwt_wiki/wiki_func.php')) {
    include_once 'kjwt_wiki/wiki_func.php';
} else {
    function getWikiCategoryTree($c){ return ''; }
    function getCategoryOptions($c){ return ''; }
    function getFileIcon($e){ return 'fa-file'; }
}

// --- [신규 기능] 카테고리(폴더) 추가 로직 ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['act']) && $_POST['act'] == 'add_category') {
    $new_cat_name = trim($_POST['cat_name']);
    $parent_id = $_POST['parent_id'];

    if (!empty($new_cat_name)) {
        $sql = "INSERT INTO CONNECT.dbo.WIKI_CATEGORY (PARENT_ID, CAT_NAME, SORT_ORDER, USE_YN) VALUES (?, ?, 0, 'Y')";
        $params = [$parent_id, $new_cat_name];
        $stmt = sqlsrv_query($connect, $sql, $params);

        if ($stmt) {
            echo "<script>alert('새 폴더가 추가되었습니다.'); location.href='wiki_view.php';</script>";
        } else {
            echo "<script>alert('폴더 추가 실패.'); history.back();</script>";
        }
    }
    exit;
}
// ------------------------------------------

$post_id = isset($_GET['post_id']) ? $_GET['post_id'] : 0;
$cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : 0;
$data = null;
$file_stmt = null;

// 게시글 조회
if ($post_id) {
    sqlsrv_query($connect, "UPDATE CONNECT.dbo.WIKI_POST SET VIEW_COUNT = VIEW_COUNT + 1 WHERE POST_ID = ?", [$post_id]);
    
    $query = "SELECT P.*, C.CAT_NAME FROM CONNECT.dbo.WIKI_POST P 
              LEFT JOIN CONNECT.dbo.WIKI_CATEGORY C ON P.CAT_ID = C.CAT_ID 
              WHERE P.POST_ID = ?";
    $stmt = sqlsrv_query($connect, $query, [$post_id]);
    if($stmt) $data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    
    $file_query = "SELECT * FROM CONNECT.dbo.WIKI_FILES WHERE POST_ID = ?";
    $file_stmt = sqlsrv_query($connect, $file_query, [$post_id]);
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php 
    ob_start();
    include 'head_root.php';
    $head = ob_get_clean();
    echo str_replace(
        ['href="css/', 'href="vendor/', 'src="js/', 'src="vendor/'], 
        ['href="../css/', 'href="../vendor/', 'src="../js/', 'src="../vendor/'], 
        $head
    );
    ?>
    <style>
        .wiki-tree-container { max-height: 75vh; overflow-y: auto; }
        .wiki-content { min-height: 400px; line-height: 1.6; }
        .wiki-content img { max-width: 100%; height: auto; }
        .wiki-tree-link { text-decoration: none; display: block; padding: 4px 0; font-size: 0.95rem; }
        .wiki-tree-link:hover { font-weight: bold; color: #4e73de !important; }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include 'nav.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h1 class="h3 mb-0 text-gray-800 ml-2">사내 위키 (Wiki)</h1>
                </nav>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 mb-4">
                            <div class="card shadow h-100">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-sitemap"></i> 목차</h6>
                                    <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#addCategoryModal">
                                        <i class="fas fa-folder-plus"></i> 폴더 추가
                                    </button>
                                </div>
                                <div class="card-body wiki-tree-container">
                                    <?php echo getWikiCategoryTree($connect); ?>
                                    <hr>
                                    <a href="wiki_write.php?mode=new" class="btn btn-success btn-block"><i class="fas fa-pen"></i> 새 문서 작성</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-9 col-lg-8">
                            <?php if($data) { ?>
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                        <h5 class="m-0 font-weight-bold text-dark">
                                            <span class="badge badge-primary mr-2"><?php echo $data['CAT_NAME']; ?></span>
                                            <?php echo htmlspecialchars($data['TITLE']); ?>
                                        </h5>
                                        <div class="small text-muted">
                                            <i class="fas fa-user"></i> <?php echo $data['WRITER_ID']; ?> &nbsp;|&nbsp; 
                                            <i class="fas fa-eye"></i> <?php echo $data['VIEW_COUNT']; ?>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="wiki-content mb-4">
                                            <?php echo $data['CONTENT']; ?>
                                        </div>
                                        
                                        <?php if($file_stmt && sqlsrv_has_rows($file_stmt)) { ?>
                                            <div class="card bg-light border-0 mb-4">
                                                <div class="card-body p-3">
                                                    <h6 class="font-weight-bold text-secondary mb-2"><i class="fas fa-paperclip"></i> 첨부파일</h6>
                                                    <ul class="list-unstyled mb-0 pl-2">
                                                    <?php 
                                                    while($file = sqlsrv_fetch_array($file_stmt, SQLSRV_FETCH_ASSOC)) {
                                                        $icon = getFileIcon($file['FILE_EXT']);
                                                        $downloadPath = "../" . $file['FILE_PATH'];
                                                        echo "<li class='mb-2'>
                                                                <a href='{$downloadPath}' class='text-decoration-none text-dark' download='{$file['ORIGIN_NAME']}'>
                                                                    <i class='fas $icon fa-fw mr-1'></i> {$file['ORIGIN_NAME']} 
                                                                    <small class='text-muted ml-1'>(".round($file['FILE_SIZE']/1024,1)." KB)</small>
                                                                </a>
                                                              </li>";
                                                    }
                                                    ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary btn-sm" onclick="location.href='wiki_view.php';"><i class="fas fa-list"></i> 목록으로</button>
                                            <div>
                                                <a href="wiki_write.php?mode=edit&post_id=<?php echo $post_id; ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> 수정</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="card shadow mb-4" style="min-height: 500px;">
                                    <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">
                                        <div class="mb-4"><i class="fas fa-book-open text-gray-300" style="font-size: 5rem;"></i></div>
                                        <h3 class="text-gray-800 font-weight-bold">FMS 사내 위키</h3>
                                        <p class="text-gray-600 mb-4">좌측 메뉴에서 문서를 선택하세요.</p>
                                        
                                        <?php if ($cat_id > 0) { 
                                            echo "<div class='w-75 text-left mt-4'>";
                                            echo "<h6 class='font-weight-bold border-bottom pb-2'><i class='fas fa-list'></i> 해당 카테고리 문서 목록</h6>";
                                            echo "<div class='list-group list-group-flush'>";
                                            $list_q = "SELECT POST_ID, TITLE, REG_DATE FROM CONNECT.dbo.WIKI_POST WHERE CAT_ID = ? AND IS_DELETED='N' ORDER BY REG_DATE DESC";
                                            $list_stmt = sqlsrv_query($connect, $list_q, [$cat_id]);
                                            while($l = sqlsrv_fetch_array($list_stmt, SQLSRV_FETCH_ASSOC)){
                                                echo "<a href='wiki_view.php?post_id={$l['POST_ID']}' class='list-group-item list-group-item-action py-2'>
                                                        {$l['TITLE']} <small class='float-right text-muted'>{$l['REG_DATE']->format('Y-m-d')}</small>
                                                      </a>";
                                            }
                                            echo "</div></div>";
                                        } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto"><span>Copyright &copy; IWIN FMS 2025</span></div>
                </div>
            </footer>
        </div>
    </div>

    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">새 폴더(카테고리) 추가</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="post" action="wiki_view.php">
                    <div class="modal-body">
                        <input type="hidden" name="act" value="add_category">
                        <div class="form-group">
                            <label for="parent_id">상위 폴더 선택</label>
                            <select class="form-control" name="parent_id" id="parent_id">
                                <option value="0">--- 최상위 폴더 (ROOT) ---</option>
                                <?php echo getCategoryOptions($connect); ?>
                            </select>
                            <small class="text-muted">선택한 폴더의 하위 폴더로 생성됩니다.</small>
                        </div>
                        <div class="form-group">
                            <label for="cat_name">폴더명</label>
                            <input type="text" class="form-control" name="cat_name" id="cat_name" placeholder="예: IT팀 매뉴얼" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">취소</button>
                        <button class="btn btn-primary" type="submit">추가하기</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>
</body>
</html>