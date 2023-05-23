@extends('admin.share.master');
@section('noi_dung')
<div class="row">
    <div class="col-2">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header">
                <div class="row ">
                    <div class="col">
                        <h6>Từ Ngày</h6>
                        <input id="begin" type="date" class="form-control">
                    </div>
                    <div class="col">
                        <h6>Đến Ngày</h6>
                        <input id="end" type="date" class="form-control">
                    </div>
                    <div class="col mt-4">
                       <button id="thongke" class="btn btn-success">
                        Timg Kiếm <i class="fa-solid fa-magnifying-glass"></i>
                       </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-10">
        <div class="card">
            <div class="card-body">
                <div>
                    <canvas id="myChart"></canvas>
                  </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
