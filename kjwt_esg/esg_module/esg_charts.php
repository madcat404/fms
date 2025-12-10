<script>  
        const thisYearOilCO2Data = <?php echo json_encode($thisYearOilCO2Data); ?>;
        const oneYearAgoOilCO2Data = <?php echo json_encode($oneYearAgoOilCO2Data); ?>;
        const twoYearsAgoOilCO2Data = <?php echo json_encode($twoYearsAgoOilCO2Data); ?>;
        const threeYearsAgoOilCO2Data = <?php echo json_encode($threeYearsAgoOilCO2Data); ?>;
        const targetOilCO2Data = <?php echo json_encode($targetOilCO2Data); ?>;

        //합계★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas5 = $('#barChart5').get(0).getContext('2d')

            var barChartData5 = {
                labels  : ['합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
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
                        // 👇 데이터 삽입
                        data                : <?php echo json_encode($totalCO2Data_ThisYear); ?>
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
                        // 👇 데이터 삽입
                        data                : <?php echo json_encode($totalCO2Data_LastYear); ?>
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
                        // 👇 데이터 삽입
                        data                : <?php echo json_encode($totalCO2Data_TwoYearsAgo); ?>
                    },
                    {
                        label               : '<?php echo $Minus3YY?>년',
                        backgroundColor     : 'rgba(155, 162, 173, 1)',
                        borderColor         : 'rgba(155, 162, 173, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(155, 162, 173, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',           
                        // 👇 데이터 삽입
                        data                : <?php echo json_encode($totalCO2Data_ThreeYearsAgo); ?>
                    },
                    {
                        label               : '<?php echo $YY; ?>년 목표 (전년대비 3%절감)',
                        type                : 'line', // 선형 그래프로 표시
                        borderColor         : 'rgba(255, 99, 132, 1)', // 선 색상
                        borderWidth         : 2, // 선 두께
                        fill                : false, // 배경 채우기 없음
                        // 👇 데이터 삽입
                        data                : <?php echo json_encode($totalCO2Data_Target); ?>
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
                    legend: {
                        labels: {      
                            usePointStyle: true,              
                            generateLabels: function (chart) {
                                console.log(chart)                      

                                // 기본 범례 라벨 생성
                                let labels = Chart.defaults.plugins.legend.labels.generateLabels(chart);

                                // 라인 차트를 마지막으로 정렬
                                labels.sort((a, b) => {
                                    const isALine = chart.data.datasets[a.datasetIndex].type === 'line';
                                    const isBLine = chart.data.datasets[b.datasetIndex].type === 'line';
                                    return isALine - isBLine;
                                });

                                // 정렬된 라벨 배열 반환
                                return labels.map(label => ({
                                    ...label,
                                    pointStyle: chart.data.datasets[label.datasetIndex].type === 'line' ? 'line' : 'rect'
                                }));
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 4 } ).format(context.parsed.y);
                                }
                                label += ' tCO2';
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

        //이동연소★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas1 = $('#barChart1').get(0).getContext('2d')

            var barChartData1 = {
                labels  : ['합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                    {
                        label               : '<?php echo $YY?>년',
                        backgroundColor     : 'rgba(75,112,221, 1)',
                        borderColor         : 'rgba(75,112,221, 1)',
                        pointRadius         : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(75,112,221, 1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(75,112,221, 1)',
                        data                : thisYearOilCO2Data
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
                        data                : oneYearAgoOilCO2Data
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
                        data                : twoYearsAgoOilCO2Data
                    },
                    {
                        label               : '<?php echo $Minus3YY?>년',
                        backgroundColor     : 'rgb(155, 162, 173, 1)',
                        borderColor         : 'rgb(155, 162, 173, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(155, 162, 173, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',          
                        data                : threeYearsAgoOilCO2Data
                    },
                    {
                        label               : '<?php echo $YY; ?>년 목표 (전년대비 3%절감)',
                        type                : 'line', // 선형 그래프로 표시
                        borderColor         : 'rgba(255, 99, 132, 1)', // 선 색상
                        borderWidth         : 2, // 선 두께
                        fill                : false, // 배경 채우기 없음
                        data                : targetOilCO2Data
                    }
                ]
            }

            barChartData1.datasets.reverse();   

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    legend: {
                        labels: {      
                            usePointStyle: true,              
                            generateLabels: function (chart) {
                                console.log(chart)                      

                                // 기본 범례 라벨 생성
                                let labels = Chart.defaults.plugins.legend.labels.generateLabels(chart);

                                // 라인 차트를 마지막으로 정렬
                                labels.sort((a, b) => {
                                    const isALine = chart.data.datasets[a.datasetIndex].type === 'line';
                                    const isBLine = chart.data.datasets[b.datasetIndex].type === 'line';
                                    return isALine - isBLine;
                                });

                                // 정렬된 라벨 배열 반환
                                return labels.map(label => ({
                                    ...label,
                                    pointStyle: chart.data.datasets[label.datasetIndex].type === 'line' ? 'line' : 'rect'
                                }));
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 4 } ).format(context.parsed.y);
                                }
                                label += ' tCO2';
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

            new Chart(barChartCanvas1, {
                type: 'bar',
                data: barChartData1,
                options: barChartOptions
            }) 
        })

        //가스★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas2 = $('#barChart2').get(0).getContext('2d')

            var barChartData2 = {
                labels  : ['합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                    {
                        label               : '<?php echo $currentYear?>년',
                        backgroundColor     : 'rgba(232,85,70,1)',
                        borderColor         : 'rgba(232,85,70,1)',
                        pointRadius          : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(232,85,70,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(232,85,70,1)',
                        data                : [<?php echo $thisYearGasCO2Sum; ?>, <?php echo implode(', ', $thisYearGasCO2); ?>]
                    },
                    {
                        label               : '<?php echo $previousYear?>년',
                        backgroundColor     : 'rgba(210, 214, 222, 1)',
                        borderColor         : 'rgba(210, 214, 222, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(210, 214, 222, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data                : [<?php echo $lastYearGasCO2Sum; ?>, <?php echo implode(', ', $lastYearGasCO2); ?>]
                    },
                    {
                        label               : '<?php echo $twoYearsAgo?>년',
                        backgroundColor     : 'rgba(175, 183, 197, 1)',
                        borderColor         : 'rgba(175, 183, 197, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(175, 183, 197, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',          
                        data                : [<?php echo $twoYearsAgoGasCO2Sum; ?>, <?php echo implode(', ', $twoYearsAgoGasCO2); ?>]
                    },
                    {
                        label               : '<?php echo $threeYearsAgo?>년',
                        backgroundColor     : 'rgba(155, 162, 173, 1)',
                        borderColor         : 'rgba(155, 162, 173, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(155, 162, 173, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',          
                        data                : [<?php echo $threeYearsAgoGasCO2Sum; ?>, <?php echo implode(', ', $threeYearsAgoGasCO2); ?>]
                    },
                    {
                        label               : '<?php echo $currentYear; ?>년 목표 (전년대비 3%절감)',
                        type                : 'line', // 선형 그래프로 표시
                        borderColor         : 'rgba(255, 99, 132, 1)', // 선 색상
                        borderWidth         : 2, // 선 두께
                        fill                : false, // 배경 채우기 없음
                        data                : [<?php echo implode(', ', $lastYearGasCO2Goal); ?>]
                    }
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
                    legend: {
                        labels: {      
                            usePointStyle: true,              
                            generateLabels: function (chart) {
                                console.log(chart)                      

                                // 기본 범례 라벨 생성
                                let labels = Chart.defaults.plugins.legend.labels.generateLabels(chart);

                                // 라인 차트를 마지막으로 정렬
                                labels.sort((a, b) => {
                                    const isALine = chart.data.datasets[a.datasetIndex].type === 'line';
                                    const isBLine = chart.data.datasets[b.datasetIndex].type === 'line';
                                    return isALine - isBLine;
                                });

                                // 정렬된 라벨 배열 반환
                                return labels.map(label => ({
                                    ...label,
                                    pointStyle: chart.data.datasets[label.datasetIndex].type === 'line' ? 'line' : 'rect'
                                }));
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 4 } ).format(context.parsed.y);
                                }
                                label += ' tCO2';
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

            new Chart(barChartCanvas2, {
            type: 'bar',
            data: barChartData2,
            options: barChartOptions
            }) 
        })

        //전기★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas4 = $('#barChart4').get(0).getContext('2d')

            var barChartData4 = {
                labels  : ['합계','1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                    {
                        label               : '<?php echo $currentYear?>년',
                        backgroundColor     : 'rgba(236,194,76,1)',
                        borderColor         : 'rgba(236,194,76,1)',
                        pointRadius         : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(236,194,76,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(236,194,76,1)',
                        data                : [<?php echo $thisYearElectricityCO2Sum; ?>, <?php echo implode(', ', $thisYearElectricityCO2); ?>]
                    },
                    {
                        label               : '<?php echo $previousYear?>년',
                        backgroundColor     : 'rgba(210, 214, 222, 1)',
                        borderColor         : 'rgba(210, 214, 222, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(210, 214, 222, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',          
                        data                : [<?php echo $lastYearElectricityCO2Sum; ?>, <?php echo implode(', ', $lastYearElectricityCO2); ?>]
                    },
                    {
                    label               : '<?php echo $twoYearsAgo?>년',
                    backgroundColor     : 'rgba(175, 183, 197, 1)',
                    borderColor         : 'rgba(175, 183, 197, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(175, 183, 197, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : [<?php echo $twoYearsAgoElectricityCO2Sum; ?>, <?php echo implode(', ', $twoYearsAgoElectricityCO2); ?>]
                    },
                    {
                    label               : '<?php echo $threeYearsAgo?>년',
                    backgroundColor     : 'rgba(155, 162, 173, 1)',
                    borderColor         : 'rgba(155, 162, 173, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(155, 162, 173, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : [<?php echo $threeYearsAgoElectricityCO2Sum; ?>, <?php echo implode(', ', $threeYearsAgoElectricityCO2); ?>]
                    },
                    {
                        label           : '<?php echo $currentYear?>년 목표 (전년대비 3%절감)',
                        type            : 'line', // 선형 그래프로 표시
                        borderColor     : 'rgba(255, 99, 132, 1)', // 선 색상
                        borderWidth     : 2, // 선 두께
                        fill            : false, // 배경 채우기 없음
                        data            : [<?php echo implode(', ', $lastYearElectricityCO2Goal); ?>]
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
                    legend: {
                        labels: {      
                            usePointStyle: true,              
                            generateLabels: function (chart) {
                                console.log(chart)                      

                                // 기본 범례 라벨 생성
                                let labels = Chart.defaults.plugins.legend.labels.generateLabels(chart);

                                // 라인 차트를 마지막으로 정렬
                                labels.sort((a, b) => {
                                    const isALine = chart.data.datasets[a.datasetIndex].type === 'line';
                                    const isBLine = chart.data.datasets[b.datasetIndex].type === 'line';
                                    return isALine - isBLine;
                                });

                                // 정렬된 라벨 배열 반환
                                return labels.map(label => ({
                                    ...label,
                                    pointStyle: chart.data.datasets[label.datasetIndex].type === 'line' ? 'line' : 'rect'
                                }));
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 4 } ).format(context.parsed.y);
                                }
                                label += ' tCO2';
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

            new Chart(barChartCanvas4, {
                type: 'bar',
                data: barChartData4,
                options: barChartOptions
            }) 
        })

        //폐기물★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas3 = $('#barChart3').get(0).getContext('2d');

            var barChartData3 = {
                labels  : ['합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                    {
                        label               : '<?php echo $currentYear?>년',
                        backgroundColor     : 'rgba(40, 192, 141, 1)',
                        borderColor         : 'rgba(40, 192, 141, 1)',
                        data                : [<?php echo $thisYearTrashCO2Sum; ?>, <?php echo implode(', ', $thisYearTrashCO2); ?>]
                    },
                    {
                        label               : '<?php echo $previousYear?>년',
                        backgroundColor     : 'rgba(210, 214, 222, 1)',
                        borderColor         : 'rgba(210, 214, 222, 1)',
                        data                : [<?php echo $lastYearTrashCO2Sum; ?>, <?php echo implode(', ', $lastYearTrashCO2); ?>]
                    },
                    {
                        label               : '<?php echo $twoYearsAgo?>년',
                        backgroundColor     : 'rgba(175, 183, 197, 1)',
                        borderColor         : 'rgba(175, 183, 197, 1)',
                        data                : [<?php echo $twoYearsAgoTrashCO2Sum; ?>, <?php echo implode(', ', $twoYearsAgoTrashCO2); ?>]
                    },
                    {
                        label               : '<?php echo $threeYearsAgo?>년',
                        backgroundColor     : 'rgba(155, 162, 173, 1)',
                        borderColor         : 'rgba(155, 162, 173, 1)',
                        data                : [<?php echo $threeYearsAgoTrashCO2Sum; ?>, <?php echo implode(', ', $threeYearsAgoTrashCO2); ?>]
                    },
                    {
                        label               : '<?php echo $currentYear; ?>년 목표 (전년대비 3%절감)',
                        type                : 'line',
                        borderColor         : 'rgba(255, 99, 132, 1)',
                        borderWidth         : 2,
                        fill                : false,
                        data                : [<?php echo implode(', ', $lastYearTrashCO2Goal); ?>]
                    }
                ]
            };
            
            barChartData3.datasets.reverse();

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                animation: {
                    duration: 0
                },
                plugins: {
                    legend: {
                        labels: {      
                            usePointStyle: true,              
                            generateLabels: function (chart) {
                                let labels = Chart.defaults.plugins.legend.labels.generateLabels(chart);
                                labels.sort((a, b) => {
                                    const isALine = chart.data.datasets[a.datasetIndex].type === 'line';
                                    const isBLine = chart.data.datasets[b.datasetIndex].type === 'line';
                                    return isALine - isBLine;
                                });
                                return labels.map(label => ({
                                    ...label,
                                    pointStyle: chart.data.datasets[label.datasetIndex].type === 'line' ? 'line' : 'rect'
                                }));
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 4 } ).format(context.parsed.y);
                                }
                                label += ' tCO2';
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
            };

            new Chart(barChartCanvas3, {
                type: 'bar',
                data: barChartData3,
                options: barChartOptions
            }); 
        })    
    </script>