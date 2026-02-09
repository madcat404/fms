<?php
// [설정] 대시보드에서 호출된 경우인지 확인 (?view_only=1 파라미터 체크)
$is_view_mode = isset($_GET['view_only']) && $_GET['view_only'] == '1';
?>

<?php if ($is_view_mode): ?>
<style>
    /* ==========================================================================
       [대시보드 뷰 전용 스타일]
       편집 기능, 메뉴, 팔레트 등을 숨기고 도면만 꽉 차게 보여줍니다.
       ========================================================================== */

    /* 1. 상단 메뉴바, 헤더, 버튼 숨김 */
    nav, header, .navbar, .topbar, .btn, button { 
        display: none !important; 
    }

    /* 2. [중요] 팔레트(장비 목록) 숨김 */
    /* 아래 #myPaletteDiv 대신 1단계에서 찾은 팔레트의 실제 ID를 적어주세요 */
    #myPaletteDiv, .palette, #palette-container, .sb-left { 
        display: none !important; 
    }

    /* 3. [중요] 속성창(정보창) 숨김 */
    /* 아래 #myInspectorDiv 대신 1단계에서 찾은 속성창의 실제 ID를 적어주세요 */
    #myInspectorDiv, .inspector, #prop-panel, .sb-right { 
        display: none !important; 
    }

    /* 4. 전체 레이아웃 초기화 (여백 제거) */
    body, html, #wrapper, #content-wrapper, .container-fluid {
        margin: 0 !important;
        padding: 0 !important;
        background-color: #fff !important; /* 배경 흰색 */
        height: 100% !important;
        overflow: hidden !important; /* 스크롤바 제거 */
    }

    /* 5. 도면(캔버스) 영역을 전체 화면으로 꽉 채우기 */
    /* 도면이 그려지는 DIV의 ID가 myDiagramDiv가 아니라면 수정해주세요 */
    #myDiagramDiv, .diagram-component {
        width: 100vw !important;
        height: 100vh !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        border: none !important;
        z-index: 9999 !important; /* 제일 위로 */
    }

    /* [추가] 팔레트로 추정되는 모든 요소를 강력하게 숨김 */
    
    /* 1. GoJS 기본 팔레트 ID 후보들 */
    #myPaletteDiv, #myPalette, #paletteDiv, #palette, 
    #sideBar, #sidebar, #left-sidebar,
    
    /* 2. 클래스명으로 숨기기 (공통적으로 많이 쓰이는 이름) */
    .palette, .palette-area, .draggable-list, 
    .sb-left, .sidebar-left, .tools-container,
    
    /* 3. 캔버스(canvas) 태그가 들어있는 왼쪽 영역 강제 숨김 (주의해서 사용) */
    div[style*="position: absolute"][style*="left: 0"]:not(#myDiagramDiv) {
        display: none !important;
    }

    /* 4. 다이어그램 영역을 강제로 전체 화면으로 늘리기 */
    #myDiagramDiv {
        width: 100vw !important; /* 화면 가로 100% */
        height: 100vh !important; /* 화면 세로 100% */
        left: 0 !important;       /* 왼쪽 여백 제거 */
        top: 0 !important;        /* 위쪽 여백 제거 */
        margin: 0 !important;
    }
</style>

<script>
    window.addEventListener('load', function() {
        var checkTimer = setInterval(function() {
            // GoJS 객체(myDiagram)가 생성되었는지 확인
            if (typeof myDiagram !== 'undefined' && typeof go !== 'undefined') {
                clearInterval(checkTimer);

                // =========================================================
                // 1. [편집 및 조작 방지]
                // =========================================================
                myDiagram.isReadOnly = true;          // 편집 불가
                myDiagram.allowZoom = false;          // 사용자 줌 조작 금지
                myDiagram.allowSelect = false;        // 선택 금지
                myDiagram.allowHorizontalScroll = false; 
                myDiagram.allowVerticalScroll = false;

                // =========================================================
                // 2. [화면 맞춤(Zoom to Fit) 강력 적용]
                // =========================================================
                
                // (중요) 아주 작게 축소될 수 있도록 최소 배율 제한을 풉니다.
                myDiagram.minScale = 0.01; 
                
                // 내용물을 캔버스 정중앙에 위치시킵니다.
                myDiagram.contentAlignment = go.Spot.Center;
                
                // 캔버스 여백을 없앱니다.
                myDiagram.padding = new go.Margin(2, 2, 2, 2);

                // [핵심] 캔버스 크기에 맞춰 내용물 비율을 자동으로 조절합니다. (Uniform: 가로세로 비율 유지)
                myDiagram.autoScale = go.Diagram.Uniform; 

                // 강제로 레이아웃을 다시 계산하고 화면을 맞춥니다.
                myDiagram.layoutDiagram(true);
                myDiagram.commandHandler.zoomToFit();

                // 데이터 로딩이 늦어질 경우를 대비해 '배치 완료' 이벤트에 훅을 겁니다.
                myDiagram.addDiagramListener("InitialLayoutCompleted", function(e) {
                    myDiagram.zoomToFit();
                });
            }
        }, 100); // 0.1초마다 체크
    });
</script>
<?php endif; ?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Layout Designer</title>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* 기본 레이아웃 */
        body { margin: 0; padding: 0; font-family: 'Segoe UI', 'Malgun Gothic', sans-serif; overflow: hidden; display: flex; flex-direction: column; height: 100vh; background-color: #f5f6f7; }
        
        /* 헤더 */
        header { height: 50px; background-color: #2c3e50; color: white; display: flex; align-items: center; padding: 0 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 1000; justify-content: space-between; }
        header h1 { font-size: 18px; margin: 0; font-weight: 600; }
        .toolbar-group { display: flex; align-items: center; }
        .toolbar-btn { background-color: #3498db; border: none; color: white; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-size: 13px; margin-left: 10px; display: flex; align-items: center; }
        .toolbar-btn:hover { background-color: #2980b9; }
        .btn-layer { background-color: #e67e22; } .btn-layer:hover { background-color: #d35400; }
        .btn-load { background-color: #95a5a6; } .btn-load:hover { background-color: #7f8c8d; }
        .btn-undo { background-color: #8e44ad; } .btn-undo:hover { background-color: #9b59b6; }

        /* 메인 영역 */
        #main-container { display: flex; flex: 1; overflow: hidden; }
        #sidebar { width: 240px; background-color: #ffffff; border-right: 1px solid #ddd; display: flex; flex-direction: column; box-shadow: 2px 0 5px rgba(0,0,0,0.05); z-index: 900; }
        .sidebar-header { padding: 15px; background-color: #ecf0f1; border-bottom: 1px solid #ddd; font-weight: bold; font-size: 14px; color: #555; text-transform: uppercase; }
        .palette-list { padding: 15px; overflow-y: auto; flex: 1; }
        
        /* 팔레트 아이템 */
        .palette-item { display: flex; align-items: center; padding: 10px; margin-bottom: 10px; background-color: #fff; border: 1px solid #e0e0e0; border-radius: 4px; cursor: move; transition: box-shadow 0.2s, border-color 0.2s, transform 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .palette-item:hover { border-color: #3498db; box-shadow: 0 2px 5px rgba(52, 152, 219, 0.2); transform: translateY(-1px); }
        .palette-item i { margin-right: 10px; color: #7f8c8d; font-size: 16px; width: 20px; text-align: center; }
        .palette-item span { font-size: 13px; font-weight: 500; color: #333; }
        .palette-separator { margin: 15px 0 5px 0; font-size: 11px; color: #999; font-weight: bold; border-bottom: 1px solid #eee; padding-bottom: 3px; }
        .ui-draggable-dragging { transition: none !important; }

        /* 캔버스 */
        #canvas-wrapper { flex: 1; position: relative; overflow: auto; background-color: #f9f9f9; }
        #canvas {
            width: 3000px; height: 2000px; position: relative; 
            background-image: linear-gradient(#e0e0e0 1px, transparent 1px), linear-gradient(90deg, #e0e0e0 1px, transparent 1px);
            background-size: 20px 20px; background-color: #fcfcfc; z-index: 0;
            transform-origin: 0 0;
        }

        /* 우측 속성 패널 */
        #prop-panel { width: 250px; background-color: #fff; border-left: 1px solid #ddd; display: flex; flex-direction: column; z-index: 900; box-shadow: -2px 0 5px rgba(0,0,0,0.05); }
        .prop-content { padding: 15px; overflow-y: auto; flex: 1; }
        .prop-group { margin-bottom: 15px; }
        .prop-group label { display: block; font-size: 12px; color: #666; margin-bottom: 5px; font-weight: 600; }
        .prop-group input, .prop-group select, .prop-group textarea { width: 100%; padding: 8px; font-size: 13px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; background-color: #fafafa; }
        .prop-group input:focus, .prop-group textarea:focus { border-color: #3498db; background-color: #fff; outline: none; }
        .prop-row { display: flex; gap: 10px; }
        .no-selection { text-align: center; color: #999; margin-top: 50px; font-size: 13px; }

        /* 아이템 스타일 */
        .design-item { position: absolute !important; display: flex; flex-direction: column; user-select: none; box-sizing: border-box; }
        .design-item.selected { z-index: 1000 !important; }
        
        .design-item.type-box { background: white; border: 1px solid #ccc; box-shadow: 2px 2px 5px rgba(0,0,0,0.1); border-radius: 4px; }
        .design-item.type-box.selected { border: 2px solid #3498db; box-shadow: 0 0 8px rgba(52, 152, 219, 0.4); }
        .design-item.type-shape { background: transparent; border: none; box-shadow: none; align-items: center; justify-content: center; }
        .design-item.type-shape.selected { outline: 1px dashed #3498db; }

        .item-header { height: 24px; background-color: #ecf0f1; border-bottom: 1px solid #ddd; cursor: move; display: flex; align-items: center; justify-content: center; }
        .type-box.selected .item-header { background-color: #3498db; }
        .item-content { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 5px; pointer-events: none; }
        .item-content i { font-size: 24px; color: #555; margin-bottom: 5px; }
        .item-content span { font-size: 12px; text-align: center; color: #333; font-weight: 600; line-height: 1.2; }

        .shape-body { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; pointer-events: none; }
        .shape-line { width: 100%; height: 4px; background-color: #333; position: relative; }
        .shape-arrow-head { position: absolute; right: 0; top: 50%; transform: translateY(-50%); width: 0; height: 0; border-top: 6px solid transparent; border-bottom: 6px solid transparent; border-left: 10px solid #333; }
        .shape-door { width: 100%; height: 100%; position: relative; pointer-events: none; }
        .door-arc { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border-top: 2px dashed #555; border-right: 2px dashed #555; border-radius: 0 100% 0 0; box-sizing: border-box; }
        .door-panel { position: absolute; top: 0; left: 0; width: 4px; height: 100%; background-color: #333; border: 1px solid #000; }

        .btn-delete-item { display: none; position: absolute; top: -10px; right: -10px; width: 20px; height: 20px; background: #e74c3c; color: white; border-radius: 50%; text-align: center; line-height: 20px; font-size: 12px; cursor: pointer; z-index: 99999; box-shadow: 0 1px 3px rgba(0,0,0,0.3); }
        .design-item.selected .btn-delete-item { display: block; }
        .rotate-handle { display: none; position: absolute; top: -30px; left: 50%; transform: translateX(-50%); width: 12px; height: 12px; background-color: #fff; border: 2px solid #2c3e50; border-radius: 50%; cursor: grab; z-index: 99999; }
        .rotate-handle::after { content: ''; position: absolute; top: 12px; left: 50%; width: 1px; height: 20px; background-color: #2c3e50; transform: translateX(-50%); }
        .design-item.selected .rotate-handle { display: block; }

        .ui-resizable-handle { opacity: 0; z-index: 99990 !important; }
        .design-item.selected .ui-resizable-handle, .design-item:hover .ui-resizable-handle { background-color: #3498db; opacity: 0.5; }
        .ui-draggable-dragging { transition: none !important; }

        /* [NEW] 스마트 가이드라인 스타일 */
        .smart-guide { position: absolute; background-color: red; pointer-events: none; z-index: 99999; }
        .smart-guide-v { width: 1px; border-left: 1px dashed red; background: none; }
        .smart-guide-h { height: 1px; border-top: 1px dashed red; background: none; }
    </style>
</head>
<body>

    <header>
        <div style="display:flex; align-items:center;">
            <i class="fa-solid fa-industry" style="margin-right:10px; font-size:20px;"></i>
            <h1>공장 장비 레이아웃 (Layout Designer)</h1>
        </div>
        <div class="toolbar-group">
            <button class="toolbar-btn btn-undo" onclick="undo()" title="단축키: Ctrl + Z">
                <i class="fa-solid fa-rotate-left"></i> 실행취소
            </button>
            <span style="margin: 0 10px; border-left:1px solid #ffffff50; height:20px;"></span>
            <button class="toolbar-btn btn-layer" onclick="saveHistory(); bringToFront()"><i class="fa-solid fa-arrow-up-from-bracket"></i> 맨 앞으로</button>
            <button class="toolbar-btn btn-layer" onclick="saveHistory(); sendToBack()"><i class="fa-solid fa-arrow-down"></i> 맨 뒤로</button>
            <span style="margin: 0 10px; border-left:1px solid #ffffff50; height:20px;"></span>
            <button class="toolbar-btn btn-load" onclick="loadLayout()"><i class="fa-solid fa-rotate-right"></i> 초기화/불러오기</button>
            <button class="toolbar-btn" onclick="saveLayout()"><i class="fa-solid fa-floppy-disk"></i> 저장 (Save)</button>
        </div>
    </header>

    <div id="main-container">
        <div id="sidebar">
            <div class="sidebar-header">Palette</div>
            <div class="palette-list">
                <div class="palette-separator">설비 목록 (DB)</div>
                <div id="dynamic-palette">
                    <div style="padding:10px; text-align:center; color:#999;"><i class="fa-solid fa-spinner fa-spin"></i> Loading...</div>
                </div>

                <div class="palette-separator">도면 기호</div>
                <div class="palette-item" data-type="HYDRANT" data-name="소화전"><i class="fa-solid fa-faucet"></i> <span>소화전</span></div>
                <div class="palette-item" data-type="EXTINGUISHER" data-name="소화기"><i class="fa-solid fa-fire-extinguisher"></i> <span>소화기</span></div>
                <div class="palette-item" data-type="DIST_BOARD" data-name="배전함"><i class="fa-solid fa-bolt"></i> <span>배전함</span></div>
                <div class="palette-item" data-type="DOOR" data-name="문 (Door)"><i class="fa-solid fa-door-open"></i> <span>출입문</span></div>
                <div class="palette-item" data-type="LINE" data-name="라인 (Line)"><i class="fa-solid fa-minus"></i> <span>라인 / 벽</span></div>
                <div class="palette-item" data-type="ARROW" data-name="화살표 (Arrow)"><i class="fa-solid fa-arrow-right"></i> <span>화살표</span></div>
            </div>
        </div>

        <div id="canvas-wrapper">
            <div id="canvas"></div>
        </div>

        <div id="prop-panel">
            <div class="sidebar-header">속성 (Properties)</div>
            <div class="prop-content">
                <div id="prop-empty" class="no-selection">
                    <i class="fa-regular fa-hand-pointer" style="font-size:30px; margin-bottom:10px;"></i><br>
                    아이템을 선택하세요.
                </div>
                <div id="prop-form" style="display:none;">
                    <div class="prop-group"><label>ID</label><input type="text" id="p-id" readonly style="background:#eee; color:#777;"></div>
                    <div class="prop-group"><label>이름 (Name)</label><input type="text" id="p-name"></div>
                    <div class="prop-row">
                        <div class="prop-group" style="flex:1;"><label>X 좌표</label><input type="number" id="p-x"></div>
                        <div class="prop-group" style="flex:1;"><label>Y 좌표</label><input type="number" id="p-y"></div>
                    </div>
                    <div class="prop-row">
                        <div class="prop-group" style="flex:1;"><label>너비 (W)</label><input type="number" id="p-w"></div>
                        <div class="prop-group" style="flex:1;"><label>높이 (H)</label><input type="number" id="p-h"></div>
                    </div>
                    <div class="prop-group"><label>회전 각도</label><input type="number" id="p-r"></div>
                    <div class="prop-group"><label>상태</label><select id="p-status"><option value="NORMAL">정상</option><option value="WARNING">점검</option><option value="ERROR">고장</option><option value="STOP">정지</option></select></div>
                    <div class="prop-group"><label>설명</label><textarea id="p-desc" rows="4"></textarea></div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        
        var historyStack = [];
        var MAX_HISTORY = 30;

        window.saveHistory = function() {
            var items = [];
            $(".design-item").each(function() {
                var $el = $(this);
                items.push({
                    id: $el.data("id"), name: $el.find("span").text() || "", 
                    x: Math.round(parseInt($el.css('left'), 10) || 0), y: Math.round(parseInt($el.css('top'), 10) || 0),
                    w: Math.round($el.width()), h: Math.round($el.height()),
                    z: parseInt($el.css('z-index'), 10) || 10, r: Math.round(parseFloat($el.data("rotation")) || 0),
                    desc: $el.data("desc") || "", status: $el.data("status") || "NORMAL"
                });
            });
            historyStack.push(JSON.stringify(items));
            if (historyStack.length > MAX_HISTORY) historyStack.shift();
        };

        window.undo = function() {
            if (historyStack.length === 0) { alert("이전 작업 내역이 없습니다."); return; }
            var previousStateJSON = historyStack.pop();
            var items = JSON.parse(previousStateJSON);
            $("#canvas").empty(); updatePropPanel(null);
            items.forEach(function(item) {
                var displayName = item.name && item.name !== "" ? item.name : item.id;
                createDesignItem(item.id, displayName, item.x, item.y, item.w, item.h, item.z, item.r, item.desc, item.status);
            });
        };

        $(document).keydown(function(e) { if ((e.ctrlKey || e.metaKey) && e.key === 'z') { e.preventDefault(); undo(); } });

        function getIconClass(name) {
            if (!name) return "fa-cube";
            var n = name.toUpperCase();
            if (n.includes("소화기") || n.includes("EXTINGUISHER")) return "fa-fire-extinguisher";
            if (n.includes("소화전") || n.includes("HYDRANT")) return "fa-faucet";
            if (n.includes("배전함") || n.includes("DIST")) return "fa-bolt";
            if (n.includes("TEST") || n.includes("테스트")) return "fa-flask";
            if (n.includes("TEMPERATURE") || n.includes("TEMERATURE") || n.includes("항습")) return "fa-temperature-high";
            if (n.includes("ROBOT") || n.includes("로봇")) return "fa-robot";
            if (n.includes("CONVEYOR") || n.includes("챔버")) return "fa-campground";
            if (n.includes("X-RAY") || n.includes("RAY")) return "fa-x-ray";
            if (n.includes("SOUND") || n.includes("무향실")) return "fa-volume-mute";
            if (n.includes("WIND") || n.includes("풍량")) return "fa-wind";
            if (n.includes("열충격") || n.includes("연소")) return "fa-fire";
            if (n.includes("WATER") || n.includes("염수")) return "fa-tint";
            if (n.includes("내구") || n.includes("진동")) return "fa-wave-square";
            if (n.includes("DUST") || n.includes("먼지")) return "fa-head-side-mask";
            if (n.includes("BENDING") || n.includes("밴드")) return "fa-ring";
            if (n.includes("DRY") || n.includes("드라이")) return "fa-tint-slash";
            if (n.includes("ＵＴＭ") || n.includes("UTM")) return "fa-underline";
            if (n.includes("CYCLE") || n.includes("사이클")) return "fa-undo-alt";
            if (n.includes("FOLDING") || n.includes("폴딩")) return "fa-chevron-up";
            return "fa-cube"; 
        }

        function loadPaletteList() {
            $.ajax({
                url: 'layout_view_status.php', type: 'POST', data: { mode: 'LOAD_PALETTE' }, dataType: 'json',
                success: function(res) {
                    var $container = $("#dynamic-palette");
                    $container.empty();
                    if (res.status === 'success' && res.data && res.data.length > 0) {
                        res.data.forEach(function(equipName) {
                            var iconClass = getIconClass(equipName); 
                            var html = `<div class="palette-item" data-type="EQUIP" data-name="${equipName}"><i class="fa-solid ${iconClass}"></i> <span>${equipName}</span></div>`;
                            $container.append(html);
                        });
                        initDraggable();
                    } else { $container.html('<div style="padding:10px; text-align:center;">설비 데이터 없음</div>'); }
                }
            });
        }

        function initDraggable() {
            $(".palette-item").draggable({ helper: "clone", appendTo: "body", revert: "invalid", zIndex: 9999, cursor: "move" });
        }

        loadPaletteList();
        initDraggable();

        $("#canvas").droppable({
            accept: ".palette-item",
            drop: function(event, ui) {
                if (ui.helper.hasClass("palette-item")) {
                    saveHistory(); 
                    var helperRect = ui.helper[0].getBoundingClientRect(); 
                    var canvasRect = this.getBoundingClientRect(); 
                    var computed = window.getComputedStyle(this);
                    var borderL = parseFloat(computed.borderLeftWidth) || 0;
                    var borderT = parseFloat(computed.borderTopWidth) || 0;

                    var posX = helperRect.left - canvasRect.left - borderL;
                    var posY = helperRect.top - canvasRect.top - borderT;
                    posX = Math.max(0, Math.round(posX / 20) * 20);
                    posY = Math.max(0, Math.round(posY / 20) * 20);

                    var type = ui.helper.data("type");
                    var name = ui.helper.data("name");
                    var uniqueId = "ID_" + Date.now() + "_" + Math.floor(Math.random() * 100); 
                    var maxZ = getMaxZIndex();

                    var w = 120, h = 80;
                    if(type === 'LINE') { w = 200; h = 20; } 
                    if(type === 'ARROW') { w = 150; h = 40; } 
                    if(type === 'DOOR') { w = 40; h = 40; } 
                    if(type === 'HYDRANT' || type === 'EXTINGUISHER' || type === 'DIST_BOARD') { w = 80; h = 80; }

                    createDesignItem(uniqueId, name, posX, posY, w, h, maxZ + 1, 0, "", "NORMAL"); 
                }
            }
        });

        $("#canvas").on("mousedown", function(e) { if (e.target.id === "canvas") { $(".design-item").removeClass("selected"); updatePropPanel(null); } });
        $(document).keydown(function(e) { 
            if (e.key === "Delete") { 
                if ($(".design-item.selected").length > 0) { saveHistory(); $(".design-item.selected").remove(); updatePropPanel(null); }
            }
        });

        var $currentEl = null;
        $("#prop-form input, #prop-form textarea, #prop-form select").on("focus", function() { saveHistory(); });
        $("#p-name").on("input", function() { if($currentEl) { var val=$(this).val(); $currentEl.find("span").text(val); $currentEl.find("i").attr("class", "fa-solid "+getIconClass(val)); } });
        $("#p-x").on("input", function() { if($currentEl) $currentEl.css("left", $(this).val() + "px"); });
        $("#p-y").on("input", function() { if($currentEl) $currentEl.css("top", $(this).val() + "px"); });
        $("#p-w").on("input", function() { if($currentEl) $currentEl.css("width", $(this).val() + "px"); });
        $("#p-h").on("input", function() { if($currentEl) $currentEl.css("height", $(this).val() + "px"); });
        $("#p-r").on("input", function() { if($currentEl) { var deg=$(this).val(); $currentEl.css("transform", `rotate(${deg}deg)`); $currentEl.data("rotation", deg); } });
        $("#p-desc").on("input", function() { if($currentEl) $currentEl.data("desc", $(this).val()); });
        $("#p-status").on("change", function() { if($currentEl) $currentEl.data("status", $(this).val()); });

        function updatePropPanel($el) {
            $currentEl = $el;
            if ($el && $el.length > 0) {
                $("#prop-empty").hide(); $("#prop-form").show();
                $("#p-id").val($el.data("id"));
                $("#p-name").val($el.find("span").text());
                $("#p-x").val(parseInt($el.css("left")) || 0);
                $("#p-y").val(parseInt($el.css("top")) || 0);
                $("#p-w").val($el.outerWidth());
                $("#p-h").val($el.outerHeight());
                $("#p-r").val(parseFloat($el.data("rotation")) || 0);
                $("#p-desc").val($el.data("desc") || "");
                $("#p-status").val($el.data("status") || "NORMAL");
            } else { $("#prop-empty").show(); $("#prop-form").hide(); $currentEl = null; }
        }

        // ==========================================
        //  스마트 가이드 유틸리티
        // ==========================================
        function clearSmartGuides() { $(".smart-guide").remove(); }
        
        function drawSmartGuide(x, y, w, h, type) {
            var $guide = $("<div>").addClass("smart-guide");
            if (type === 'v') $guide.addClass("smart-guide-v").css({ left: x, top: y, height: h });
            else $guide.addClass("smart-guide-h").css({ left: x, top: y, width: w });
            $("#canvas").append($guide);
        }

        // 아이템 생성
        window.createDesignItem = function(id, name, x, y, w, h, z, r, desc, status) {
            x = isNaN(x) ? 0 : x; y = isNaN(y) ? 0 : y;
            w = isNaN(w) ? 100 : w; h = isNaN(h) ? 60 : h;
            z = isNaN(z) ? 10 : z; r = isNaN(r) ? 0 : r;
            desc = desc || ""; status = status || "NORMAL";

            var isLine = id.includes("LINE") || name === "라인 (Line)";
            var isArrow = id.includes("ARROW") || name === "화살표 (Arrow)";
            var isDoor = id.includes("DOOR") || name === "문 (Door)";
            var isShape = isLine || isArrow || isDoor;

            var innerHTML = "";
            var itemClass = "design-item";
            var resizeHandles = "all"; 

            if (isShape) {
                itemClass += " type-shape";
                if (isLine) { innerHTML = `<div class="shape-body"><div class="shape-line"></div></div>`; resizeHandles = "e, w"; } 
                else if (isArrow) { innerHTML = `<div class="shape-body"><div class="shape-line"></div><div class="shape-arrow-head"></div></div>`; resizeHandles = "e, w"; } 
                else if (isDoor) { innerHTML = `<div class="shape-door"><div class="door-panel"></div><div class="door-arc"></div></div>`; }
            } else {
                itemClass += " type-box";
                var iconClass = getIconClass(name);
                innerHTML = `<div class="item-header"></div><div class="item-content"><i class="fa-solid ${iconClass}"></i><span>${name}</span></div>`;
            }

            var html = `
                <div class="${itemClass}" id="${id}" data-id="${id}" data-rotation="${r}" data-desc="${desc}" data-status="${status}"
                     style="position:absolute; left:${x}px; top:${y}px; width:${w}px; height:${h}px; margin:0; z-index:${z}; transform: rotate(${r}deg);">
                    <div class="rotate-handle" title="회전"></div>
                    ${innerHTML}
                    <div class="btn-delete-item" title="삭제">X</div>
                </div>
            `;
            
            var $item = $(html);
            $("#canvas").append($item);

            $item.find(".btn-delete-item").click(function(e) { 
                e.stopPropagation(); 
                if(confirm("삭제하시겠습니까?")) { saveHistory(); $(this).closest(".design-item").remove(); updatePropPanel(null); }
            });

            $item.on("dblclick", function(e) {
                if ($(e.target).hasClass("rotate-handle") || $(e.target).hasClass("btn-delete-item")) return;
                if (!isShape) {
                    var oldName = $(this).find("span").text();
                    var newName = prompt("이름 변경:", oldName);
                    if (newName) { saveHistory(); $(this).find("span").text(newName); $(this).find("i").attr("class", "fa-solid " + getIconClass(newName)); updatePropPanel($(this)); }
                }
            });

            $item.on("mousedown", function(e) {
                if (!$(e.target).hasClass("rotate-handle")) {
                    if (!e.ctrlKey) $(".design-item").removeClass("selected");
                    $(this).addClass("selected");
                    updatePropPanel($(this));
                }
            });

            // [수정] 드래그 - 스마트 가이드 적용
            var dragHandle = isShape ? null : ".item-header, .item-content";
            $item.draggable({
                containment: "#canvas", 
                handle: dragHandle, 
                // grid: [20, 20],  <-- [삭제] 스마트 가이드와 충돌하므로 제거
                start: function() { saveHistory(); $(this).addClass("selected"); updatePropPanel($(this)); },
                drag: function(event, ui) {
                    $("#p-x").val(ui.position.left); $("#p-y").val(ui.position.top);
                    
                    // --- 스마트 가이드 및 스냅 (이동용) ---
                    clearSmartGuides();
                    var TOLERANCE = 15;
                    var snappedX = false, snappedY = false;
                    
                    var l = ui.position.left, t = ui.position.top;
                    var w = $(this).outerWidth(), h = $(this).outerHeight();
                    var r = l + w, b = t + h;
                    var cx = l + w/2, cy = t + h/2;

                    $(".design-item").not(this).each(function() {
                        var $other = $(this);
                        var ol = parseInt($other.css('left'))||0, ot = parseInt($other.css('top'))||0;
                        var ow = $other.outerWidth(), oh = $other.outerHeight();
                        var or = ol + ow, ob = ot + oh;
                        var ocx = ol + ow/2, ocy = ot + oh/2;

                        // [가로 축 정렬]
                        // 좌측-좌측
                        if(Math.abs(l - ol) < TOLERANCE) { ui.position.left = ol; snappedX=true; drawSmartGuide(ol, Math.min(t,ot), 0, Math.max(b,ob)-Math.min(t,ot), 'v'); }
                        // 좌측-우측
                        else if(Math.abs(l - or) < TOLERANCE) { ui.position.left = or; snappedX=true; drawSmartGuide(or, Math.min(t,ot), 0, Math.max(b,ob)-Math.min(t,ot), 'v'); }
                        // 우측-좌측
                        else if(Math.abs(r - ol) < TOLERANCE) { ui.position.left = ol - w; snappedX=true; drawSmartGuide(ol, Math.min(t,ot), 0, Math.max(b,ob)-Math.min(t,ot), 'v'); }
                        // 우측-우측
                        else if(Math.abs(r - or) < TOLERANCE) { ui.position.left = or - w; snappedX=true; drawSmartGuide(or, Math.min(t,ot), 0, Math.max(b,ob)-Math.min(t,ot), 'v'); }
                        // 중앙-중앙
                        else if(Math.abs(cx - ocx) < TOLERANCE) { ui.position.left = ocx - w/2; snappedX=true; drawSmartGuide(ocx, Math.min(t,ot), 0, Math.max(b,ob)-Math.min(t,ot), 'v'); }

                        // [세로 축 정렬]
                        // 상단-상단
                        if(Math.abs(t - ot) < TOLERANCE) { ui.position.top = ot; snappedY=true; drawSmartGuide(Math.min(l,ol), ot, Math.max(r,or)-Math.min(l,ol), 0, 'h'); }
                        // 상단-하단
                        else if(Math.abs(t - ob) < TOLERANCE) { ui.position.top = ob; snappedY=true; drawSmartGuide(Math.min(l,ol), ob, Math.max(r,or)-Math.min(l,ol), 0, 'h'); }
                        // 하단-상단
                        else if(Math.abs(b - ot) < TOLERANCE) { ui.position.top = ot - h; snappedY=true; drawSmartGuide(Math.min(l,ol), ot, Math.max(r,or)-Math.min(l,ol), 0, 'h'); }
                        // 하단-하단
                        else if(Math.abs(b - ob) < TOLERANCE) { ui.position.top = ob - h; snappedY=true; drawSmartGuide(Math.min(l,ol), ob, Math.max(r,or)-Math.min(l,ol), 0, 'h'); }
                        // 중앙-중앙
                        else if(Math.abs(cy - ocy) < TOLERANCE) { ui.position.top = ocy - h/2; snappedY=true; drawSmartGuide(Math.min(l,ol), ocy, Math.max(r,or)-Math.min(l,ol), 0, 'h'); }
                    });

                    // 스냅되지 않았을 때만 격자(20px) 적용
                    if(!snappedX) ui.position.left = Math.round(l / 20) * 20;
                    if(!snappedY) ui.position.top = Math.round(t / 20) * 20;
                },
                stop: function() { clearSmartGuides(); }
            });

            // 리사이즈 - 스마트 가이드 적용
            $item.resizable({
                containment: "#canvas", grid: [10, 10], handles: resizeHandles, minWidth: 20, minHeight: 20,
                start: function() { saveHistory(); },
                resize: function(event, ui) {
                    $("#p-w").val(ui.size.width); $("#p-h").val(ui.size.height);
                    clearSmartGuides();
                    
                    var TOLERANCE = 10;
                    var l = ui.position.left, t = ui.position.top;
                    var w = ui.size.width, h = ui.size.height;
                    var r = l + w, b = t + h;

                    $(".design-item").not(this).each(function() {
                        var $other = $(this);
                        var ol = parseInt($other.css('left'))||0, ot = parseInt($other.css('top'))||0;
                        var ow = $other.outerWidth(), oh = $other.outerHeight();
                        var or = ol + ow, ob = ot + oh;

                        // Width 리사이징 시 세로선 스냅
                        if (Math.abs(r - ol) < TOLERANCE) { ui.size.width = ol - l; drawSmartGuide(ol, Math.min(t,ot), 0, Math.max(b,ob)-Math.min(t,ot), 'v'); } 
                        else if (Math.abs(r - or) < TOLERANCE) { ui.size.width = or - l; drawSmartGuide(or, Math.min(t,ot), 0, Math.max(b,ob)-Math.min(t,ot), 'v'); }

                        // Height 리사이징 시 가로선 스냅
                        if (Math.abs(b - ot) < TOLERANCE) { ui.size.height = ot - t; drawSmartGuide(Math.min(l,ol), ot, Math.max(r,or)-Math.min(l,ol), 0, 'h'); } 
                        else if (Math.abs(b - ob) < TOLERANCE) { ui.size.height = ob - t; drawSmartGuide(Math.min(l,ol), ob, Math.max(r,or)-Math.min(l,ol), 0, 'h'); }
                    });
                },
                stop: function() { clearSmartGuides(); }
            });

            var $handle = $item.find(".rotate-handle");
            $handle.on("mousedown", function(e) {
                saveHistory(); e.preventDefault(); e.stopPropagation();
                var $target = $item; var offset = $target.offset();
                var centerX = offset.left + $target.outerWidth() / 2; var centerY = offset.top + $target.outerHeight() / 2;
                $(document).on("mousemove.rotate", function(e2) {
                    var angle = Math.atan2(e2.pageY - centerY, e2.pageX - centerX) * (180 / Math.PI);
                    angle += 90; if (e2.shiftKey) angle = Math.round(angle / 15) * 15;
                    $target.css("transform", `rotate(${angle}deg)`); $target.data("rotation", angle);
                    $("#p-r").val(Math.round(angle));
                });
                $(document).on("mouseup.rotate", function() { $(document).off("mousemove.rotate mouseup.rotate"); });
            });
        };

        // 유틸리티 및 저장/로드
        function getMaxZIndex() { var maxZ=10; $(".design-item").each(function(){var z=parseInt($(this).css("z-index"))||10;if(z>maxZ)maxZ=z;}); return maxZ; }
        function getMinZIndex() { var minZ=10; $(".design-item").each(function(){var z=parseInt($(this).css("z-index"))||10;if(z<minZ)minZ=z;}); return minZ; }
        window.bringToFront = function() { $(".design-item.selected").css("z-index", getMaxZIndex() + 1); };
        window.sendToBack = function() { $(".design-item.selected").css("z-index", getMinZIndex() - 1); };

        window.saveLayout = function() {
            var items = [];
            $(".design-item").each(function() {
                var $el = $(this);
                items.push({
                    id: $el.data("id"), name: $el.find("span").text() || "", 
                    x: Math.round(parseInt($el.css('left'), 10) || 0), y: Math.round(parseInt($el.css('top'), 10) || 0),
                    w: Math.round($el.width()), h: Math.round($el.height()),
                    z: parseInt($el.css('z-index'), 10) || 10, r: Math.round(parseFloat($el.data("rotation")) || 0),
                    desc: $el.data("desc") || "", status: $el.data("status") || "NORMAL"
                });
            });
            $.ajax({
                url: 'layout_view_status.php', type: 'POST', data: { mode: 'SAVE', items: JSON.stringify(items) }, dataType: 'json',
                success: function(res) { if(res.status === 'success') alert("저장되었습니다."); else alert("오류: " + res.message); }
            });
        };

        window.loadLayout = function() { if(confirm("불러오시겠습니까?")) initialLoad(); };

        function initialLoad() {
            $.ajax({
                url: 'layout_view_status.php', type: 'POST', data: { mode: 'LOAD' }, dataType: 'json',
                success: function(res) {
                    if(res.status === 'success') {
                        $("#canvas").empty(); updatePropPanel(null); historyStack = []; 
                        if (res.data && res.data.length > 0) {
                            res.data.forEach(function(item) {
                                var displayName = item.EQUIP_NAME && item.EQUIP_NAME !== "" ? item.EQUIP_NAME : item.EQUIP_ID;
                                createDesignItem(item.EQUIP_ID, displayName, parseInt(item.POS_X), parseInt(item.POS_Y), parseInt(item.WIDTH), parseInt(item.HEIGHT), parseInt(item.Z_INDEX), parseInt(item.ROTATION), item.DESCRIPTION, item.STATUS);
                            });
                        }
                    }
                }
            });
        }
        initialLoad(); 
    });
    </script>
</body>
</html>