<?php
  session_start();

  // 사용자가 이미 로그인한 경우 메인 페이지로 리디렉션
  if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
      header('Location: index.php');
      exit;
  }

  // 세션 보안 설정
  ini_set('session.cookie_httponly', 1);
  ini_set('session.cookie_secure', 1);
  ini_set('session.cookie_samesite', 'Strict');
  ini_set('session.use_strict_mode', 1);
  ini_set('session.use_only_cookies', 1);

  // 브라우저 캐시 비활성화
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");

  // 추가 보안 헤더
  header("X-Content-Type-Options: nosniff");
  header("X-Frame-Options: DENY");
  header("X-XSS-Protection: 1; mode=block");
  header("Referrer-Policy: strict-origin-when-cross-origin");
  header("Permissions-Policy: geolocation=(), microphone=(), camera=()");

  if (isset($_GET['message'])) {
      echo "<script>alert('" . htmlspecialchars($_GET['message']) . "');</script>";
  }

  $remember_me_cookie = isset($_COOKIE['remember_me']) ? htmlspecialchars($_COOKIE['remember_me']) : '';
  $is_remember_me_checked = !empty($remember_me_cookie);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0, shrink-to-fit=no">
  <meta name="author" content="madcat">
  <meta name="description" content="IWIN Facilities Management System">
  <title>FMS</title>

  <!--====== 카카오톡 미리보기 세팅 ======-->
  <meta property="og:title" content="FMS">
  <meta property="og:image" content="https://fms.iwin.kr/img/logo2.png">
  <meta property="og:description" content="Facility Management System">
  <meta property="og:type" content="website">   
 
  <!-- Font-Awesome 아이콘 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- 파비콘 -->
  <link rel="shortcut icon" href="icon/kjwt_favicon.ico">
  <link rel="apple-touch-icon-precomposed" href="icon/kjwt_ci_152.png">
  <link rel="icon" href="icon/kjwt_ci_16.png" sizes="16x16"> 
  <link rel="icon" href="icon/kjwt_ci_32.png" sizes="32x32"> 
  <link rel="icon" href="icon/kjwt_ci_48.png" sizes="48x48"> 
  <link rel="icon" href="icon/kjwt_ci_64.png" sizes="64x64"> 
  <link rel="icon" href="icon/kjwt_ci_128.png" sizes="128x128">

  <!-- 웹 폰트 -->
  <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet" />

  <!-- tailwindcss -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            primary: "#4E73DE",
            "background-light": "#f3f4f6",
            "background-dark": "#1f2937",
          },
          fontFamily: {
            display: ["Poppins", "sans-serif"],
          },
          borderRadius: {
            DEFAULT: "0.5rem",
          },
        },
      },
    };
  </script>
</head>
<body class="font-display bg-background-light dark:bg-background-dark">
  <div class="min-h-screen flex items-center justify-center relative bg-gray-900">
    <div class="absolute inset-0">
      <img src="img/main_img2.png" alt="Automotive Parts Management Background" class="w-full h-full object-cover" />
      <div class="absolute inset-0 bg-black opacity-60"></div>
    </div>

    <main class="relative z-10 w-full max-w-md p-2 mx-4">
      <div class="bg-background-light/90 dark:bg-background-dark/90 backdrop-blur-sm shadow-2xl rounded-lg p-8 md:p-10">
        <div class="text-center mb-8">
          <img src="img/logo2.png" alt="Logo" class="h-20 w-auto mx-auto mb-4">
          <h1 class="text-2xl font-bold text-gray-800 dark:text-white mt-2">FMS</h1>
          <p class="text-gray-600 dark:text-gray-400 text-sm">Welcome back!</p>
        </div>

        <form method="post" action="loginproc.php" autocomplete="off" class="space-y-6">
          <div>
            <label for="loginId" class="block text-sm font-medium text-gray-700 dark:text-gray-300">User ID</label>
            <div class="mt-1 relative rounded-md shadow-sm">
              <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <span class="material-icons-outlined text-gray-400 dark:text-gray-500">person</span>
              </div>
              <input
                type="text"
                id="loginId"
                name="loginId"
                placeholder="G/W ID"
                required
                pattern="[A-Za-z0-9.-]{3,20}"
                title="3-20자의 영문자와 숫자만 사용 가능합니다"
                maxlength="20"
                class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white pl-10 focus:border-primary focus:ring-primary sm:text-sm"
                value="<?php echo $remember_me_cookie; ?>"
              />
            </div>
          </div>

          <div>
            <label for="loginPw" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
            <div class="mt-1 relative rounded-md shadow-sm">
              <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <span class="material-icons-outlined text-gray-400 dark:text-gray-500">lock</span>
              </div>
              <input
                type="password"
                id="loginPw"
                name="password"
                placeholder="••••••••"
                required
                pattern="^(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=?\/])(?!.*(.)\1{2,})[A-Za-z\d!@#$%^&*()_\-+=?\/]{12,64}$"
                title="12-64자의 소문자, 숫자, 특수문자를 포함해야 하며 동일 문자를 3번 이상 연속 사용할 수 없습니다"
                maxlength="64"
                class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white pl-10 focus:border-primary focus:ring-primary sm:text-sm"
              />
            </div>
          </div>

          <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />

          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input
                id="remember-me"
                name="remember-me"
                type="checkbox"
                class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 text-primary focus:ring-primary bg-gray-100 dark:bg-gray-900 dark:ring-offset-gray-900"
                <?php if ($is_remember_me_checked) echo 'checked'; ?>
              />
              <label for="remember-me" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Remember me</label>
            </div>
            <div class="text-sm">
              <a href="javascript:void(0)" onclick="alert('그룹웨어 계정으로 로그인하신게 맞습니까?\n패스워드 분실 시 경영팀에에 문의하세요!\n패스워드 분실 시 AEO에 의하여 접근차단해제요청서를 작성하셔야 합니다!')" class="font-medium text-primary hover:text-blue-500">Forgot password?</a>
            </div>
          </div>

          <div>
            <button
              type="submit"
              class="group relative flex w-full justify-center rounded-md border border-transparent bg-primary py-3 px-4 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-background-dark transition-colors duration-300"
            >
              <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <span class="material-icons-outlined h-5 w-5 text-300 group-hover:text-blue-100">login</span>
              </span>
              Log in
            </button>
          </div>
        </form>
      </div>
    </main>

  </div>

  <?php if (isset($_SESSION['error_message'])): ?>
    <script nonce="<?php echo $_SESSION['csrf_token']; ?>">
      alert('<?php echo htmlspecialchars($_SESSION['error_message'], ENT_QUOTES, 'UTF-8'); ?>');
    </script>
    <?php unset($_SESSION['error_message']); ?>
  <?php endif; ?>
</body>
</html>