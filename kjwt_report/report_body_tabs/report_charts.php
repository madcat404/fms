<script>
        //인원증감
        const thisYearOfficeData = <?php echo json_encode($thisYearOfficeChartData); ?>;
        const lastYearOfficeData = <?php echo json_encode($lastYearOfficeChartData); ?>;
        const yearBeforeOfficeData = <?php echo json_encode($yearBeforeOfficeChartData); ?>; 
        const thisYearContractData = <?php echo json_encode($thisYearContractChartData); ?>;        
        const lastYearContractData = <?php echo json_encode($lastYearContractChartData); ?>;
        const yearBeforeContractData = <?php echo json_encode($yearBeforeContractChartData); ?>; 
        //사용량
        const thisYearWaterIwinUsageData = <?php echo json_encode($thisYearWaterIwinUsageData); ?>;
        const lastYearWaterIwinUsageData = <?php echo json_encode($lastYearWaterIwinUsageData); ?>;
        const yearBeforeWaterIwinUsageData = <?php echo json_encode($yearBeforeWaterIwinUsageData); ?>;
        const thisYearGasUsageData = <?php echo json_encode($thisYearGasUsageData); ?>;
        const lastYearGasUsageData = <?php echo json_encode($lastYearGasUsageData); ?>;
        const yearBeforeGasUsageData = <?php echo json_encode($yearBeforeGasUsageData); ?>;
        const thisYearElectricityUsageData = <?php echo json_encode($thisYearElectricityUsageData); ?>;
        const lastYearElectricityUsageData = <?php echo json_encode($lastYearElectricityUsageData); ?>;
        const yearBeforeElectricityUsageData = <?php echo json_encode($yearBeforeElectricityUsageData); ?>;
        //비용
        const thisYearWaterChartData = <?php echo json_encode($thisYearWaterChartData); ?>;
        const lastYearWaterChartData = <?php echo json_encode($lastYearWaterChartData); ?>;
        const yearBeforeWaterChartData = <?php echo json_encode($yearBeforeWaterChartData); ?>;
        const thisYearGasChartData = <?php echo json_encode($thisYearGasChartData); ?>;
        const lastYearGasChartData = <?php echo json_encode($lastYearGasChartData); ?>;
        const yearBeforeGasChartData = <?php echo json_encode($yearBeforeGasChartData); ?>;
        const thisYearElecChartData = <?php echo json_encode($thisYearElecChartData); ?>;
        const lastYearElecChartData = <?php echo json_encode($lastYearElecChartData); ?>;
        const yearBeforeElecChartData = <?php echo json_encode($yearBeforeElecChartData); ?>;
        const thisYearPayChartData = <?php echo json_encode($thisYearPayChartData); ?>;
        const lastYearPayChartData = <?php echo json_encode($lastYearPayChartData); ?>;
        const yearBeforePayChartData = <?php echo json_encode($yearBeforePayChartData); ?>;
        const thisYearPay2ChartData = <?php echo json_encode($thisYearPay2ChartData); ?>;
        const lastYearPay2ChartData = <?php echo json_encode($lastYearPay2ChartData); ?>;
        const yearBeforePay2ChartData = <?php echo json_encode($yearBeforePay2ChartData); ?>;
        const thisYearDeliChartData = <?php echo json_encode($thisYearDeliChartData); ?>;
        const lastYearDeliChartData = <?php echo json_encode($lastYearDeliChartData); ?>;      
        //회계
        const financeDataCY   = <?php echo json_encode($financeDataCurrentYear  ?? []); ?>;
        const financeDataCY_1 = <?php echo json_encode($financeDataPreviousYear ?? []); ?>;
        const financeDataCY_2 = <?php echo json_encode($financeDataMinus2Year   ?? []); ?>;
        const financeDataCY_3 = <?php echo json_encode($financeDataMinus3Year   ?? []); ?>;
        //매출
        const salesDonutData = <?php echo json_encode($donutChartPercentages); ?>;
        const annualSalesLabels = <?php echo json_encode($lineChartLabels); ?>;
        const annualSalesData = <?php echo json_encode($lineChartValues); ?>;
        const heaterData        = <?php echo json_encode($chartData['heaterChartData']); ?>;
        const handleData        = <?php echo json_encode($chartData['handleChartData']); ?>;
        const iwonData          = <?php echo json_encode($chartData['iwonChartData']); ?>;
        const ventData          = <?php echo json_encode($chartData['ventChartData']); ?>;
        const integratedEcuData = <?php echo json_encode($chartData['integratedEcuChartData']); ?>;
        const generalEcuData    = <?php echo json_encode($chartData['generalEcuChartData']); ?>;
        const etcData           = <?php echo json_encode($chartData['etcChartData']); ?>;
    </script>    
    
    <script>
        //사무직 인원증감★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas44 = $('#barChart44').get(0).getContext('2d')

            var barChartData44 = {
            labels  : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(97,175,185,1)',
                    borderColor         : 'rgba(97,175,185,1)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(97,175,185,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(97,175,185,1)',
                    data                : thisYearOfficeData
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : lastYearOfficeData
                },
                {
                    label               : '<?php echo $Minus2YY?>년',
                    backgroundColor     : 'rgba(175, 183, 197, 1)',
                    borderColor         : 'rgba(175, 183, 197, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(175, 183, 197, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : yearBeforeOfficeData
                }
            ]
            }

            barChartData44.datasets.reverse();

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '명';
                                return label;
                            }
                        }
                    }
                }
            }

            new Chart(barChartCanvas44, {
                type: 'bar',
                data: barChartData44,
                options: barChartOptions
            }) 
        })

        //도급직 인원증감★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas4 = $('#barChart4').get(0).getContext('2d')

            var barChartData4 = {
            labels  : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(40,192,141,1)',
                    borderColor         : 'rgba(40,192,141,1)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(40,192,141,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(97,175,185,1)',
                    data                : thisYearContractData
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : lastYearContractData
                },
                {
                    label               : '<?php echo $Minus2YY?>년',
                    backgroundColor     : 'rgba(175, 183, 197, 1)',
                    borderColor         : 'rgba(175, 183, 197, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(175, 183, 197, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : yearBeforeContractData
                }
            ]
            }

            barChartData4.datasets.reverse();

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '명';
                                return label;
                            }
                        }
                    }
                }
            }

            new Chart(barChartCanvas4, {
                type: 'bar',
                data: barChartData4,
                options: barChartOptions
            }) 
        })

        //전기사용량★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas3 = $('#barChart3').get(0).getContext('2d')

            var barChartData3 = {
                labels  : ['년 합계', '월 누적 합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                    { label : '<?php echo $YY?>년', backgroundColor : 'rgba(236,194,76,1)', borderColor : 'rgba(236,194,76,1)', data : thisYearElectricityUsageData },
                    { label : '<?php echo $Minus1YY?>년', backgroundColor : 'rgba(210, 214, 222, 1)', borderColor : 'rgba(210, 214, 222, 1)', data : lastYearElectricityUsageData },
                    { label : '<?php echo $Minus2YY?>년', backgroundColor : 'rgba(175, 183, 197, 1)', borderColor : 'rgba(175, 183, 197, 1)', data : yearBeforeElectricityUsageData }
                ]
            }

            barChartData3.datasets.reverse();

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += 'KWH';
                                return label;
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end',      // 막대 끝을 기준으로
                        align: 'end',       // 막대 바깥쪽에 표시 (공간 없으면 조정됨)
                        rotation: -90,      // [핵심] 글자를 -90도(세로)로 회전
                        offset: 0,          // 막대와의 간격
                        formatter: function(value) {
                            if (isNaN(value) || value === 0) {
                                return '';
                            } else {
                                // 숫자가 너무 길면 반올림하거나 포맷팅
                                return new Intl.NumberFormat('en-US').format(Math.round(value));
                            }
                        },
                        color: '#444',
                        font: {
                            weight: 'bold',
                            size: 11 // 글자 크기를 조금 줄여서 가독성 확보
                        }
                    }
                },        
                scales: {
                    y: {
                        display: true,
                        type: 'logarithmic',
                    }
                }     
            }

            const logNumbers = (num) => {
                const data = [];

                for (let i = 0; i < num; ++i) {
                data.push(Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5)));
                }

                return data;
            };

            const actions = [
                {
                name: 'Randomize',
                handler(chart) {
                    chart.data.datasets.forEach(dataset => {
                    dataset.data = logNumbers(chart.data.labels.length);
                    });
                    chart.update();
                }
                },
            ];

            new Chart(barChartCanvas3, {
                type: 'bar',
                data: barChartData3,
                options: barChartOptions,
                plugins: [ChartDataLabels]  // 여기에서만 플러그인을 지정
            }) 
        })

        //가스사용량★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas2 = $('#barChart2').get(0).getContext('2d')

            var barChartData2 = {
                labels  : ['합계', '월 누적 합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                    { label : '<?php echo $YY?>년', backgroundColor : 'rgba(232,85,70,1)', borderColor : 'rgba(232,85,70,1)', data : thisYearGasUsageData },
                    { label : '<?php echo $Minus1YY?>년', backgroundColor : 'rgba(210, 214, 222, 1)', borderColor : 'rgba(210, 214, 222, 1)', data : lastYearGasUsageData },
                    { label : '<?php echo $Minus2YY?>년', backgroundColor : 'rgba(175, 183, 197, 1)', borderColor : 'rgba(175, 183, 197, 1)', data : yearBeforeGasUsageData }
                ]
            }

            barChartData2.datasets.reverse();

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '㎥';
                                return label;
                            }
                        }
                    },
                   datalabels: {
                        anchor: 'end',      // 막대 끝을 기준으로
                        align: 'end',       // 막대 바깥쪽에 표시 (공간 없으면 조정됨)
                        rotation: -90,      // [핵심] 글자를 -90도(세로)로 회전
                        offset: 0,          // 막대와의 간격
                        formatter: function(value) {
                            if (isNaN(value) || value === 0) {
                                return '';
                            } else {
                                // 숫자가 너무 길면 반올림하거나 포맷팅
                                return new Intl.NumberFormat('en-US').format(Math.round(value));
                            }
                        },
                        color: '#444',
                        font: {
                            weight: 'bold',
                            size: 11 // 글자 크기를 조금 줄여서 가독성 확보
                        }
                    }
                },        
                scales: {
                    y: {
                        display: true,
                        type: 'logarithmic',
                    }
                }
            }

            const logNumbers = (num) => {
                const data = [];

                for (let i = 0; i < num; ++i) {
                data.push(Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5)));
                }

                return data;
            };

            const actions = [
                {
                name: 'Randomize',
                handler(chart) {
                    chart.data.datasets.forEach(dataset => {
                    dataset.data = logNumbers(chart.data.labels.length);
                    });
                    chart.update();
                }
                },
            ];

            new Chart(barChartCanvas2, {
                type: 'bar',
                data: barChartData2,
                options: barChartOptions,
                plugins: [ChartDataLabels]  // 여기에서만 플러그인을 지정
            }) 
        })

        //수도사용량★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas = $('#barChart').get(0).getContext('2d')

            var barChartData = {
                labels  : ['년 합계', '월 누적 합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                    { label : '<?php echo $YY?>년', backgroundColor : 'rgba(75,112,221, 1)', borderColor : 'rgba(75,112,221, 1)', data : thisYearWaterIwinUsageData },
                    { label : '<?php echo $Minus1YY?>년', backgroundColor : 'rgba(210, 214, 222, 1)', borderColor : 'rgba(210, 214, 222, 1)', data : lastYearWaterIwinUsageData },
                    { label : '<?php echo $Minus2YY?>년', backgroundColor : 'rgba(175, 183, 197, 1)', borderColor : 'rgba(175, 183, 197, 1)', data : yearBeforeWaterIwinUsageData }
                ]
            }

            barChartData.datasets.reverse();

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '㎥';
                                return label;
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end',      // 막대 끝을 기준으로
                        align: 'end',       // 막대 바깥쪽에 표시 (공간 없으면 조정됨)
                        rotation: -90,      // [핵심] 글자를 -90도(세로)로 회전
                        offset: 0,          // 막대와의 간격
                        formatter: function(value) {
                            if (isNaN(value) || value === 0) {
                                return '';
                            } else {
                                // 숫자가 너무 길면 반올림하거나 포맷팅
                                return new Intl.NumberFormat('en-US').format(Math.round(value));
                            }
                        },
                        color: '#444',
                        font: {
                            weight: 'bold',
                            size: 11 // 글자 크기를 조금 줄여서 가독성 확보
                        }
                    }
                },        
                scales: {
                    y: {
                        display: true,
                        type: 'logarithmic',
                    }
                }
            }

            const logNumbers = (num) => {
                const data = [];

                for (let i = 0; i < num; ++i) {
                data.push(Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5)));
                }

                return data;
            };

            const actions = [
                {
                name: 'Randomize',
                handler(chart) {
                    chart.data.datasets.forEach(dataset => {
                    dataset.data = logNumbers(chart.data.labels.length);
                    });
                    chart.update();
                }
                },
            ];

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions,
                plugins: [ChartDataLabels]  // 여기에서만 플러그인을 지정
            }) 
        })
        
        //사무직 급여★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas55 = $('#barChart55').get(0).getContext('2d')

            var barChartData55 = {
                labels  : ['년 합계', '월 누적 합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(97,175,185,1)',
                    borderColor         : 'rgba(97,175,185,1)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(97,175,185,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(40,192,141,1)',
                    data                : thisYearPayChartData
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : lastYearPayChartData
                },
                {
                    label               : '<?php echo $Minus2YY?>년',
                    backgroundColor     : 'rgba(175, 183, 197, 1)',
                    borderColor         : 'rgba(175, 183, 197, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(175, 183, 197, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : yearBeforePayChartData
                }
            ]
            }

            barChartData55.datasets.reverse();

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        display: true,
                        type: 'logarithmic',
                    }
                }
            }

            const logNumbers = (num) => {
                const data = [];

                for (let i = 0; i < num; ++i) {
                data.push(Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5)));
                }

                return data;
            };

            const actions = [
                {
                name: 'Randomize',
                handler(chart) {
                    chart.data.datasets.forEach(dataset => {
                    dataset.data = logNumbers(chart.data.labels.length);
                    });
                    chart.update();
                }
                },
            ];

            new Chart(barChartCanvas55, {
                type: 'bar',
                data: barChartData55,
                options: barChartOptions
            }) 
        })

        //도급비★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas5 = $('#barChart5').get(0).getContext('2d')

            var barChartData5 = {
                labels  : ['년 합계', '월 누적 합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(40,192,141,1)',
                    borderColor         : 'rgba(40,192,141,1)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(40,192,141,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(40,192,141,1)',
                    data                : thisYearPay2ChartData
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : lastYearPay2ChartData
                },
                {
                    label               : '<?php echo $Minus2YY?>년',
                    backgroundColor     : 'rgba(175, 183, 197, 1)',
                    borderColor         : 'rgba(175, 183, 197, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(175, 183, 197, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : yearBeforePay2ChartData
                }
            ]
            }

            barChartData5.datasets.reverse();

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        display: true,
                        type: 'logarithmic',
                    }
                }
            }

            const logNumbers = (num) => {
                const data = [];

                for (let i = 0; i < num; ++i) {
                data.push(Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5)));
                }

                return data;
            };

            const actions = [
                {
                name: 'Randomize',
                handler(chart) {
                    chart.data.datasets.forEach(dataset => {
                    dataset.data = logNumbers(chart.data.labels.length);
                    });
                    chart.update();
                }
                },
            ];

            new Chart(barChartCanvas5, {
                type: 'bar',
                data: barChartData5,
                options: barChartOptions
            }) 
        })
        
        //전기비★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas33 = $('#barChart33').get(0).getContext('2d')

            var barChartData33 = {
                labels  : ['년 합계', '월 누적 합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                    { label : '<?php echo $YY?>년', backgroundColor : 'rgba(236,194,76,1)', borderColor : 'rgba(236,194,76,1)', data : thisYearElecChartData },
                    { label : '<?php echo $Minus1YY?>년', backgroundColor : 'rgba(210, 214, 222, 1)', borderColor : 'rgba(210, 214, 222, 1)', data : lastYearElecChartData },
                    { label : '<?php echo $Minus2YY?>년', backgroundColor : 'rgba(175, 183, 197, 1)', borderColor : 'rgba(175, 183, 197, 1)', data : yearBeforeElecChartData }
                ]
            }

            barChartData33.datasets.reverse();

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    title: {
                        display: true,
                        align: 'end',
                        position: 'top',
                        text: '[단위: 만원]'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end',      // 막대 끝을 기준으로
                        align: 'end',       // 막대 바깥쪽에 표시 (공간 없으면 조정됨)
                        rotation: -90,      // [핵심] 글자를 -90도(세로)로 회전
                        offset: 0,          // 막대와의 간격
                        formatter: function(value) {
                            if (isNaN(value) || value === 0) {
                                return '';
                            } else {
                                var valueInManWon = value / 10000;
                                return new Intl.NumberFormat('en-US').format(Math.round(valueInManWon));
                            }
                        },
                        color: '#444',
                        font: {
                            weight: 'bold',
                            size: 11 // 글자 크기를 조금 줄여서 가독성 확보
                        }
                    }
                },        
                scales: {
                    y: {
                        display: true,
                        type: 'logarithmic',
                    }
                }
            }

            const logNumbers = (num) => {
                const data = [];

                for (let i = 0; i < num; ++i) {
                data.push(Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5)));
                }

                return data;
            };

            const actions = [
                {
                name: 'Randomize',
                handler(chart) {
                    chart.data.datasets.forEach(dataset => {
                    dataset.data = logNumbers(chart.data.labels.length);
                    });
                    chart.update();
                }
                },
            ];

            new Chart(barChartCanvas33, {
                type: 'bar',
                data: barChartData33,
                options: barChartOptions,
                plugins: [ChartDataLabels]  // 여기에서만 플러그인을 지정
            }) 
        })

        //가스비★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas22 = $('#barChart22').get(0).getContext('2d')

            var barChartData22 = {
                labels  : ['년 합계', '월 누적 합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                    { label : '<?php echo $YY?>년', backgroundColor : 'rgba(232,85,70,1)', borderColor : 'rgba(232,85,70,1)', data : thisYearGasChartData },
                    { label : '<?php echo $Minus1YY?>년', backgroundColor : 'rgba(210, 214, 222, 1)', borderColor : 'rgba(210, 214, 222, 1)', data : lastYearGasChartData },
                    { label : '<?php echo $Minus2YY?>년', backgroundColor : 'rgba(175, 183, 197, 1)', borderColor : 'rgba(175, 183, 197, 1)', data : yearBeforeGasChartData }
                ]
            }

            barChartData22.datasets.reverse();

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        display: true,
                        type: 'logarithmic',
                    }
                }
            }

            const logNumbers = (num) => {
                const data = [];

                for (let i = 0; i < num; ++i) {
                data.push(Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5)));
                }

                return data;
            };

            const actions = [
                {
                name: 'Randomize',
                handler(chart) {
                    chart.data.datasets.forEach(dataset => {
                    dataset.data = logNumbers(chart.data.labels.length);
                    });
                    chart.update();
                }
                },
            ];

            new Chart(barChartCanvas22, {
                type: 'bar',
                data: barChartData22,
                options: barChartOptions
            }) 
        })

        //수도비★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas11 = $('#barChart11').get(0).getContext('2d')

            var barChartData11 = {
                labels  : ['년 합계', '월 누적 합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                    { label : '<?php echo $YY?>년', backgroundColor : 'rgba(75,112,221, 1)', borderColor : 'rgba(75,112,221, 1)', data : thisYearWaterChartData },
                    { label : '<?php echo $Minus1YY?>년', backgroundColor : 'rgba(210, 214, 222, 1)', borderColor : 'rgba(210, 214, 222, 1)', data : lastYearWaterChartData },
                    { label : '<?php echo $Minus2YY?>년', backgroundColor : 'rgba(175, 183, 197, 1)', borderColor : 'rgba(175, 183, 197, 1)', data : yearBeforeWaterChartData }
                ]
            }

            barChartData11.datasets.reverse();

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        display: true,
                        type: 'logarithmic',
                    }
                }
            }

            const logNumbers = (num) => {
                const data = [];

                for (let i = 0; i < num; ++i) {
                data.push(Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5)));
                }

                return data;
            };

            const actions = [
                {
                name: 'Randomize',
                handler(chart) {
                    chart.data.datasets.forEach(dataset => {
                    dataset.data = logNumbers(chart.data.labels.length);
                    });
                    chart.update();
                }
                },
            ];

            new Chart(barChartCanvas11, {
                type: 'bar',
                data: barChartData11,
                options: barChartOptions
            }) 
        })  

        //운반비★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas8 = $('#barChart8').get(0).getContext('2d')

            var barChartData8 = {
                labels  : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(40,192,141,1)',
                    borderColor         : 'rgba(40,192,141,1)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(40,192,141,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(40,192,141,1)',
                    data                : thisYearDeliChartData
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : lastYearDeliChartData
                }
            ]
            }

            barChartData8.datasets.reverse();

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            }
                        }
                    }
                }   
            }

            new Chart(barChartCanvas8, {
                type: 'bar',
                data: barChartData8,
                options: barChartOptions
            }) 
        })

        //재무제표★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas6 = $('#barChart6').get(0).getContext('2d')

            var barChartData6 = {
                labels  : ['매출액', '매출원가', '판매비와관리비', '영업외이익(손실)', '당기순이익(손실)'],
                datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(40,192,141,1)',
                    borderColor         : 'rgba(40,192,141,1)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(40,192,141,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(40,192,141,1)',
                    data                : financeDataCY
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : financeDataCY_1
                },
                {
                    label               : '<?php echo $Minus2YY?>년',
                    backgroundColor     : 'rgba(175, 183, 197, 1)',
                    borderColor         : 'rgba(175, 183, 197, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(175, 183, 197, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : financeDataCY_2
                },
                {
                    label               : '<?php echo $Minus3YY?>년',
                    backgroundColor     : 'rgba(147, 156, 176, 1)',
                    borderColor         : 'rgba(147, 156, 176, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(147, 156, 176, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : financeDataCY_3
                }
            ]
            }

            barChartData6.datasets.reverse();

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            }
                        }
                    }
                }
            }

            new Chart(barChartCanvas6, {
                type: 'bar',
                data: barChartData6,
                options: barChartOptions
            }) 
        })

        //매출 - 항목별(%)★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var donutChartCanvas = $('#donutChart').get(0).getContext('2d')

            var donutData = {
                labels  : ['히터', '발열핸들(열선)', '통풍(이원컴포텍)', '통풍', '통합ECU', '일반ECU', '기타'],
                datasets: [
                {          
                    data                : salesDonutData,
                    backgroundColor     : ['rgba(78,121,165, 1)', 
                                        'rgba(241,143,59, 1)', 
                                        'rgba(224,88,91, 1)', 
                                        'rgba(119,183,178, 1)', 
                                        'rgba(90,161,85, 1)', 
                                        'rgba(237,201,88, 1)', 
                                        'rgba(175,122,160, 1)']
                }
            ]
            }

            var donutOptions     = {
                maintainAspectRatio : false,
                responsive          : true,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed);
                                }
                                label += '%';
                                return label;
                            }
                        }
                    }
                }
            }

            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            }) 
        })

        //매출 - 년도별(원)★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var lineChartCanvas = $('#lineChart').get(0).getContext('2d')

            var lineChartData = {
                labels  : annualSalesLabels,
                datasets: [
                {
                    label               : '매출',
                    backgroundColor     : 'rgba(40,192,141,1)',
                    borderColor         : 'rgba(40,192,141,1)',
                    pointRadius         : 6,
                    pointStyle          : 'circle',
                    fill                : true,
                    lineTension         : 0,                      //0이면 선모양 직선
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(40,192,141,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(40,192,141,1)',
                    data                : annualSalesData
                }
            ]
            }
            
            var lineChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true   //0부터 시작
                    }
                }     
            }    

            lineChartData.datasets[0].fill = false
            lineChartOptions.datasetFill = false

            new Chart(lineChartCanvas, {
                type: 'line',
                data: lineChartData,
                options: lineChartOptions
            })
        })

        //매출 - 월 항목별 매출 추이(원)★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')

            var stackedBarChartData = {
                labels  : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                {
                    label               : '히터',
                    backgroundColor     : 'rgba(78,121,165, 1)',
                    borderColor         : 'rgba(78,121,165, 1)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : heaterData
                },
                {
                    label               : '발열핸들(열선)',
                    backgroundColor     : 'rgba(241,143,59, 1)',
                    borderColor         : 'rgba(241,143,59, 1)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : handleData
                },
                {
                    label               : '통풍(이원컴포텍)',
                    backgroundColor     : 'rgba(224,88,91, 1)',
                    borderColor         : 'rgba(224,88,91, 1)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : iwonData
                },
                {
                    label               : '통풍',
                    backgroundColor     : 'rgba(119,183,178, 1)',
                    borderColor         : 'rgba(119,183,178, 1)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : ventData
                },
                {
                    label               : '통합ECU',
                    backgroundColor     : 'rgba(90,161,85, 1)',
                    borderColor         : 'rgba(90,161,85, 1)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : integratedEcuData
                },
                {
                    label               : '일반ECU',
                    backgroundColor     : 'rgba(237,201,88, 1)',
                    borderColor         : 'rgba(237,201,88, 1)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : generalEcuData
                },
                {
                    label               : '기타',
                    backgroundColor     : 'rgba(175,122,160, 1)',
                    borderColor         : 'rgba(175,122,160, 1)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : etcData
                }
            ]
            }
            
            var stackedBarChartOptions = {
                responsive          : true,
                maintainAspectRatio : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {     
                        //툴팁 단위 원 표시  
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            },
                            //툴팁 합계 표시
                            footer: function(tooltipItems) {
                                let sum = 0;

                                tooltipItems.forEach(function(tooltipItem) {
                                    sum += tooltipItem.parsed.y;
                                });

                                return '합계: ' + Number(sum).toLocaleString() + '원';
                            }
                        },
                        //툴팁 모두 표시
                        mode: 'x'
                    }
                },
                scales: {
                x: {
                stacked: true,
                },
                y: {
                stacked: true
                }
            }
            }  

            new Chart(stackedBarChartCanvas, {
                type: 'bar',
                data: stackedBarChartData,
                options: stackedBarChartOptions
            })
        })
        
        //실패비용 ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas7 = $('#barChart7').get(0).getContext('2d')

            var barChartData7 = {
                labels  : ['합계', '시트히터', '발열핸들', '통풍시트'],
                datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(40,192,141,1)',
                    borderColor         : 'rgba(40,192,141,1)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(40,192,141,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(40,192,141,1)',
                    data                : <?php echo $currentYearJson; ?>
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : <?php echo $previousYearJson; ?>
                },
                {
                    label               : '<?php echo $Minus2YY?>년',
                    backgroundColor     : 'rgba(175, 183, 197, 1)',
                    borderColor         : 'rgba(175, 183, 197, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(175, 183, 197, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : <?php echo $yearBeforeJson; ?>
                }
                ]
            }

            barChartData7.datasets.reverse();

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        display: true,
                        type: 'logarithmic',
                    }
                }
            }

            const logNumbers = (num) => {
                const data = [];

                for (let i = 0; i < num; ++i) {
                data.push(Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5)));
                }

                return data;
            };

            const actions = [
                {
                name: 'Randomize',
                handler(chart) {
                    chart.data.datasets.forEach(dataset => {
                    dataset.data = logNumbers(chart.data.labels.length);
                    });
                    chart.update();
                }
                },
            ];

            new Chart(barChartCanvas7, {
                type: 'bar',
                data: barChartData7,
                options: barChartOptions
            }) 
        })

        //베트남 인원증감★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvasV1 = $('#barChartV1').get(0).getContext('2d')

            var barChartDataV1 = {
            labels  : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(97,175,185,1)',
                    borderColor         : 'rgba(97,175,185,1)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(97,175,185,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(97,175,185,1)',
                    data                : [<?php echo $thisYearVietnamTotals[1]; ?>, 
                                        <?php echo $thisYearVietnamTotals[2]; ?>, 
                                        <?php echo $thisYearVietnamTotals[3]; ?>, 
                                        <?php echo $thisYearVietnamTotals[4]; ?>, 
                                        <?php echo $thisYearVietnamTotals[5]; ?>, 
                                        <?php echo $thisYearVietnamTotals[6]; ?>, 
                                        <?php echo $thisYearVietnamTotals[7]; ?>, 
                                        <?php echo $thisYearVietnamTotals[8]; ?>, 
                                        <?php echo $thisYearVietnamTotals[9]; ?>, 
                                        <?php echo $thisYearVietnamTotals[10]; ?>, 
                                        <?php echo $thisYearVietnamTotals[11]; ?>,
                                        <?php echo $thisYearVietnamTotals[12]; ?>]
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : [<?php echo $lastYearVietnamTotals[1]; ?>, 
                                        <?php echo $lastYearVietnamTotals[2]; ?>, 
                                        <?php echo $lastYearVietnamTotals[3]; ?>, 
                                        <?php echo $lastYearVietnamTotals[4]; ?>, 
                                        <?php echo $lastYearVietnamTotals[5]; ?>, 
                                        <?php echo $lastYearVietnamTotals[6];; ?>, 
                                        <?php echo $lastYearVietnamTotals[7]; ?>, 
                                        <?php echo $lastYearVietnamTotals[8]; ?>, 
                                        <?php echo $lastYearVietnamTotals[9]; ?>, 
                                        <?php echo $lastYearVietnamTotals[10]; ?>, 
                                        <?php echo $lastYearVietnamTotals[11]; ?>,
                                        <?php echo $lastYearVietnamTotals[12]; ?>]
                }
            ]
            }

            barChartDataV1.datasets.reverse();

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '명';
                                return label;
                            }
                        }
                    }
                }
            }

            new Chart(barChartCanvasV1, {
                type: 'bar',
                data: barChartDataV1,
                options: barChartOptions
            }) 
        })
    </script>