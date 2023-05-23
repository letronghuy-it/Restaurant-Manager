@extends('admin.share.master')
@section('noi_dung')
        <div class="row" id="app">
            <div class="col-4">
                <div class="card border-primary border-bottom border-3 border-0">
                    <div class="card-header">
                        <div class="row ">
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
                    <div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr >
                                        <th colspan="4" >Tổng Cộng:@{{number_format(tong_tien)}}</th>

                                    </tr>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Món Ăn Đã Bán</th>
                                        <th class="text-center">Chi Phí</th>
                                        <th class="text-center">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(value,key) in list_moanban">
                                        <tr>
                                            <th class="text-center align-middle">@{{key+1}}</th>
                                            <td class="align-middle">@{{value.ten_mon_an}}</td>
                                            <td class="align-middle">@{{number_format(value.thanh_tien)}}</td>
                                            <td class="align-middle text-center">
                                                <button v-on:click="ChiTietBanHang(value)" class="btn btn-primary ">Xem Chi Tiết</button>
                                            </td>
                                        </tr>
                                    </template>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-7">
                <div class="card border-primary border-bottom border-3 border-0">
                    <div class="card-header">
                        Chi Tiết Hoá Đơn Món Ăn
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tổng Tiền</th>
                                    <th colspan="5">@{{number_format(tong_tien)}}</th>
                                    <th class="text-capitalize">@{{tien_chu}}</th>
                                    <th>@{{number_format(giam_gia)}}</th>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Ngày</th>
                                    <th class="text-center">Tên Món</th>
                                    <th class="text-center">Số Lượng </th>
                                    <th class="text-center">Đơn Giá </th>
                                    <th class="text-center">Chiết Khấu</th>
                                    <th class="text-center">Bàn</th>
                                    <th class="text-center">Thành Tiền</th>
                                    <th class="text-center">Ghi Chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value,key) in list_ctm">
                                    <tr>
                                        <th class="text-center align-middle">@{{key+1}}</th>
                                        <th class="text-center align-middle">@{{value.ngay_thanh_toan}}</th>
                                        <td class="align-middle">@{{value.ten_mon_an}}</td>
                                        <td class="align-middle">@{{value.so_luong_ban}}</td>
                                        <td class="align-middle">@{{number_format(value.don_gia_ban)}}</td>
                                        <td class="align-middle">@{{number_format(value.tien_chiet_khau)}}</td>
                                        <td class="align-middle">@{{value.ten_ban}}</td>
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
            list_moanban:[],
            list_ctm:[],
            tong_tien:0,
            tien_chu:'',
            giam_gia:0,

        },
        created()   {

        },
        methods :   {
            ChiTietBanHang(value){

                axios
                    .post('{{Route("11")}}', value)
                    .then((res) => {
                    this.list_ctm=res.data.data;
                    this.tong_tien=res.data.tong_tien;
                    })
                    .catch((res) => {
                        $.each(res.response.data.errors, function(k, v) {
                            toastr.error(v[0]);
                        });
                    });
            },
            ThongKeBanHang(){
               axios
                .post('{{Route("10")}}', this.thong_ke)
                .then((res) => {
                    this.list_moanban=res.data.data;
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
