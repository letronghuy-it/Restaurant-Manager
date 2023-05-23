@extends('admin.share.master');
@section('noi_dung')
<div class="row" >
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
    <div class="col-10" >
        <div class="card">
            <div class="card-body">
                <div>
                    <canvas style="height: 500px" id="myChart"></canvas>
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
var mychart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: [],
    datasets: [{
      label: 'Khách Hàng Ăn Nhiều Nhất Quán',
      data: [],
      borderWidth: 1,
      backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(217, 136, 128)',
                        'rgb(192, 57, 43)',
                        'rgb(195, 155, 211 )',
                        'rgb(136, 78, 160)',
                        'rgb(84, 153, 199)',
                        'rgb(21, 67, 96)',
                        'rgb(46, 204, 113)',
                        'rgb(241, 196, 15)',
                        'rgb(160, 64, 0)',
                    ],
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

var list_ten = [];
var list_tien = [];
$("#thongke").click(function(){
    var payload = {
                "begin": $("#begin").val(),
                "end": $("#end").val(),
            };
    axios
        .post('{{Route("Thong-Ke-Khach-Hang")}}', payload)
        .then((res) => {
            list_ten = res.data.list_ten;
            list_tien =res.data.list_tien;
        })
        .finally(function() {
                    showChart(list_ten, list_tien);
                })

})
function showChart(list_ten, list_tien) {
            mychart.data.labels = list_ten;
            mychart.data.datasets[0].data = list_tien;
            mychart.update();
        }
</script>
@endsection
