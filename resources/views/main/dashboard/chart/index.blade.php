<div>
    <canvas id="myChart"></canvas>
</div>
<script>
    @if ($totalData == 0)
        $('body .render').html('<div class="alert alert-danger text-center">Tidak ada data pada bulan ini</div>');
    @endif

    $('body .chart-title').html('Chart Produk {{$bulan}} {{$tahun}}');

    var label = [];
    var jumlah = [];

    @foreach ($chart as $key => $value)
        label.push('{{$chart[$key]["label"]}}');
        jumlah.push('{{$chart[$key]["jumlah"]}}');
    @endforeach

    var data = {
        labels: label,
        datasets: [{
            label: '{{$kategori}}',
            data: jumlah,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    };

    var config = {
        type: 'bar',
        data: data,
        options: {}
    };

    var myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>