@if($dataset)
    <div class="themed-block col-12 col-md-10 mx-auto mt-4 p-2">
        <h2 class="section-title">Rueda de la vida:</h2>

        <style>
            canvas{
                width:100% !important;
                height:450px !important;
            }
        </style>

        <div  style="width:90%; margin: auto;">
            <canvas id="wheel"></canvas>
        </div>
        <script>
            var ctx = document.getElementById('wheel').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'polarArea',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [
                        {
                            data: {!! json_encode($dataset) !!},
                            backgroundColor: [
                                'rgb(0, 255, 0)',
                                '#ed9b7e',
                                '#420542',
                                'rgb(238,255,0)',
                                'rgb(255, 0, 0)',
                                'rgb(0,0,0)',
                                'rgb(134,134,134)',
                                'rgb(75, 192, 192)',
                            ],
                        },
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    scale: {
                        ticks: {
                            min: 0,
                            max: 10
                        },
                    }
                }
            });
        </script>
    </div>
@endif