@extends('admin.share.master')
@section('noi_dung')
    <style>
        .modal-content {
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.4);
        }

        .card-footer button {
            border: none;
            border-radius: 25px;
            margin-left: 76%;
        }
    </style>
    <div class="row">
        <div class="col-4">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <b>Nhập Thông Tin Món Ăn</b>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Tên Món Ăn</label>
                        <input id="add_ten_mon_an" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug Món Ăn</label>
                        <input id="add_slug_mon_an" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giá Bán</label>
                        <input id="add_gia_ban" type="number" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Tình Trạng</b></label>
                        <select id="add_tinh_trang" class="form-control">
                            <option value="-1">Vui Lòng Thêm Tình Trạng</option>
                            <option value="1">Hiển THị</option>
                            <option value="0">Tạm Tắt</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Danh Mục</label>
                        <select id="add_id_danh_muc" class="form-control">
                            <option value="0">Vui Lòng Thêm Danh Mục Món Ăn</option>
                            @foreach ($danhmuc as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->ten_danh_muc }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="card-footer text-end">
                    <button id="add" class="btn btn-primary">Thêm Mới</button>
                </div>
            </div>
        </div>
        <div class="col-8">
            <table class="table table-bordered" id="listmonan">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Tên Món Ăn</th>
                        <th class="text-center">Slug Món Ăn</th>
                        <th class="text-center">Giá Bán</th>
                        <th class="text-center">Tình Trạng</th>
                        <th class="text-center">Danh Mục</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="text-center align-middle">1</th>
                        <td class="align-middle">.....</td>
                        <td class="align-middle">.....</td>
                        <td class="align-middle">.....</td>
                        <td class="align-middle text-center">
                            <button class="btn btn-success">Hiển Thị</button>
                            <button class="btn btn-danger">Tắt</button>
                        </td>
                        <td class="align-middle">id danhmuc</td>
                        <td class="align-middle text-center text-nowrap">
                            <button class="btn btn-info">Cập Nhật</button>
                            <button class="btn btn-danger">Xoá</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            {{-- Model Xoá Bỏ  --}}
            <div class="modal fade" id="deletemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                            <input type="text" class="form-control" id="id_delete">
                            <div class="alert alert-primary" role="alert">
                                Bạn Chắc Chắng sẽ xoá dữ liệu khu vực này!.việc này không thể thay đổi, hãy cẩn thận
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button id="accpect_delete" type="button" class="btn btn-danger" data-bs-dismiss="modal">Xác
                                Nhận Xoá</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Model Cập Nhật --}}
            <div class="modal fade" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                            <input type="text" class="form-control" id="edit_id">
                            <div class="mb-3">
                                <label class="form-label">Tên Món Ăn</label>
                                <input id="edit_ten_mon_an" type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Slug Món Ăn</label>
                                <input id="edit_slug_mon_an" type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Giá Bán</label>
                                <input id="edit_gia_ban" type="number" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><b>Tình Trạng</b></label>
                                <select id="edit_tinh_trang" class="form-control">
                                    <option value="1">Hiển THị</option>
                                    <option value="0">Tạm Tắt</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Danh Mục</label>
                                <select id="edit_id_danh_muc" class="form-control">
                                    <option value="0">Vui Lòng Thêm Danh Mục Món Ăn</option>
                                    @foreach ($danhmuc as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->ten_danh_muc }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button id="accpect_update" type="button" class="btn btn-primary">Cập Nhật</button>
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
        $(document).ready(function() {
            $("#add").prop('disabled', true);


            $("#accpect_update").click(function() {
                var id = $("#edit_id").val();
                var ten_mon_an = $("#edit_ten_mon_an").val();
                var slug_mon_an = $("#edit_slug_mon_an").val();
                var gia_ban = $("#edit_gia_ban").val();
                var tinh_trang = $("#edit_tinh_trang").val();
                var id_danh_muc = $("#edit_id_danh_muc").val();
                var payload = {
                    'id': id,
                    'ten_mon_an': ten_mon_an,
                    'slug_mon_an': slug_mon_an,
                    'gia_ban': gia_ban,
                    'tinh_trang': tinh_trang,
                    'id_danh_muc': id_danh_muc
                };
                axios
                    .post('/admin/mon-an/update', payload)
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
            $("#edit_ten_mon_an").blur(function() {
                var slug = toSlug($(this).val());
                var payload = {
                    'slug_mon_an': slug,
                    'id': $("#edit_id").val()
                };
                axios.post('/admin/mon-an/check-slug', payload)
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

            $('#edit_ten_mon_an').keyup(function() {
                $("#accpect_update").prop('disabled', true);
                var slug = toSlug($(this).val());
                $("#edit_slug_mon_an").val(slug);
            })

            function toSlug(str) {
                // Chuyển hết sang chữ thường
                str = str.toLowerCase();

                // xóa dấu
                str = str
                    .normalize('NFD') // chuyển chuỗi sang unicode tổ hợp
                    .replace(/[\u0300-\u036f]/g, ''); // xóa các ký tự dấu sau khi tách tổ hợp

                // Thay ký tự đĐ
                str = str.replace(/[đĐ]/g, 'd');

                // Xóa ký tự đặc biệt
                str = str.replace(/([^0-9a-z-\s])/g, '');

                // Xóa khoảng trắng thay bằng ký tự -
                str = str.replace(/(\s+)/g, '-');

                // Xóa ký tự - liên tiếp
                str = str.replace(/-+/g, '-');

                // xóa phần dư - ở đầu & cuối
                str = str.replace(/^-+|-+$/g, '');

                // return
                return str;
            }

            function convert(number) {
                return new Intl.NumberFormat('vi-VI', {
                    style: 'currency',
                    currency: 'VND'
                }).format(number);
            }
            $("#add_ten_mon_an").blur(function() {
                var slug = toSlug($(this).val());
                var payload = {
                    'slug_mon_an': slug
                };
                axios.post('/admin/mon-an/check-slug', payload)
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
            $('#add_ten_mon_an').keyup(function() {
                var slug = toSlug($(this).val());
                $("#add_slug_mon_an").val(slug);
            })

            $("body").on('click', '#add', function() {
                if ($("#add_ten_mon_an").val() == '' || $("#add_slug_mon_an").val() == '' || $(
                        "#add_gia_ban").val() == '' || $("#add_tinh_trang").val() == '-1' || $(
                        "#add_id_danh_muc").val() == '0') {
                    toastr.warning("Vui lòng nhập đầy đủ thông tin", "Warning");
                    return; // dừng hàm nếu thông tin chưa đầy đủ
                }
                $("#add").prop('disabled', true);
                var ten_mon_an = $("#add_ten_mon_an").val();
                var slug_mon_an = $("#add_slug_mon_an").val();
                var gia_ban = $("#add_gia_ban").val();
                var tinh_trang = $("#add_tinh_trang").val();
                var id_danh_muc = $("#add_id_danh_muc").val();
                var payload = {
                    'ten_mon_an': ten_mon_an,
                    'slug_mon_an': slug_mon_an,
                    'gia_ban': gia_ban,
                    'tinh_trang': tinh_trang,
                    'id_danh_muc': id_danh_muc
                };

                axios
                    .post('/admin/mon-an/create', payload)
                    .then((res) => {
                        if (res.data.status == 1) {
                            toastr.success(res.data.message, "Success");
                            loadData();
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, "Error");
                        } else if (res.data.status == 2) {
                            toastr.warning(res.data.message, "Warning");
                        }
                        $("#add_ten_mon_an").val('');
                        $("#add_slug_mon_an").val('');
                        $("#add_gia_ban").val('');
                        $("#add_tinh_trang").val('-1');
                        $("#add_id_danh_muc").val('0');
                        $("#add").removeAttr("disabled");
                    });
            });
            loadData();

            function loadData() {
                axios
                    .get('/admin/mon-an/data')
                    .then((res) => {
                        var list = res.data.list;
                        var code = "";
                        console.log(list);
                        $.each(list, function(key, value) {
                            code += '<tr>'
                            code += '<th class="text-center align-middle">' + (key + 1) + '</th>'
                            code += '<td class="align-middle">' + value.ten_mon_an + '</td>'
                            code += '<td class="align-middle">' + value.slug_mon_an + '</td>'
                            code += '<td class="align-middle">' + convert(value.gia_ban) + '</td>'
                            code += '<td class="align-middle text-center ">'
                            if (value.tinh_trang == 1) {
                                code += '<button data-idma="' + value.id +
                                    '" class="doitrangthai btn btn-success">Hiển Thị</button>'
                            } else {
                                code += '<button  data-idma="' + value.id +
                                    '" class="doitrangthai btn btn-danger">Tắt</button>'
                            }
                            code += '</td>'
                            code += '<td class="align-middle">' + value.ten_danh_muc + '</td>'
                            code += '<td class="align-middle m-1 text-center text-nowrap ">'
                            code +=
                                '<button data-idma="' + value.id +
                                '" class="update btn btn-info m-1" data-bs-toggle="modal" data-bs-target="#updateModal" >Cập Nhật</button>'
                            code +=
                                '<button data-idma="' + value.id +
                                '" class="delete btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletemodal">Xoá</button>'
                            code += '</td>'
                            code += '</tr>'
                        });
                        $('#listmonan tbody').html(code);
                    });
            }

            $("body").on('click', '.doitrangthai', function() {
                var id = $(this).data("idma");
                var payload = {
                    'id': id
                };
                axios
                    .post('/admin/mon-an/doi-trang-thai', payload)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.success(res.data.message, "Thông Báo")
                            loadData();
                        } else {
                            toastr.error(res.data.message, "Thông Báo!!")
                        }
                    });
            })

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
                    .post('/admin/mon-an/delete', payload)
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
                    .post('/admin/mon-an/edit', payload)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.success(res.data.message, 'Thông Báo !')
                            $('#edit_id').val(res.data.monan.id);
                            $('#edit_ten_mon_an').val(res.data.monan.ten_mon_an);
                            $('#edit_slug_mon_an').val(res.data.monan.slug_mon_an);
                            $('#edit_gia_ban').val(res.data.monan.gia_ban);
                            $('#edit_tinh_trang').val(res.data.monan.tinh_trang);
                            $('#edit_id_danh_muc').val(res.data.monan.id_danh_muc);
                        } else {
                            toastr.error(res.data.message, "Error");
                        }
                    });
            });
        });
    </script>
@endsection
