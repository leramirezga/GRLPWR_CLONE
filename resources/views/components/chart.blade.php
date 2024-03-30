<style>
    canvas{
        width:100% !important;
        height:450px !important;
    }
</style>

<div  style="width:90%; margin: auto;">
    <canvas id="{{$id}}"></canvas>
</div>

<script>
    var ctx = document.getElementById('{{$id}}').getContext('2d');
    var myChart = new Chart(ctx, {
        type: '{{$type}}',
        data: {
            labels: {!! $labels !!},
            datasets: [
                    @foreach($datasets as $dataset)
                {
                    label: '{{$dataset["label"]}}',
                    data: {!! json_encode($dataset["data"]) !!},
                    backgroundColor: '{{$dataset["backgroundColor"]}}',
                    borderColor: '{{$dataset["borderColor"] ?? 'rgba(75, 192, 192, 1)'}}', // Puedes manejar esto opcionalmente
                    borderWidth: 1
                },
                @endforeach
            ]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>