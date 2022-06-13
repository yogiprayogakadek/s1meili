<div>
    <canvas id="myChart"></canvas>
</div>
<script>
    $('body .chart-title').html('Chart Produk Terlaris {{$bulan}} {{$tahun}}');

    var labelTerlaris = [];
    var produkTerlaris = [];

    @foreach ($terlaris as $key => $value)
        labelTerlaris.push('{{$terlaris[$key]["nama_produk"]}}');
        produkTerlaris.push('{{$terlaris[$key]["jumlah"]}}');
    @endforeach

    console.table(labelTerlaris);

    var data = {
        labels: labelTerlaris,
        // datasets: dataa
        datasets: [{
            label: 'Penjualan',
            data: produkTerlaris,
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