@extends('admin.share.master')
@section('noi_dung')
<div class="row" id="app">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row ">
                    <div class="col-3">
                        <h6>Thống Kê</h6>
                    </div>
                    <div class="col-3 mt-4"></div>
                    <div class="col">
                        <h6>Từ Ngày</h6>
                        <input v-model="thong_ke.begin" type="date" class="form-control">
                    </div>
                    <div class="col">
                        <h6>Đến Ngày</h6>
                        <input v-model="thong_ke.end" type="date" class="form-control">
                    </div>
                    <div class="col mt-4">
                       <button v-on:click = "ThongKeBanHang()" class="btn btn-success">
                        <i class="fa-solid fa-magnifying-glass"></i>
                       </button>
                    </div>
                </div>
            </div>
            <div class="card-body">

            </div>
        </div>
    </div>
    <div class="col-5">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header"></div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Ngày Hoá Đơn</th>
                            <th class="text-center">Giảm Giá</th>
                            <th class="text-center">Tổng Tiền</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(value,key) in list_hd">
                            <tr>
                                <th class="text-center align-middle">@{{key+1}}</th>
                                <td class="align-middle">@{{value.ngay_thanh_toan}}</td>
                                <td class="align-middle">@{{number_format(value.giam_gia)}}</td>
                                <td class="align-middle">@{{number_format(value.tong_tien)}}</td>
                                <td class="align-middle">
                                    <button v-on:click="ChiTietBanHang(value)" class="btn btn-primary">Xem Chi Tiết</button>
                                </td>
                            </tr>
                        </template>

                    </tbody>
                </table>

            </div>
        </div>


    </div>
    <div class="col-7">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header">
                Chi Tiết Hoá Đơn Bán Hàng -
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tổng Tiền</th>
                            <th colspan="5">@{{number_format(tong_tien)}}</th>
                            <th class="text-capitalize">@{{tt_chu}}</th>
                        </tr>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Tên Món</th>
                            <th class="text-center">Số Lượng </th>
                            <th class="text-center">Đơn Giá </th>
                            <th class="text-center">Chiết Khấu </th>
                            <th class="text-center">Thành Tiền  </th>
                            <th class="text-center">Ghi Chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(value,key) in list_ct">
                            <tr>
                                <th class="text-center align-middle">@{{key+1}}</th>
                                <td class="align-middle">@{{value.ten_mon_an}}</td>
                                <td class="align-middle">@{{value.so_luong_ban}}</td>
                                <td class="align-middle">@{{number_format(value.don_gia_ban)}}</td>
                                <td class="align-middle">@{{number_format(value.tien_chiet_khau)}}</td>
                                <td class="align-middle">@{{number_format(value.thanh_tien)}}</td>
                                <td class="align-middle">@{{value.ghi_chu}}</td>
                            </tr>
                        </template>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    new Vue({
        el      :   '#app',
        data    :   {
            thong_ke:{},
            list_hd:[],
            list_ct:[],
            tong_tien:0,
            tt_chu:'',
        },
        created()   {

        },
        methods :   {
            ChiTietBanHang(value){
                axios
                    .post('{{Route("9")}}', value)
                    .then((res) => {
                        this.list_ct=res.data.data;
                        this.tong_tien=res.data.tong_tien;
                        this.tt_chu =res.data.tt_chu;
                    })
                    .catch((res) => {
                        $.each(res.response.data.errors, function(k, v) {
                            toastr.error(v[0]);
                        });
                    });
            },
            ThongKeBanHang(){
                axios
                    .post('{{Route("8")}}', this.thong_ke)
                    .then((res) => {
                        if(res.data.status) {
                            toastr.success(res.data.message);
                            this.list_hd=res.data.data;

                        } else {
                            toastr.error(res.data.message);
                        }
                    })
                    .catch((res) => {
                        $.each(res.response.data.errors, function(k, v) {
                            toastr.error(v[0]);
                        });
                    });
            },
            number_format(number) {
                        return new Intl.NumberFormat('vi-VI', {
                            style: 'currency',
                            currency: 'VND'
                        }).format(number);
                    },
        },
    });
</script>
@endsection
