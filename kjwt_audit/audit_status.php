<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.06.10>
	// Description:	<감사>
    // Last Modified: <25.09.18> - Refactored for PHP 8.x, Security, and Performance
    // =============================================

    //★DB연결 및 함수사용
    include_once '../session/ip_session.php';   
    include_once '../DB/DB2.php'; 
    
    //★변수정의 및 초기화
    $bt21 = $_POST['bt21'] ?? null;
    $bt31 = $_POST['bt31'] ?? null;
    $menu41 = $_POST['menu41'] ?? null;
    $bt41 = $_POST['bt41'] ?? null;
    $bt51 = $_POST['bt51'] ?? null;

    // 쿼리 실행을 위한 파라미터 및 옵션 초기화
    // sqlsrv_num_rows를 사용하려면 'Scrollable' 옵션이 필요합니다.
    $params = [];
    $options = ["Scrollable" => SQLSRV_CURSOR_KEYSET];
    $tab_sequence = 2; // 기본 탭

    // 탭 활성화 변수 초기화 (PHP 8.x 호환성)
    $tab2 = $tab3 = $tab4 = $tab5 = $tab6 = '';
    $tab2_text = $tab3_text = $tab4_text = $tab5_text = $tab6_text = '';

    //★버튼 클릭 시 실행
    if ($bt21 === "on") {
        $tab_sequence = 2;
        //ERP 그룹코드 변경 로그
        $Query_Grant = "SELECT * from NEOE.NEOE.MA_EMP where CD_COMPANY='1000' AND NO_EMP LIKE 'F%' ORDER BY NM_KOR ASC";              
        $Result_Grant = sqlsrv_query($connect, $Query_Grant, $params, $options);
        if ($Result_Grant) {
            $Count_Grant = sqlsrv_num_rows($Result_Grant); 
        }
    } 
    elseif ($bt31 === "on") {
        $tab_sequence = 3;
        //ERP 회계 계정등록 로그
        $Query_Grant2 = "SELECT * from neoe.neoe.fi_grpacct where CD_COMPANY='1000' AND CD_FSFORM='D0012'";              
        $Result_Grant2 = sqlsrv_query($connect, $Query_Grant2, $params, $options);
        if ($Result_Grant2) {
            $Count_Grant2 = sqlsrv_num_rows($Result_Grant2);  
        }
    }  
    elseif ($bt41 === "on" && !empty($menu41)) {
        $tab_sequence = 4;
        //ERP 사용자별 권한보유자 (SQL Injection 방지를 위해 파라미터화된 쿼리 사용)
        $Query_Grant3 = "SELECT * FROM (
            SELECT E.NM_DEPT, A.ID_USER, GM.ID_GROUP, CD.NM_SYSDEF NM_MODULE, neoe.neoe.FN_GET_BASEMENU_COLDATA2('1000', 'L0', BM.ID_MENU) NM_MENU
            FROM neoe.neoe.MA_GRANT A
            LEFT OUTER JOIN neoe.neoe.MA_EMP D ON A.CD_COMPANY = D.CD_COMPANY AND A.NO_EMP = D.NO_EMP
            LEFT OUTER JOIN neoe.neoe.MA_DEPT E ON A.CD_COMPANY = E.CD_COMPANY AND D.CD_DEPT = E.CD_DEPT
            LEFT JOIN neoe.neoe.DZSN_MA_N_GROUPMENU GM ON A.CD_COMPANY = GM.CD_COMPANY AND A.CD_GROUP = GM.ID_GROUP
            INNER JOIN neoe.neoe.MA_N_BASEMENU BM ON GM.ID_MENU = BM.ID_MENU AND BM.YN_USE = 'Y'
            LEFT OUTER JOIN neoe.neoe.DZSN_MA_CODEDTL CD ON GM.CD_COMPANY = CD.CD_COMPANY AND CD.CD_FIELD = 'MA_B000039' AND BM.FG_MODULE = CD.CD_SYSDEF
            INNER JOIN neoe.neoe.DZSN_MA_GROUP GR ON GM.CD_COMPANY = GR.CD_COMPANY AND GM.ID_GROUP = GR.CD_GROUP
            WHERE A.CD_COMPANY='1000' AND A.CD_GROUP<>'WEB' AND A.USR_GBN='INT' AND A.YN_USERMENU='N' AND A.ID_USER<>'duzon' AND D.DT_RETIRE=0 AND E.NM_DEPT<>'VIETNAM' AND GM.ID_GROUP<>'WEB' AND GM.CD_COMPANY = '1000' AND GM.FG_TYPE = 'PAG' AND BM.FG_MODULE<>'WEB'
            UNION ALL
            SELECT E.NM_DEPT, A.ID_USER, GM.ID_GROUP, CD.NM_SYSDEF NM_MODULE, neoe.neoe.FN_GET_BASEMENU_COLDATA2('1000', 'L0', BM.ID_MENU) NM_MENU
            FROM neoe.neoe.MA_GRANT A
            LEFT OUTER JOIN neoe.neoe.MA_EMP D ON A.CD_COMPANY = D.CD_COMPANY AND A.NO_EMP = D.NO_EMP
            LEFT OUTER JOIN neoe.neoe.MA_DEPT E ON A.CD_COMPANY = E.CD_COMPANY AND D.CD_DEPT = E.CD_DEPT
            LEFT JOIN neoe.neoe.DZSN_MA_N_GROUPMENU GM ON A.CD_COMPANY = GM.CD_COMPANY AND A.CD_GROUP = GM.ID_GROUP
            INNER JOIN neoe.neoe.MA_N_USERMENU GU ON GM.CD_COMPANY = GU.CD_COMPANY AND GM.ID_GROUP = GU.ID_GROUP AND GM.ID_MENU = GU.ID_MENU AND A.ID_USER=GU.ID_USER
            INNER JOIN neoe.neoe.MA_N_BASEMENU BM ON GM.ID_MENU = BM.ID_MENU AND BM.YN_USE = 'Y'
            LEFT OUTER JOIN neoe.neoe.DZSN_MA_CODEDTL CD ON GM.CD_COMPANY = CD.CD_COMPANY AND CD.CD_FIELD = 'MA_B000039' AND BM.FG_MODULE = CD.CD_SYSDEF
            INNER JOIN neoe.neoe.DZSN_MA_GROUP GR ON GM.CD_COMPANY = GR.CD_COMPANY AND GM.ID_GROUP = GR.CD_GROUP
            WHERE A.CD_COMPANY='1000' AND A.CD_GROUP<>'WEB' AND A.USR_GBN='INT' AND A.YN_USERMENU='Y' AND A.ID_USER<>'duzon' AND D.DT_RETIRE=0 AND E.NM_DEPT<>'VIETNAM' AND GM.ID_GROUP<>'WEB' AND GM.CD_COMPANY = '1000' AND GM.FG_TYPE = 'PAG' AND BM.FG_MODULE<>'WEB'
        ) AUTH
        WHERE NM_MENU = ?
        ORDER BY AUTH.NM_DEPT ASC, AUTH.ID_USER ASC, AUTH.NM_MODULE ASC";
        
        $params_grant3 = [$menu41];
        $Result_Grant3 = sqlsrv_query($connect, $Query_Grant3, $params_grant3, $options);
        if ($Result_Grant3) {
            $Count_Grant3 = sqlsrv_num_rows($Result_Grant3); 
        }
    }
    elseif ($bt51 === "on") {
        $tab_sequence = 5;
        //ERP 퇴사자 권한 보유
        $Query_Grant4 = "WITH CTE_RETIRE AS (
                            SELECT
                                nm_kor,
                                dt_retire,
                                dts_update,
                                COALESCE(note, '') as note,
                                ROW_NUMBER() OVER(PARTITION BY nm_kor ORDER BY dts_update DESC) as rn
                            FROM CONNECT.DBO.ERP_RETIRE
                            WHERE NO_EMP LIKE 'F%'
                        )
                        SELECT
                            nm_kor AS NM_KOR,
                            dt_retire AS DT_RETIRE,
                            dts_update AS DTS_UPDATE,
                            note AS NOTE
                        FROM CTE_RETIRE
                        WHERE rn = 1";
        $Result_Grant4 = sqlsrv_query($connect, $Query_Grant4);
    } 

    // ★매뉴 진입 시 탭활성화 (선택된 탭으로 설정)
    include '../TAB.php';
?>