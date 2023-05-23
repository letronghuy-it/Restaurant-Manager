@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    Nhập Thông Tin Khách Hàng
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Mã Khách Hàng</label>
                        <input v-model="add.ma_khach_hang" v-on:blur="CheckMaKH()" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Họ Lót</label>
                        <input v-model="add.ho_lot" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên Khách</label>
                        <input v-model="add.ten_khach" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số Điện Thoại</label>
                        <input v-model="add.so_dien_thoai" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">email</label>
                        <input v-model="add.email" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ghi Chú</label>
                        <input v-model="add.ghi_chu" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ngày Sinh</label>
                        <input v-model="add.ngay_sinh" type="date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Loại Khách Hàng</b></label>
                        <select v-model="add.id_loai_khach" class="form-control">
                            <option value="0">Vui Lòng Thêm Loại Khách Hàng</option>
                            @foreach ($loai_khach_hang as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->ten_loai_khach }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mã Số Thuế</label>
                        <input v-model="add.ma_so_thue" type="text" class="form-control">
                    </div>
                </div>
                <div class="card-footer">
                    <button v-on:click="addnew()" id="add" class="btn btn-primary">Thêm Mới</button>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    Danh Sách Nhà Cung Cấp
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-responsive">
                        <thead>
                                <tr>
                                    <th class="text-center align-middle">Tìm Kiếm</th>
                                    <th colspan="2"><input type="text" v-model="key_search" v-on:keyup.enter="search()"
                                            class="form-control" name="" id=""></th>
                                    <th><button v-on:click="search()" class="btn btn-primary">Tìm Kiếm<i class='bx bx-search'></i></button></th>
                                </tr>
                            <tr>
                                <th class="text-center">
                                    <button class="btn btn-danger" v-on:click="destroyall()">
                                        Xoá Tất Cả
                                    </button>
                                </th>
                                <th class="text-center">Thông Tin Khách Hàng</th>
                                <th class="text-center">Thông Tin Liên Hệ</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value,key) in list">
                                <tr>
                                    <th class="text-center align-middle">
                                        <input type="checkbox" v-model="value.check"  style="transform: scale(1.5);cursor: pointer;" name="" id="">
                                    </th>
                                    <td class="align-middle">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Mã Khách Hàng</th>
                                                <td>@{{ value.ma_khach_hang }}</td>
                                            </tr>
                                            <tr>
                                                <th>Họ Và Tên Khách Hàng</th>
                                                <td>@{{ value.ho_va_ten }}</td>
                                            </tr>
                                            <tr>
                                                <th>Loại Khách Hàng</th>
                                                <td>@{{ value.ten_loai_khach}}</td>
                                            </tr>
                                            <tr>
                                                <th>Số Điện Thoại</th>
                                                <td>@{{ value.so_dien_thoai }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="align-middle">
                                        <table class="table table-bordered">

                                            <tr>
                                                <th>Ghi Chú</th>
                                                <td>@{{ value.ghi_chu }}</td>
                                            </tr>
                                            <tr>
                                                <th>Ngày Sinh</th>
                                                <td>@{{ value.ngay_sinh }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>@{{ value.email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Mã Số thuế</th>
                                                <td>@{{ value.ma_so_thue }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#updateModal"
                                            v-on:click="edit=Object.assign({},value)">Cập Nhật</button>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            v-on:click="del=value">Xóa Bỏ</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                    {{-- Delete --}}
                    <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Xoá Món Ăn</h1>
                                    <div class="text-end">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                                <div class="modal-body">

                                    <div class="alert alert-danger" role="alert">
                                        <b>
                                            Bạn Chắc Chắng sẽ xoá <b class="text-uppercase"> @{{ del.ho_va_ten }}</b>
                                            này!.việc này không thể thay đổi, hãy cẩn thận
                                        </b>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="accpectdelete()" type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal">Xác
                                        Nhận Xoá</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Cập Nhật --}}
                    <div class="modal fade" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Thông Cập Nhật Món Ăn</h1>
                                    <div class="text-end">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Mã Khách Hàng</label>
                                        <input v-model="edit.ma_khach_hang" v-on:blur="CheckMaKH()" type="text"
                                            class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Họ Và Tên</label>
                                        <input v-model="edit.ho_va_ten" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Họ Lót</label>
                                        <input v-model="edit.ho_lot" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tên Khách</label>
                                        <input v-model="edit.ten_khach" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Số Điện Thoại</label>
                                        <input v-model="edit.so_dien_thoai" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">email</label>
                                        <input v-model="edit.email" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Ghi Chú</label>
                                        <input v-model="edit.ghi_chu" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Ngày Sinh</label>
                                        <input v-model="edit.ngay_sinh" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><b>Loại Khách Hàng</b></label>
                                        <select v-model="add.id_loai_khach" class="form-control">
                                            <option value="0">Vui Lòng Thêm Loại Khách Hàng</option>
                                            @foreach ($loai_khach_hang as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->ten_loai_khach }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mã Số Thuế</label>
                                        <input v-model="edit.ma_so_thue" type="text" class="form-control">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="accpectupdate()" id="accpectUpdate" type="button"
                                        class="btn btn-primary">Cập Nhật</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                list: [],
                add: {
                    'id_loai_khach':0
                },
                edit: {},
                del: {},
                key_search:'',
            },
            created() {
                this.loadData();
            },
            methods: {
                destroyall(){
                    var payload ={
                        'list'  : this.list
                    };
                    axios
                    .post('{{Route("destoyall-khach-hang")}}', payload)
                        .then((res) => {
                            if(res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData();
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
                search(){
                    var payload = {
                        'key_search' :this.key_search,
                    }
                    axios
                    .post('/admin/khach-hang/search',payload)
                    .then((res) => {
                            this.list = res.data.list;
                        })
                        .catch((res)=>{
                            $.each(res.response.data.errors ,function(k,v){
                                toastr.error(v[0]);
                            });

                        });
                },
                loadData() {
                    axios
                        .get('/admin/khach-hang/data')
                        .then((res) => {
                            this.list = res.data.list;
                        });
                },
                addnew() {
                     $("#add").prop('disabled', true);
                    axios
                        .post('/admin/khach-hang/create', this.add)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, "Success");
                                this.loadData();
                                this.add = {
                                    'ma_khach_hang':'',
                                    'ho_va_ten':'',
                                    'ho_lot':'',
                                    'ten_khach':'',
                                    'so_dien_thoai':'',
                                    'email':'',
                                    'ghi_chu':'',
                                    'ngay_sinh':'',
                                    'id_loai_khach':'',
                                    'ma_so_thue':'',
                                };
                                $("#add").removeAttr("disabled");
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, "Error");
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message, "Warning");
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                            $("#add").removeAttr("disabled");
                        });
                },
                accpectdelete(){
                    axios
                        .post('/admin/khach-hang/delete', this.del)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, "Success");
                                this.loadData();
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, "Error");
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message, "Warning");
                            }

                        });
                },
                accpectupdate(){
                    axios
                        .post('/admin/khach-hang/update', this.edit)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, "Success");
                                $('#updateModal').modal('hide');
                                this.loadData();
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, "Error");
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message, "Warning");
                            }

                        })
                        .catch((res)=>{
                            $.each(res.response.data.errors,function(k,v){
                                toastr.error(v[0]);
                            });
                            $("#accpectUpdate").removeAttr("disabled");
                        });
                },
                CheckMaKH(){
                    var payload = {
                        'ma_khach_hang':this.add.ma_khach_hang
                    };
                    axios
                        .post('/admin/khach-hang/ChecksMakhachhang', payload)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, "Success");
                                $("#add").removeAttr("disabled");
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, "Error");
                                $("#add").prop('disabled', true);
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message, "Warning");
                            }
                        });
                },
                CheckMaKH(){
                    var payload = {
                        'ma_khach_hang':this.edit.ma_khach_hang
                    };
                    axios
                        .post('/admin/khach-hang/ChecksMakhachhang', payload)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, "Success");
                                $("#accpectUpdate").removeAttr("disabled");
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, "Error");
                                $("#accpectUpdate").prop('disabled', true);
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message, "Warning");
                            }
                        });
                }
            },
        })
    </script>
@endsection
