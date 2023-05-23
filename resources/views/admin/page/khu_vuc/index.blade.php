@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-5">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <p class="card-text">Thêm Mới Khu Vực</p>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Tên Khu Vưc</label>
                        <input v-model="add_kv.ten_khu_vuc" v-on:keyup="createSlug()" v-on:blur="CheckSlug()" type="text"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">slug_khu_vuc</label>
                        <input v-model="add_kv.slug_khu_vuc" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tình Trạng </label>
                        <select v-model="add_kv.tinh_trang" class="form-control">
                            <option value="-1">Vui Lòng Nhập Tên Khu Vực</option>
                            <option value="1">Hiển THị</option>
                            <option value="0">Tạm Tắt</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button id="add" v-on:click="add()" class="btn btn-primary">Thêm Mới</button>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <b>Danh Sách Khu Vực</b>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Tên Khu Vực</th>
                                <th class="text-center">Slug Khu Vực</th>
                                <th class="text-center">Ngày Mở Khu Vực</th>
                                <th class="text-center">Tình Trạng</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value,key) in list">
                                <tr>
                                    <th class="text-center align-middle">@{{ key + 1 }}</th>
                                    <td class="align-middle">@{{ value.ten_khu_vuc }}</td>
                                    <td class="align-middle">@{{ value.slug_khu_vuc }}</td>
                                    <td class="align-middle">@{{ date_format(value.updated_at) }}</td>
                                    <td class="align-middle">
                                        <button class="btn btn-success" v-on:click="changeStatus(value)"
                                            v-if="value.tinh_trang == 1">Đang Bán</button>
                                        <button class="btn btn-danger" v-on:click="changeStatus(value)" v-else>Dừng
                                            Bán</button>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <button class="btn btn-info " data-bs-toggle="modal" data-bs-target="#updateModal"
                                            v-on:click="edit=Object.assign({},value)">Cập Nhật</button>
                                        <button class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            v-on:click="del=value"> Xoá</button>
                                    </td>
                                </tr>
                            </template>

                        </tbody>
                    </table>
                    {{-- Modal DELETE --}}
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                    <div class="text-end">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <input hidden type="text" class="form-control" id="id_delete">
                                    <div class="alert alert-primary" role="alert">
                                        <b>Bạn Chắc Chắng sẽ xoá dữ liệu <b
                                                class="text-uppercase text-danger">@{{ del.ten_khu_vuc }}!</b>.việc này
                                            không thể thay đổi, hãy cẩn thận</b>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="accpecDel()" type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal">Xác Nhận Xoá</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Modal UPDATE --}}
                    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cập Nhật</h1>
                                    <div class="text-end">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <input type="text" hidden class="form-control" id="edit_id">
                                    <div class="mb-3">
                                        <label class="form-label">Tên Khu Vưc</label>
                                        <input type="text" class="form-control" v-on:keyup="updateSlug()"
                                            v-on:blur="CheckSlugUpdate()" v-model="edit.ten_khu_vuc">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Slug Khu Vực</label>
                                        <input type="text" class="form-control" v-model="edit.slug_khu_vuc">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tình Trạng </label>
                                        <select v-model="edit.tinh_trang" class="form-control">
                                            <option value="1">Hiển THị</option>
                                            <option value="0">Tạm Tắt</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="accpecupdate()" id="accpectupdate" type="button"
                                        class="btn btn-success">Cập
                                        nhật</button>
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

            $("#accept_update").click(function(){
               var id           = $("#edit_id").val();
               var ten_khu_vuc  = $("#edit_ten_khu_vuc").val();
               var slug_khu_vuc = $("#edit_slug_khu_vuc").val();
               var tinh_trang   = $("#edit_tinh_trang").val();

               var payload = {
                'id'            :id,
                'ten_khu_vuc'   :ten_khu_vuc,
                'slug_khu_vuc'  :slug_khu_vuc,
                'tinh_trang'    :tinh_trang,
               };
               axios
                    .post('/admin/khu-vuc/update', payload)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.success(res.data.message, "success");
                            $('#updateModal').modal('hide');
                            loadData();
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, "Error");
                        }
                    });

            });

            $("#edit_ten_khu_vuc").blur(function() {
                var slug = toSlug($(this).val());
                var payload = {
                    'slug_khu_vuc': slug,
                    'id': $("#edit_id").val()
                };
                axios.post('/admin/danh-muc/check-slug', payload)
                    .then((res) => {
                        if (res.data.status == 1) {
                            toastr.success(res.data.message, "Success");
                            $("#accept_update").removeAttr("disabled");
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, "Error");
                            $("#accept_update").prop('disabled', true);
                        } else if (res.data.status == 2) {
                            toastr.warning(res.data.message, "Warning");
                        }
                    });
            });

            $('#edit_ten_khu_vuc').keyup(function() {
                $("#accept_update").prop('disabled', true);
                var slug = toSlug($(this).val());
                $("#edit_slug_khu_vuc").val(slug);
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
            $("#add_ten_khu_vuc").blur(function() {
                var slug = toSlug($(this).val());
                var payload = {
                    'slug_khu_vuc': slug
                };
                axios
                    .post('/admin/khu-vuc/check-slug', payload)
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

            $('#add_ten_khu_vuc').keyup(function() {
                var slug = toSlug($(this).val());
                $("#add_slug_khu_vuc").val(slug);
            })
            $("#add").click(function() {
                if ($("#add_ten_khu_vuc").val() == '' || $("#add_slug_khu_vuc").val() == '' || $(
                        "#add_tinh_trang").val() == '-1') {
                    toastr.warning("Vui lòng nhập đầy đủ thông tin", "Warning");
                    return; // dừng hàm nếu thông tin chưa đầy đủ
                }
                $("#add").prop('disabled', true);
                var ten_khu_vuc = $("#add_ten_khu_vuc").val();
                var slug_khu_vuc = $("#add_slug_khu_vuc").val();
                var tinh_trang = $("#add_tinh_trang").val();
                var payload = {
                    'ten_khu_vuc': ten_khu_vuc,
                    'slug_khu_vuc': slug_khu_vuc,
                    'tinh_trang': tinh_trang
                };
                axios
                    .post('/admin/khu-vuc/create', payload)
                    .then((res) => {
                        if (res.data.status == 1) {
                            toastr.success(res.data.message, "Success");
                            loadData();
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, "Error");
                        } else if (res.data.status == 2) {
                            toastr.warning(res.data.message, "Warning");
                        }
                        $("#add_ten_khu_vuc").val('');
                        $("#add_slug_khu_vuc").val('');
                        $("#add_tinh_trang").val('-1');
                        $("#add").removeAttr("disabled");
                    });
            })

            loadData();
            // Nhiệm Vụ là truy cập link => /admin/khu - vuc / data bằng method get để lấy dữ liệu
            function loadData() {
                axios
                    .get('/admin/khu-vuc/data')
                    .then((res) => {
                        var list = res.data.list;
                        var code = "";
                        $.each(list, function(key, value) {
                            code += '<tr>'
                            code += ' <th class="text-center align-middle">' + (key + 1) + '</th>'
                            code += '<td class="align-middle">' + value.ten_khu_vuc + '</td>'
                            code += '<td class="align-middle">' + value.slug_khu_vuc + '</td>'
                            code += ' <td class="align-middle ">'
                            if (value.tinh_trang) {
                                code += '<button data-idkv="' + value.id +
                                    '" class="doi-trang-thai btn btn-success">Hiển Thị</button>'
                            } else {
                                code += '<button data-idkv="' + value.id +
                                    '" class="doi-trang-thai btn btn-warning">Tạm Tắt</button>'
                            }
                            code += '</td>'
                            code += '<td class="align-middle text-center ">'
                            code += '<button data-idkv="' + value.id +
                                '"class="update btn btn-info m-1" data-bs-toggle="modal" data-bs-target="#updateModal">Cập Nhật</button>'
                            code += '<button data-idkv="' + value.id +
                                '"class="delete btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" >Xoá</button>'
                            code += '</td>'
                            code += '</tr>'
                        });
                        $("#listKhuVuc tbody").html(code)
                    });
            }
            // Đổi Trạng Thái
            $("body").on('click', '.doi-trang-thai', function() {
                var id = $(this).data("idkv");
                var payload = {
                    'id': id
                };
                axios
                    .post('/admin/khu-vuc/doi-trang-thai', payload)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.success(res.data.message, "Success");
                            loadData();
                        } else {
                            toastr.error(res.data.message, "Error");
                        }
                    });

            })

            //Delete Khu Vực
            $("body").on('click', '.delete', function() {
                var id = $(this).data('idkv');
                $("#id_delete").val(id);

            })

            $("body").on('click', '#accpect_delete', function() {
                var id = $('#id_delete').val();
                var payload = {
                    'id': id
                };
                axios
                    .post('/admin/khu-vuc/delete', payload)
                    .then((res) => {
                        if (res.data.status == 1) {
                            toastr.success(res.data.message, "Success");
                            loadData();
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, "Error");
                        } else if (res.data.status == 2) {
                            toastr.warning(res.data.message, "Warning");
                        }
                    });
            });
            //edit

            $("body").on('click', '.update', function() {
                var id = $(this).data('idkv');
                var payload = {
                    'id': id
                };
                axios
                    .post('/admin/khu-vuc/edit', payload)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.warning(res.data.message, "Warning");
                            $("#edit_id").val(res.data.KhuVuc.id);
                            $("#edit_ten_khu_vuc").val(res.data.KhuVuc.ten_khu_vuc);
                            $("#edit_slug_khu_vuc").val(res.data.KhuVuc.ten_khu_vuc);
                            $("#edit_tinh_trang").val(res.data.KhuVuc.tinh_trang);
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, "Error");
                        }
                    });
            })
        });
    </script> --}}
    <script>
        new Vue({
            el: '#app',
            data: {
                list: [],
                add_kv: {
                    'ten_khu_vuc': '',
                    'slug_khu_vuc': '',
                    'tinh_trang': -1
                },
                edit: {},
                del: {},
            },
            created() {
                this.loadData();
            },
            methods: {
                add() {
                    $("#add").prop('disabled', true);
                    axios
                        .post('/admin/khu-vuc/create', this.add_kv)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, "Success");
                                this.loadData();
                                this.add_kv = {
                                    'ten_khu_vuc': '',
                                    'slug_khu_vuc': '',
                                    'tinh_trang': -1,
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
                accpecDel() {
                    axios
                        .post('/admin/khu-vuc/delete', this.del)
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
                accpecupdate() {
                    axios
                        .post('/admin/khu-vuc/update', this.edit)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, "success");
                                $('#updateModal').modal('hide');
                                this.loadData();
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, "Error");
                            }
                        })
                        .catch((res)=>{
                            $.each(res.response.data.errors,function(k,v){
                                toastr.error(v[0]);
                            })
                            $("#accpectupdate").removeAttr("disabled");
                        })
                },
                loadData() {
                    axios
                        .get('/admin/khu-vuc/data')
                        .then((res) => {
                            this.list = res.data.list;
                        });
                },
                changeStatus(payload) {
                    axios
                        .post('/admin/khu-vuc/doi-trang-thai', payload)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.massage, "Thông Báo")
                                this.loadData();
                            } else {
                                toastr.error(res.data.massage, "Thông Báo!!")
                            }
                        });
                },
                date_format(now) {
                    return moment(now).format('hh:mm:ss MM/DD/YYYY ');
                },
                toSlug(str) {
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
                },
                createSlug() {
                    var slug = this.toSlug(this.add_kv.ten_khu_vuc);
                    this.add_kv.slug_khu_vuc = slug;
                },
                updateSlug() {
                    var slug = this.toSlug(this.edit.ten_khu_vuc);
                    this.edit.slug_khu_vuc = slug;
                },
                CheckSlug() {
                    var payload = {
                        'slug_khu_vuc': this.add_kv.slug_khu_vuc
                    };
                    axios
                        .post('/admin/khu-vuc/check-slug', payload)
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
                CheckSlugUpdate() {
                    var payload = {
                        'slug_khu_vuc': this.edit.slug_khu_vuc
                    };
                    axios
                        .post('/admin/khu-vuc/check-slug', payload)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, "Success");
                                $("#accpectupdate").removeAttr("disabled");
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, "Error");
                                $("#accpectupdate").prop('disabled', true);
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message, "Warning");
                            }
                        });
                }
            },

        });
    </script>
@endsection
