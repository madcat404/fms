<!-- 
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>	
    // Create date: <21.10.25>
    // Description:	<플러그>	
    // =============================================
-->


<!-- ################################## CDN ################################## -->


<!-- jQuery (필수) -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>





<!-- jQuery Easing (선택적) -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Bootstrap 4.6.2 Bundle (includes Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

<!-- sb-admin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/js/sb-admin-2.min.js" integrity="sha512-+QnjQxxaOpoJ+AAeNgvVatHiUWEDbvHja9l46BHhmzvP0blLTXC4LsvwDVeNhGgqqGQYBQLFhdKFyjzPX6HGmw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Page level plugins Chart.js  -->
<!--<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<!-- DataTables  & Plugins -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js" integrity="sha512-OQlawZneA7zzfI6B1n1tjUuo3C5mtYuAWpQdg+iI9mkDoo7iFzTqnQHf+K5ThOWNJ9AbXL4+ZDwH7ykySPQc+A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" integrity="sha512-XMVd28F1oH/O71fzwBnV7HucLxVwtxf26XV8P4wPk26EDxuGZ91N8bsOttmnomcCD3CS5ZMRL50H0GgOHvegtg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

<!-- Page specific script -->
<script>
$(function () {
    $("#table1").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false, "order": [0, 'desc'],
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table1_wrapper .col-md-6:eq(0)');        
    $('#table2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true,
    });
    $("#table3").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false, "order": [0, 'asc'],
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table3_wrapper .col-md-6:eq(0)');        
    $("#table4").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table4_wrapper .col-md-6:eq(0)'); 
    $("#table5").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table5_wrapper .col-md-6:eq(0)'); 
    $("#table6").DataTable({
    "responsive": false, "lengthChange": false, "autoWidth": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table6_wrapper .col-md-6:eq(0)');   
    $("#table7").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table7_wrapper .col-md-6:eq(0)');      
    $("#table_spread").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false, "paging": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table_spread_wrapper .col-md-6:eq(0)'); 
    $("#table_spread2").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false, "paging": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table_spread2_wrapper .col-md-6:eq(0)'); 
    $("#table_ht").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false, "order": [0, 'desc'],
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table_ht_wrapper .col-md-6:eq(0)');  
    $("#table_sign").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false, "order": [0, 'desc'],
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table_test_room_process_wrapper .col-md-6:eq(0)'); 
    $("#table_test_room_process").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false, "pageLength": 20,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table_test_room_process_wrapper .col-md-6:eq(0)'); 
    $("#table_nosort").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false, "ordering": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table_nosort_wrapper .col-md-6:eq(0)'); 
    $("#table_nosort2").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false, "ordering": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table_nosort2_wrapper .col-md-6:eq(0)'); 
    $("#table_nosort3").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false, "ordering": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table_nosort3_wrapper .col-md-6:eq(0)'); 
    $("#table_modal").DataTable({
    "paging": false,
    "lengthChange": false,
    "searching": false,
    "info": false,
    "ordering": false,
    "autoWidth": false,
    "responsive": true,
    });           
});
</script>

<!-- date-range-picker 달력 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha512-i2CVnAiguN6SnJ3d2ChOOddMWQyvgQTzm0qSgiKhOqBMGCx4fGU5BtzXEybnKatWPDkXPFyCI0lbG42BnVjr/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/4.0.9/jquery.inputmask.bundle.min.js" integrity="sha512-VpQwrlvKqJHKtIvpL8Zv6819FkTJyE1DOGy9gzC6bOyak3KQODisCW/Ycd9d3P7Gunhxzn+CM3VB3vO+VKblUQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha512-rBi1cGvEdd3NmB27p2nGWQmhNG9OtP0RySGkR3UJZiMB6XvLVGab0/UCw4s9Wd7jvXB7VC+UxgMpVUny5OUVqw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script>
    $(function () {      
        //time range
        $('#time1').daterangepicker({
            timePicker: true,
            autoUpdateInput: false,
            locale: {
                format: 'HH:mm',  
                'applyLabel': '확인',
                'cancelLabel': '취소'                  
            }
        }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find(".calendar-table").hide();
        }).on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('HH:mm')+ ' - '+picker.endDate.format('HH:mm'));
        })
        //time range
        $('#time2').daterangepicker({
            timePicker: true,
            autoUpdateInput: false,
            locale: {
                format: 'HH:mm',  
                'applyLabel': '확인',
                'cancelLabel': '취소'                  
            }
        }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find(".calendar-table").hide();
        }).on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('HH:mm')+ ' - '+picker.endDate.format('HH:mm'));
        })
        //time range
        $('#time3').daterangepicker({
            timePicker: true,
            autoUpdateInput: false,
            locale: {
                format: 'HH:mm',  
                'applyLabel': '확인',
                'cancelLabel': '취소'                  
            }
        }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find(".calendar-table").hide();
        }).on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('HH:mm')+ ' - '+picker.endDate.format('HH:mm'));
        })
        //time range
        $('#time4').daterangepicker({
            timePicker: true,
            autoUpdateInput: false,
            locale: {
                format: 'HH:mm',  
                'applyLabel': '확인',
                'cancelLabel': '취소'                  
            }
        }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find(".calendar-table").hide();
        }).on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('HH:mm')+ ' - '+picker.endDate.format('HH:mm'));
        })
        //time range
        $('#time5').daterangepicker({
            timePicker: true,
            autoUpdateInput: false,
            locale: {
                format: 'HH:mm',  
                'applyLabel': '확인',
                'cancelLabel': '취소'                  
            }
        }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find(".calendar-table").hide();
        }).on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('HH:mm')+ ' - '+picker.endDate.format('HH:mm'));
        })
        //time range
        $('#time6').daterangepicker({
            timePicker: true,
            autoUpdateInput: false,
            locale: {
                format: 'HH:mm',  
                'applyLabel': '확인',
                'cancelLabel': '취소'                  
            }
        }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find(".calendar-table").hide();
        }).on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('HH:mm')+ ' - '+picker.endDate.format('HH:mm'));
        })
        //time range
        $('#time7').daterangepicker({
            timePicker: true,
            autoUpdateInput: false,
            locale: {
                format: 'HH:mm',  
                'applyLabel': '확인',
                'cancelLabel': '취소'                  
            }
        }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find(".calendar-table").hide();
        }).on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('HH:mm')+ ' - '+picker.endDate.format('HH:mm'));
        })
        //time range
        $('#time41').daterangepicker({
            timePicker: true,
            autoUpdateInput: false,
            locale: {
                format: 'HH:mm',  
                'applyLabel': '확인',
                'cancelLabel': '취소'                  
            }
        }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find(".calendar-table").hide();
        }).on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('HH:mm')+ ' - '+picker.endDate.format('HH:mm'));
        })

        //Datemask dd/mm/yyyy, ecu 수기입력의 로트날짜에 필요함
        $('[data-mask]').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' })      
        
        //Datemask dd/mm/yyyy, ecu 수기입력의 로트날짜에 필요함
        $('[data-mask2]').inputmask('yyyy-mm', { 'placeholder': 'yyyy-mm' })  
    })
</script>

<script>
    // DateRangePicker 클래스 정의
    class KJWTDateRangePicker {
        constructor() {
            this.defaultOptions = {
                locale: {
                    format: 'YYYY-MM-DD',
                    separator: ' ~ ',
                    applyLabel: '확인',
                    cancelLabel: '취소',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    weekLabel: 'W',
                    daysOfWeek: ['일', '월', '화', '수', '목', '금', '토'],
                    monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월']
                }
            };

            this.searchOptions = {
                ...this.defaultOptions,
                autoUpdateInput: true,
                opens: 'right',
                showDropdowns: true,
                ranges: {
                    '오늘': [moment(), moment()],
                    '어제': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '지난 7일': [moment().subtract(6, 'days'), moment()],
                    '지난 30일': [moment().subtract(29, 'days'), moment()],
                    '이번 달': [moment().startOf('month'), moment().endOf('month')],
                    '지난 달': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            };

            this.timePickerOptions = {
                timePicker: true,
                autoUpdateInput: false,
                locale: {
                    format: 'HH:mm',
                    applyLabel: '확인',
                    cancelLabel: '취소'
                }
            };
        }

        // 검색용 날짜 선택기 초기화
        initSearchDatePicker(elementId) {
            const $element = $(elementId);
            const currentValue = $element.val();
            
            // 기존 값이 있으면 그 값을 사용하고, 없으면 오늘 날짜를 사용
            let startDate, endDate;
            if (currentValue) {
                const dates = currentValue.split(' ~ ');
                startDate = moment(dates[0]);
                endDate = moment(dates[1]);
            } else {
                startDate = moment();
                endDate = moment();
            }

            $element.daterangepicker({
                ...this.searchOptions,
                startDate: startDate,
                endDate: endDate
            }).on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' ~ ' + picker.endDate.format('YYYY-MM-DD'));
            });
        }

        // 시간 선택기 초기화
        initTimePicker(elementId) {
            $(elementId).daterangepicker(this.timePickerOptions)
                .on('show.daterangepicker', function(ev, picker) {
                    picker.container.find(".calendar-table").hide();
                })
                .on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('HH:mm') + ' - ' + picker.endDate.format('HH:mm'));
                });
        }

        // 모든 날짜 선택기 초기화
        initAllDatePickers() {
            // 검색용 날짜 선택기
            $('.kjwt-search-date').daterangepicker({
                "locale": {
                    "format": "YYYY-MM-DD",      // 날짜 형식
                    "separator": " ~ ",            // 날짜 구분자
                    "applyLabel": "확인",          // 적용 버튼 텍스트
                    "cancelLabel": "취소",         // 취소 버튼 텍스트
                    "fromLabel": "From",
                    "toLabel": "To",
                    "customRangeLabel": "사용자 지정", // Custom Range 텍스트
                    "weekLabel": "W",
                    "daysOfWeek": ["일", "월", "화", "수", "목", "금", "토"],
                    "monthNames": ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
                    "firstDay": 0                   // 일요일부터 시작
                },
                "ranges": {
                    '오늘': [moment(), moment()],
                    '어제': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '지난 7일': [moment().subtract(6, 'days'), moment()],
                    '지난 30일': [moment().subtract(29, 'days'), moment()],
                    '이번 달': [moment().startOf('month'), moment().endOf('month')],
                    '지난 달': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "showDropdowns": true,    // 년/월 선택 드롭다운 활성화 (빠른 이동)
                "linkedCalendars": false, // 두 달력을 독립적으로 표시 (긴 기간 선택 시 편리)
                "autoUpdateInput": true,  // 날짜 선택 시 자동으로 input 값 갱신
                // "maxSpan": { "days": 30 } // 이 옵션이 있다면 반드시 삭제하거나 주석 처리해야 1개월 제한이 풀립니다.
            });
        }

        // 모든 시간 선택기 초기화
        initAllTimePickers() {
            const timePickerIds = ['#time1', '#time2', '#time3', '#time4', 
                                 '#time5', '#time6', '#time7', '#time41'];
            timePickerIds.forEach(id => this.initTimePicker(id));
        }
    }

    // 초기화
    $(function () {
        const dateRangePicker = new KJWTDateRangePicker();
        dateRangePicker.initAllDatePickers();
        dateRangePicker.initAllTimePickers();

        // Datemask 설정
        $('[data-mask]').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' });
        $('[data-mask2]').inputmask('yyyy-mm', { 'placeholder': 'yyyy-mm' });
    });
</script>

<!-- bs-custom-file-input -->
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input@1.3.4/dist/bs-custom-file-input.min.js" integrity="sha256-e0DUqNhsFAzOlhrWXnMOQwRoqrCRlofpWgyhnrIIaPo=" crossorigin="anonymous"></script>

<script>
    $(function () {
        bsCustomFileInput.init();
    });
</script>

<!-- Custom script to handle modal opening via data-attribute (CSP Compliant) -->
<script>
$(document).ready(function() {
    var modalId = $('body').data('show-modal');
    if (modalId) {
        $('#' + modalId).modal('show');
    }
});
</script>