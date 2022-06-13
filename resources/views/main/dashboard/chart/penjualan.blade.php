<div>
    <canvas id="myChart"></canvas>
</div>
<script>
    $('body .chart-title').html('Chart Penjualan Produk {{$bulan}} {{$tahun}}');

    var labelTerlaris = [];
    var produkTerlaris = [];
    var datasets = [];
    var borderColor = [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
    ]
    var backgroundColor = [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
    ]
    @foreach ($labels as $key => $value)
        labelTerlaris.push('{{$labels[$key]}}');
        produkTerlaris.push('{{$tt[$key] }}');
    @endforeach

    @foreach ($produk as $produk)
        datasets.push({
            type: 'bar',
            label: '{{$produk->nama_produk}}',
            data: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31],
            borderColor: borderColor[{{$loop->index}}],
            backgroundColor: backgroundColor[{{$loop->index}}],
            // borderWidth: 1
        })
    @endforeach

    console.table(produkTerlaris);

    var data = {
        labels: labelTerlaris,
        // datasets: dataa
        datasets: datasets
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