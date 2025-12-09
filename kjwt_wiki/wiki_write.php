<?php
// [중요] 실행 위치 고정
chdir(dirname(__FILE__) . '/../');
require_once 'session/session_check.php';
include_once 'DB/DB2.php';
include_once 'FUNCTION.php';
if(file_exists('kjwt_wiki/wiki_func.php')) include_once 'kjwt_wiki/wiki_func.php';

// 저장 로직 (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_wiki'])) {
    $mode = $_POST['mode'];
    $post_id = $_POST['post_id'];
    $cat_id = $_POST['cat_id'];
    $title = $_POST['title'];
    $content = $_POST['content']; 
    $user_id = $_SESSION['user_id'];
    $current_dt = date('Y-m-d H:i:s');

    if ($mode == 'new') {
        $sql = "INSERT INTO CONNECT.dbo.WIKI_POST (CAT_ID, TITLE, CONTENT, WRITER_ID) VALUES (?, ?, ?, ?); SELECT @@IDENTITY AS ID;";
        $stmt = sqlsrv_query($connect, $sql, [$cat_id, $title, $content, $user_id]);
        sqlsrv_next_result($stmt); 
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $post_id = $row['ID'];
    } else {
        // 히스토리 저장
        $sql_hist = "INSERT INTO CONNECT.dbo.WIKI_HISTORY (POST_ID, PREV_TITLE, PREV_CONTENT, MODIFIER_ID, VERSION_NO)
                     SELECT POST_ID, TITLE, CONTENT, ?, 
                     (SELECT ISNULL(MAX(VERSION_NO), 0) + 1 FROM CONNECT.dbo.WIKI_HISTORY WHERE POST_ID = ?)
                     FROM CONNECT.dbo.WIKI_POST WHERE POST_ID = ?";
        sqlsrv_query($connect, $sql_hist, [$user_id, $post_id, $post_id]);
        
        // 업데이트
        $sql_update = "UPDATE CONNECT.dbo.WIKI_POST SET CAT_ID=?, TITLE=?, CONTENT=?, MOD_DATE=?, MODIFIER_ID=? WHERE POST_ID=?";
        sqlsrv_query($connect, $sql_update, [$cat_id, $title, $content, $current_dt, $user_id, $post_id]);
    }

    // 파일 업로드
    if (isset($_FILES['attach_files'])) {
        $upload_dir = 'uploads/wiki/'; // 루트 기준
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $count = count($_FILES['attach_files']['name']);
        for ($i = 0; $i < $count; $i++) {
            if ($_FILES['attach_files']['error'][$i] == 0) {
                $tmp_name = $_FILES['attach_files']['tmp_name'][$i];
                $name = $_FILES['attach_files']['name'][$i];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $sys_name = uniqid('wiki_') . '.' . $ext;
                $path = $upload_dir . $sys_name;

                if (function_exists('checkFileHash') && checkFileHash($tmp_name) === true) {
                    echo "<script>alert('보안상 업로드할 수 없는 파일입니다: $name');</script>";
                    continue;
                }
                if (move_uploaded_file($tmp_name, $path)) {
                    $sql_f = "INSERT INTO CONNECT.dbo.WIKI_FILES (POST_ID, ORIGIN_NAME, SYS_NAME, FILE_PATH, FILE_EXT, FILE_SIZE) VALUES (?, ?, ?, ?, ?, ?)";
                    sqlsrv_query($connect, $sql_f, [$post_id, $name, $sys_name, $path, $ext, $_FILES['attach_files']['size'][$i]]);
                }
            }
        }
    }

    echo "<script>alert('저장되었습니다.'); location.href='wiki_view.php?post_id=$post_id';</script>";
    exit;
}

// 초기 데이터 로드
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'new';
$post_id = isset($_GET['post_id']) ? $_GET['post_id'] : 0;
$title = '';
$content = '';
$cat_id = 0;

if ($mode == 'edit' && $post_id > 0) {
    $q = "SELECT * FROM CONNECT.dbo.WIKI_POST WHERE POST_ID = ?";
    $stmt = sqlsrv_query($connect, $q, [$post_id]);
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if ($row) {
        $title = $row['TITLE'];
        $content = $row['CONTENT'];
        $cat_id = $row['CAT_ID'];
    }
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
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
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
                    <h1 class="h3 mb-0 text-gray-800 ml-2">문서 작성</h1>
                </nav>

                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><?php echo ($mode=='new')?'새 문서 작성':'문서 수정'; ?></h6>
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">

                                <div class="form-group row">
                                    <div class="col-sm-3 mb-3 mb-sm-0">
                                        <label class="font-weight-bold">카테고리</label>
                                        <select name="cat_id" class="form-control" required>
                                            <option value="">선택하세요</option>
                                            <?php
                                            $sql_c = "SELECT CAT_ID, CAT_NAME FROM CONNECT.dbo.WIKI_CATEGORY WHERE USE_YN='Y' ORDER BY SORT_ORDER";
                                            $stmt_c = sqlsrv_query($connect, $sql_c);
                                            while($c = sqlsrv_fetch_array($stmt_c, SQLSRV_FETCH_ASSOC)){
                                                $sel = ($c['CAT_ID'] == $cat_id) ? 'selected' : '';
                                                echo "<option value='{$c['CAT_ID']}' $sel>{$c['CAT_NAME']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-9">
                                        <label class="font-weight-bold">제목</label>
                                        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($title); ?>" required placeholder="문서 제목을 입력하세요">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">내용</label>
                                    <textarea id="summernote" name="content"><?php echo $content; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">첨부파일</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="attach_files[]" multiple>
                                        <label class="custom-file-label" for="customFile">파일 선택...</label>
                                    </div>
                                    <small class="text-muted">Ctrl 키를 누르고 여러 파일을 선택할 수 있습니다.</small>
                                </div>

                                <hr>
                                <div class="d-flex justify-content-end">
                                    <a href="wiki_view.php?post_id=<?php echo $post_id; ?>" class="btn btn-secondary mr-2">
                                        <i class="fas fa-times"></i> 취소
                                    </a>
                                    <button type="submit" name="save_wiki" class="btn btn-primary">
                                        <i class="fas fa-save"></i> 저장하기
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; IWIN FMS 2025</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: '업무 내용을 상세히 기록해주세요.',
                tabsize: 2,
                height: 500,
                lang: 'ko-KR',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
            
            // 파일명 표시 스크립트
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        });
    </script>
</body>
</html>