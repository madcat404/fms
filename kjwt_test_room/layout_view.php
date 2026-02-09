<?php
// [설정] 대시보드에서 호출된 경우인지 확인 (?view_only=1 파라미터 체크)
$is_view_mode = isset($_GET['view_only']) && $_GET['view_only'] == '1';
?>
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
        /* [공통 스타일] */
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

        /* 메인 컨테이너 */
        #main-container { display: flex; flex: 1; overflow: hidden; }
        
        /* 좌측 팔레트 */
        #sidebar { width: 240px; background-color: #ffffff; border-right: 1px solid #ddd; display: flex; flex-direction: column; box-shadow: 2px 0 5px rgba(0,0,0,0.05); z-index: 900; }
        .sidebar-header { padding: 15px; background-color: #ecf0f1; border-bottom: 1px solid #ddd; font-weight: bold; font-size: 14px; color: #555; text-transform: uppercase; }
        .palette-list { padding: 15px; overflow-y: auto; flex: 1; }
        .palette-item { display: flex; align-items: center; padding: 10px; margin-bottom: 10px; background-color: #fff; border: 1px solid #e0e0e0; border-radius: 4px; cursor: move; transition: box-shadow 0.2s, border-color 0.2s, transform 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .palette-item:hover { border-color: #3498db; box-shadow: 0 2px 5px rgba(52, 152, 219, 0.2); transform: translateY(-1px); }
        .palette-item i { margin-right: 10px; color: #7f8c8d; font-size: 16px; width: 20px; text-align: center; }
        .palette-item span { font-size: 13px; font-weight: 500; color: #333; }
        .palette-separator { margin: 15px 0 5px 0; font-size: 11px; color: #999; font-weight: bold; border-bottom: 1px solid #eee; padding-bottom: 3px; }

        /* 캔버스 영역 */
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
        .prop-row { display: flex; gap: 10px; }
        .no-selection { text-align: center; color: #999; margin-top: 50px; font-size: 13px; }

        /* 아이템 디자인 */
        .design-item { position: absolute !important; display: flex; flex-direction: column; user-select: none; box-sizing: border-box; }
        .design-item.type-box { background: white; border: 1px solid #ccc; box-shadow: 2px 2px 5px rgba(0,0,0,0.1); border-radius: 4px; }
        .design-item.type-box.selected { border: 2px solid #3498db; box-shadow: 0 0 8px rgba(52, 152, 219, 0.4); }
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

        /* =================================================================
           [대시보드 뷰 모드 전용 스타일]
           ================================================================= */
        <?php if ($is_view_mode): ?>
            /* 1. 상단/좌측/우측 패널 숨김 */
            header, #sidebar, #prop-panel { 
                display: none !important; 
            }

            /* 2. 전체 레이아웃 초기화 */
            body, html, #main-container {
                padding: 0 !important; margin: 0 !important;
                background-color: transparent !important;
                width: 100vw !important; height: 100vh !important;
            }

            /* 3. 캔버스 래퍼: 중앙 정렬을 위한 설정 */
            #canvas-wrapper {
                overflow: hidden !important;
                background-color: #fff !important;
                position: relative !important; /* 자식 absolute 배치를 위해 relative */
                width: 100% !important;
                height: 100% !important;
            }

            /* 4. 캔버스: 절대 위치로 중앙 배치 */
            #canvas {
                position: absolute !important;
                left: 50% !important;
                top: 50% !important;
                transform-origin: center center !important; /* 축소 기준을 중앙으로 */
                /* transform 값은 JS에서 동적으로 설정됨 (translate -50%, -50% 포함) */
                border: none !important;
                box-shadow: none !important;
                margin: 0 !important; /* 마진 초기화 */
            }

            /* 5. 편집 도구 숨김 & 조작 방지 */
            .btn-delete-item, .rotate-handle, .ui-resizable-handle { display: none !important; }
            .design-item { cursor: default !important; box-shadow: 1px 1px 3px rgba(0,0,0,0.1) !important; }
            .design-item.selected { border: 1px solid #ccc !important; box-shadow: 1px 1px 3px rgba(0,0,0,0.1) !important; }
            .item-header { background-color: #ecf0f1 !important; cursor: default !important; }
        <?php endif; ?>
    </style>
</head>
<body>

    <header>
        <div style="display:flex; align-items:center;">
            <i class="fa-solid fa-industry" style="margin-right:10px; font-size:20px;"></i>
            <h1>공장 장비 레이아웃 (Layout Designer)</h1>
        </div>
        <div class="toolbar-group">
            <button class="toolbar-btn btn-undo" onclick="undo()"><i class="fa-solid fa-rotate-left"></i> 실행취소</button>
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
                <div id="prop-empty" class="no-selection"><i class="fa-regular fa-hand-pointer" style="font-size:30px; margin-bottom:10px;"></i><br>아이템을 선택하세요.</div>
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
        var isViewMode = <?php echo $is_view_mode ? 'true' : 'false'; ?>;
        var historyStack = [];
        var MAX_HISTORY = 30;

        // --- (기존 함수들 생략 없이 그대로 사용) ---
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
            if (n.includes("소화기")) return "fa-fire-extinguisher";
            if (n.includes("소화전")) return "fa-faucet";
            if (n.includes("배전함") || n.includes("DIST")) return "fa-bolt";
            if (n.includes("TEST") || n.includes("테스트")) return "fa-flask";
            if (n.includes("ROBOT")) return "fa-robot";
            if (n.includes("LINE")) return "fa-minus";
            if (n.includes("DOOR")) return "fa-door-open";
            return "fa-cube"; 
        }

        function loadPaletteList() {
            if (isViewMode) return; 
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

        if (!isViewMode) {
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
        }

        if (!isViewMode) {
            $("#prop-form input, #prop-form textarea, #prop-form select").on("focus", function() { saveHistory(); });
            $("#p-name").on("input", function() { if($currentEl) { var val=$(this).val(); $currentEl.find("span").text(val); $currentEl.find("i").attr("class", "fa-solid "+getIconClass(val)); } });
            $("#p-x").on("input", function() { if($currentEl) $currentEl.css("left", $(this).val() + "px"); });
            $("#p-y").on("input", function() { if($currentEl) $currentEl.css("top", $(this).val() + "px"); });
            $("#p-w").on("input", function() { if($currentEl) $currentEl.css("width", $(this).val() + "px"); });
            $("#p-h").on("input", function() { if($currentEl) $currentEl.css("height", $(this).val() + "px"); });
            $("#p-r").on("input", function() { if($currentEl) { var deg=$(this).val(); $currentEl.css("transform", `rotate(${deg}deg)`); $currentEl.data("rotation", deg); } });
            $("#p-desc").on("input", function() { if($currentEl) $currentEl.data("desc", $(this).val()); });
            $("#p-status").on("change", function() { if($currentEl) $currentEl.data("status", $(this).val()); });
        }

        var $currentEl = null;
        function updatePropPanel($el) {
            if (isViewMode) return;
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

            if (!isViewMode) {
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

                var dragHandle = isShape ? null : ".item-header, .item-content";
                $item.draggable({
                    containment: "#canvas", handle: dragHandle, 
                    start: function() { saveHistory(); $(this).addClass("selected"); updatePropPanel($(this)); },
                    drag: function(event, ui) { $("#p-x").val(ui.position.left); $("#p-y").val(ui.position.top); },
                    stop: function() { }
                });

                $item.resizable({
                    containment: "#canvas", handles: resizeHandles, minWidth: 20, minHeight: 20,
                    start: function() { saveHistory(); },
                    resize: function(event, ui) { $("#p-w").val(ui.size.width); $("#p-h").val(ui.size.height); }
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
            }
        };

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

        window.loadLayout = function() { if(!isViewMode && confirm("불러오시겠습니까?")) initialLoad(); else if(isViewMode) initialLoad(); };

        function initialLoad() {
            $.ajax({
                url: 'layout_view_status.php', type: 'POST', data: { mode: 'LOAD' }, dataType: 'json',
                success: function(res) {
                    if(res.status === 'success') {
                        $("#canvas").empty(); 
                        if (res.data && res.data.length > 0) {
                            res.data.forEach(function(item) {
                                var displayName = item.EQUIP_NAME && item.EQUIP_NAME !== "" ? item.EQUIP_NAME : item.EQUIP_ID;
                                createDesignItem(item.EQUIP_ID, displayName, parseInt(item.POS_X), parseInt(item.POS_Y), parseInt(item.WIDTH), parseInt(item.HEIGHT), parseInt(item.Z_INDEX), parseInt(item.ROTATION), item.DESCRIPTION, item.STATUS);
                            });
                            
                            // [뷰 모드일 때 자동 줌 적용]
                            if (isViewMode) {
                                setTimeout(zoomToFit, 100); 
                            }
                        }
                    }
                }
            });
        }

        // [핵심] 뷰 모드 줌 기능 (중앙 정렬 + 자동 축소)
        function zoomToFit() {
            var $wrapper = $("#canvas-wrapper");
            var $canvas = $("#canvas");
            var padding = 30; // 여백 조금 더 넉넉하게

            // 1. 배치된 아이템 중 가장 오른쪽/아래쪽 좌표 계산
            var maxX = 0;
            var maxY = 0;

            $(".design-item").each(function() {
                var l = parseInt($(this).css('left')) || 0;
                var t = parseInt($(this).css('top')) || 0;
                var w = $(this).outerWidth();
                var h = $(this).outerHeight();
                
                if ((l + w) > maxX) maxX = l + w;
                if ((t + h) > maxY) maxY = t + h;
            });

            // 데이터가 없으면 기본값
            if (maxX === 0) maxX = 800;
            if (maxY === 0) maxY = 600;

            var contentW = maxX + padding;
            var contentH = maxY + padding;

            // 2. 컨테이너(화면) 크기
            var containerW = $wrapper.width();
            var containerH = $wrapper.height();

            // 3. 배율 계산
            var scaleX = containerW / contentW;
            var scaleY = containerH / contentH;
            var scale = Math.min(scaleX, scaleY);

            // 확대 제한 (선택)
            if (scale > 1) scale = 1;

            // 4. Transform 적용 (정중앙 배치)
            $canvas.css({
                'width': contentW + 'px', 
                'height': contentH + 'px',
                'transform': `translate(-50%, -50%) scale(${scale})`,
                'background-size': (20/scale) + 'px ' + (20/scale) + 'px'
            });
        }

        initialLoad(); 
    });
    </script>
</body>
</html>