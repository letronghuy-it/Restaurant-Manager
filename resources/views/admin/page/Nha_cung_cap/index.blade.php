@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    Thông Tin Nhà Cung Cấp
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Mã Số Thuế</label>
                        <input v-model="add_ncc.ma_so_thue" v-on:blur="CheckMaSVT()" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên Công Ty</label>
                        <input v-model="add_ncc.ten_cong_ty" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên Liên Hệ</label>
                        <input v-model="add_ncc.ten_nguoi_dai_dien" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số Điện Thoại</label>
                        <input v-model="add_ncc.so_dien_thoai" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">email</label>
                        <input v-model="add_ncc.email" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa Chỉ</label>
                        <input v-model="add_ncc.dia_chi" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên Gọi Nhở</label>
                        <input v-model="add_ncc.ten_goi_nho" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Tình Trạng</b></label>
                        <select v-model="add_ncc.tinh_trang" class="form-control">
                            <option value="-1">Vui Lòng Thêm Tình Trạng</option>
                            <option value="1">Hiển THị</option>
                            <option value="0">Tạm Tắt</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button v-on:click="add()" id="add" class="btn btn-primary">Thêm Mới</button>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card table-responsive">
                <div class="card-header">
                    Danh Sách Nhà Cung Cấp
                </div>
                <div class="card-body table-responsive ">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Thông Tin Công Ty</th>
                                <th class="text-center">Thông Tin Liên Hệ</th>
                                <th class="text-center">Tình Trạng</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value,key) in list">
                                <tr>
                                    <th class="text-center align-middle">@{{ key + 1 }}</th>
                                    <td class="align-middle">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Mã số thuế</th>
                                                <td>@{{ value.ma_so_thue }}</td>
                                            </tr>
                                            <tr>
                                                <th>Địa chỉ</th>
                                                <td>@{{ value.dia_chi }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tên công ty</th>
                                                <td>@{{ value.ten_cong_ty }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="align-middle">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Tên liên hệ</th>
                                                <td>@{{ value.ten_nguoi_dai_dien }}</td>
                                            </tr>
                                            <tr>
                                                <th>Số điện thoại</th>
                                                <td>@{{ value.so_dien_thoai }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>@{{ value.email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tên gợi nhớ</th>
                                                <td>@{{ value.ten_goi_nho }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-success" v-on:click="changeStatus(value)"
                                            v-if="value.tinh_trang == 1">Đang Cung Cấp</button>
                                        <button class="btn btn-danger" v-on:click="changeStatus(value)" v-else>Dừng Cung
                                            Cấp</button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#updateModal"
                                            v-on:click="edit=Object.assign({},value)">Cập Nhật</button>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            v-on:click="del=value">Xóa Bỏ</button>
                                            {{-- <button class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#ChiTietModal"   v-on:click="getidHoaDon(value.id) ;OpenTable(value.id)" >Nhập Hàng</button> --}}

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
                                            Bạn Chắc Chắng sẽ xoá <b class="text-uppercase"> @{{ del.ten_cong_ty }}</b>
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
                                        <label class="form-label">Mã Số Thuế</label>
                                        <input v-model="edit.ma_so_thue" v-on:blur="CheckMaSVTupdate()" type="text"
                                            class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tên Công Ty</label>
                                        <input v-model="edit.ten_cong_ty" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Người Đại Diện</label>
                                        <input v-model="edit.ten_nguoi_dai_dien" type="text" class="form-control">
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
                                        <label class="form-label">Địa Chỉ</label>
                                        <input v-model="edit.dia_chi" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tên Gọi Nhở</label>
                                        <input v-model="edit.ten_goi_nho" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><b>Tình Trạng</b></label>
                                        <select v-model="edit.tinh_trang" class="form-control">
                                            <option value="-1">Vui Lòng Thêm Tình Trạng</option>
                                            <option value="1">Hiển THị</option>
                                            <option value="0">Tạm Tắt</option>
                                        </select>
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
    {{-- <script>
        $(document).ready(function() {
            $("#add").prop('disabled', true);
            $("#accpect_update").click(function() {
                var id                  = $("#edit_id").val();
                var ma_so_thue          = $("#edit_ma_so_thue").val();
                var ten_cong_ty         = $("#edit_ten_cong_ty").val();
                var ten_nguoi_dai_dien  = $("#edit_ten_nguoi_dai_dien").val();
                var so_dien_thoai       = $("#edit_so_dien_thoai").val();
                var email               = $("#edit_email").val();
                var dia_chi             = $("#edit_dia_chi").val();
                var ten_goi_nho         = $("#edit_ten_goi_nho").val();
                var tinh_trang          = $("#edit_tinh_trang").val();
                var payload = {
                    'id': id,
                    'ma_so_thue': ma_so_thue,
                    'ten_cong_ty': ten_cong_ty,
                    'ten_nguoi_dai_dien': ten_nguoi_dai_dien,
                    'so_dien_thoai': so_dien_thoai,
                    'email': email,
                    'dia_chi': dia_chi,
                    'ten_goi_nho': ten_goi_nho,
                    'tinh_trang': tinh_trang,

                };
                axios
                    .post('/admin/nha-cung-cap/update', payload)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.success(res.data.message, "Success!");
                            $('#updateModal').modal('hide');
                            loadData();
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, "Error");
                        }
                    });
            });
            $('#edit_ma_so_thue').keyup(function() {
                $("#accpect_update").prop('disabled', true);
                // var slug = toSlug($(this).val());
            })
            $('#add_ma_so_thue').keyup(function() {
                $("#add").prop('disabled', true);
                // var slug = toSlug($(this).val());
            })
            $("#edit_ma_so_thue").blur(function() {

                var ma = $("#edit_ma_so_thue").val();
                var payload = {
                    'ma_so_thue': ma,
                    'id': $("#edit_id").val(),
                };
                axios.post('/admin/nha-cung-cap/ChecksMasothue', payload)
                    .then((res) => {
                        if (res.data.status == 1) {
                            toastr.success(res.data.message, "Success");
                            $("#accpect_update").removeAttr("disabled");
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, "Error");
                            $("#accpect_update").prop('disabled', true);
                        } else if (res.data.status == 2) {
                            toastr.warning(res.data.message, "Warning");
                        }
                    });
            });
            $("#add_ma_so_thue").blur(function() {
                var slug = $("#add_ma_so_thue").val();
                var payload = {
                    'ma_so_thue': slug,
                    'id': $("#add_id").val(),
                };
                axios.post('/admin/nha-cung-cap/ChecksMasothue', payload)
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
            });


            $("body").on('click', '#add', function() {
                $("#add").prop('disabled', true);
                var ma_so_thue = $("#add_ma_so_thue").val();
                var ten_cong_ty = $("#add_ten_cong_ty").val();
                var ten_nguoi_dai_dien = $("#add_ten_nguoi_dai_dien").val();
                var so_dien_thoai = $("#add_so_dien_thoai").val();
                var email = $("#add_email").val();
                var dia_chi = $("#add_dia_chi").val();
                var ten_goi_nho = $("#add_ten_goi_nho").val();
                var tinh_trang = $("#add_tinh_trang").val();
                var payload = {
                    'ma_so_thue': ma_so_thue,
                    'ten_cong_ty': ten_cong_ty,
                    'ten_nguoi_dai_dien': ten_nguoi_dai_dien,
                    'so_dien_thoai': so_dien_thoai,
                    'email': email,
                    'dia_chi': dia_chi,
                    'ten_goi_nho': ten_goi_nho,
                    'tinh_trang': tinh_trang,

                };

                axios
                    .post('/admin/nha-cung-cap/create', payload)
                    .then((res) => {
                        if (res.data.status == 1) {
                            toastr.success(res.data.message, "Success");
                            loadData();
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, "Error");
                        } else if (res.data.status == 2) {
                            toastr.warning(res.data.message, "Warning");
                        }
                        $("#add_ma_so_thue").val('');
                        $("#add_ten_cong_ty").val('');
                        $("#add_ten_nguoi_dai_dien").val('');
                        $("#add_so_dien_thoai").val('');
                        $("#add_email").val('');
                        $("#add_dia_chi").val('');
                        $("#add_ten_goi_nho").val('');
                        $("#add_tinh_trang").val('-1');
                        $("#add").removeAttr("disabled");
                    });
            });

            loadData();

            function loadData() {
                axios
                    .get('/admin/nha-cung-cap/data')
                    .then((res) => {
                        var list = res.data.list;
                        var code = "";
                        console.log(list);
                        $.each(list, function(key, value) {
                            code += ' <tr>'
                            code += ' <th class="text-center align-middle">' + (key + 1) + '</th>'
                            code += ' <td class="align-middle">'
                            code += ' <table class="table table-bordered">'
                            code += ' <tr>'
                            code += ' <th>Mã số thuế</th>'
                            code += ' <td>' + value.ma_so_thue + '</td>'
                            code += ' </tr>'
                            code += ' <tr>'
                            code += ' <th>Địa chỉ</th>'
                            code += ' <td>' + value.dia_chi + '</td>'
                            code += ' </tr>'
                            code += ' <tr>'
                            code += ' <th>Tên công ty</th>'
                            code += ' <td>' + value.ten_cong_ty + '</td>'
                            code += ' </tr>'
                            code += ' </table>'
                            code += ' </td>'
                            code += ' <td class="align-middle">'
                            code += ' <table class="table table-bordered">'
                            code += ' <tr>'
                            code += ' <th>Tên liên hệ</th>'
                            code += ' <td>' + value.ten_nguoi_dai_dien + '</td>'
                            code += ' </tr>'
                            code += ' <tr>'
                            code += ' <th>Số điện thoại</th>'
                            code += ' <td>' + value.so_dien_thoai + '</td>'
                            code += ' </tr>'
                            code += ' <tr>'
                            code += ' <th>Email</th>'
                            code += ' <td>' + value.email + '</td>'
                            code += ' </tr>'
                            code += ' <tr>'
                            code += ' <th>Tên gợi nhớ</th>'
                            code += ' <td>' + value.ten_goi_nho + '</td>'
                            code += ' </tr>'
                            code += ' </table>'
                            code += ' </td>'
                            code += ' <td class="text-center align-middle">'
                            if (value.tinh_trang == 1) {
                                code += ' <button data-idma="' + value.id +
                                    '"class="doitrangthai   btn btn-success">Hiển Thị</button>'
                            } else {
                                code += ' <button data-idma="' + value.id +
                                    '"class="doitrangthai btn btn-warning">Tạm Dừng</button>'

                            }
                            code += ' </td>'
                            code += ' <td class="text-center align-middle">'
                            code += '<button data-idma="' + value.id +'" class="update btn btn-info m-1" data-bs-toggle="modal" data-bs-target="#updateModal" >Cập Nhật</button>'
                            code += '<button data-idma="' + value.id +'" class="delete btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletemodal">Xoá</button>'
                            code += ' </td>'
                            code += ' </tr>'
                        });
                        $('#listnhacungcap tbody').html(code);
                    });
            }


            $("body").on('click', '.doitrangthai', function() {
                var id = $(this).data("idma");
                var payload = {
                    'id': id
                };
                axios
                    .post('/admin/nha-cung-cap/doi-trang-thai', payload)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.success(res.data.message, "Thông Báo")
                            loadData();
                        } else {
                            toastr.error(res.data.message, "Thông Báo!!")
                        }
                    });
            });
            $("body").on('click', '.delete', function() {
                var id = $(this).data("idma");
                $('#id_delete').val(id);

            })
            $("body").on('click', '#accpect_delete', function() {
                var id = $('#id_delete').val();
                var payload = {
                    'id': id
                };
                axios
                    .post('/admin/nha-cung-cap/delete', payload)
                    .then((res) => {
                        if (res.data.status == 1) {
                            toastr.success(res.data.message, "Xoá Thành Công");
                            loadData();
                            // $('#deleteModal').modal('hide');
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, "Không Có Bàn Để Xoá");
                        }
                    });
            })
            $("body").on('click', '.update', function() {
                var id = $(this).data("idma");
                var payload = {
                    'id': id
                };
                axios
                    .post('/admin/nha-cung-cap/edit', payload)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.success(res.data.message, 'Thông Báo !')
                            $('#edit_id').val(res.data.NhaCungCap.id);
                            $('#edit_ma_so_thue').val(res.data.NhaCungCap.ma_so_thue);
                            $('#edit_ten_cong_ty').val(res.data.NhaCungCap.ten_cong_ty);
                            $('#edit_ten_nguoi_dai_dien').val(res.data.NhaCungCap.ten_nguoi_dai_dien);
                            $('#edit_so_dien_thoai').val(res.data.NhaCungCap.so_dien_thoai);
                            $('#edit_email').val(res.data.NhaCungCap.email);
                            $('#edit_dia_chi').val(res.data.NhaCungCap.dia_chi);
                            $('#edit_ten_goi_nho').val(res.data.NhaCungCap.ten_goi_nho);
                            $('#edit_tinh_trang').val(res.data.NhaCungCap.tinh_trang);
                        } else {
                            toastr.error(res.data.message, "Error");
                        }
                    });
            });
        });
    </script> --}}
    <script>
         toastr.options = {
            "positionClass": "toast-bottom-center",
            "preventDuplicates": true,
            "timeOut": "5000"
        }
        new Vue({
            el: '#app',
            data: {
                add_ncc: {
                    'tinh_trang': 1,
                },
                list: [],
                del: {},
                edit: {},
                list_ncc:[],
            },
            created() {
                this.loadData();
                this.LoadDataMonAn();
            },
            methods: {
                add() {
                    $("#add").prop('disabled', true);
                    axios
                        .post('/admin/nha-cung-cap/create', this.add_ncc)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, "Success");
                                this.loadData();
                                this.add_ncc = {
                                    'ma_so_thue': '',
                                    'ten_cong_ty': '',
                                    'ten_nguoi_dai_dien': '',
                                    'so_dien_thoai': '',
                                    'email': '',
                                    'dia_chi': '',
                                    'ten_goi_nho': '',
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
                accpectdelete() {
                    axios
                        .post('/admin/nha-cung-cap/delete', this.del)
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
                accpectupdate() {
                    axios
                        .post('/admin/nha-cung-cap/update', this.edit)
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
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                            $("#accpectUpdate").removeAttr("disabled");
                        });
                },
                loadData() {
                    axios
                        .get('/admin/nha-cung-cap/data')
                        .then((res) => {
                            this.list = res.data.list;
                        });
                },
                changeStatus(payload) {
                    axios
                        .post('/admin/nha-cung-cap/doi-trang-thai', payload)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.massage, "Thông Báo")
                                this.loadData();
                            } else {
                                toastr.error(res.data.massage, "Thông Báo!!")
                            }
                        });
                },
                CheckMaSVT() {
                    var payload = {
                        'ma_so_thue': this.add_ncc.ma_so_thue
                    };
                    axios
                        .post('/admin/nha-cung-cap/ChecksMasothue', payload)
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
                CheckMaSVTupdate() {
                    var payload = {
                        'ma_so_thue': this.edit.ma_so_thue
                    };
                    axios
                        .post('/admin/nha-cung-cap/ChecksMasothue', payload)
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
                },
                number_format(number) {
                    return new Intl.NumberFormat('vi-VI', {
                        style: 'currency',
                        currency: 'VND'
                    }).format(number);
                },
            }
        });
    </script>
@endsection
