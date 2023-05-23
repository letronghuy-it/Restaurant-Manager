@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-4">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <b>Thêm Mới Danh Mục</b>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label"> Tên Danh Mục</label>
                        <input v-model="addDM.ten_danh_muc" v-on:keyup="createSlug()" v-on:blur="CheckSlug()" type="text"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> Slug Danh Mục</label>
                        <input v-model="addDM.slug_danh_muc" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Tình Trạng</b></label>
                        <select v-model="addDM.tinh_trang" class="form-control">
                            <option value="-1"selected>Vui Lòng Thêm Tình Trạng</option>
                            <option value="1">Hiển THị</option>
                            <option value="0">Tạm Tắt</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button id="add" v-on:click="add" class="btn btn-primary">Thêm Mới</button>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <b>Thông Tin Danh Mục</b>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                                <th class="text-center align-middle">Tìm Kiếm</th>
                                <th colspan="4"><input type="text" v-model="key_search" v-on:keyup.enter="search()"
                                        class="form-control" name="" id=""></th>
                                <th><button v-on:click="search()" class="btn btn-primary">Tìm Kiếm<i class='bx bx-search'></i></button></th>
                            </tr>
                            <tr>
                                <th class="text-center">
                                    <button v-on:click="destroyall()" class="btn btn-danger">
                                        Xoá Tất Cả
                                    </button>
                                </th>
                                <th class="text-center">Tên Danh Mục</th>
                                <th class="text-center">Slug Danh Mục</th>
                                <th class="text-center">Ngày Mở Bán</th>
                                <th class="text-center">Tình Trạng</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value,key) in listDM" >
                                <tr>
                                    <th class="text-center align-middle">
                                        <input  style="transform: scale(1.5);" v-model="value.check" type="checkbox" name="" id="">
                                    </th>
                                    <td class="align-middle">@{{ value.ten_danh_muc }}</td>
                                    <td class="align-middle">@{{ value.slug_danh_muc }}</td>
                                    <td class="align-middle">@{{ date_format(value.updated_at) }}</td>
                                    <td class="align-middle text-center">
                                        <button class="btn btn-success" v-on:click="changeStatus(value)"
                                            v-if="value.tinh_trang == 1">Đang Bán</button>
                                        <button class="btn btn-danger" v-on:click="changeStatus(value)" v-else>Dừng
                                            Bán</button>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <button class="btn btn-info " data-bs-toggle="modal" data-bs-target="#updateModal"
                                            v-on:click="editDM=Object.assign({},value)">Cập Nhật</button>
                                        <button class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            v-on:click="delDM=value"> Xoá</button>
                                    </td>
                                </tr>
                            </template>

                        </tbody>
                    </table>
                    {{-- MODEL-DELETE --}}
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xoá Bàn </h1>
                                    <div class="text-end">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <input hidden type="text" class="form-control" id="id_delete">
                                    <div class="alert alert-primary" role="alert">
                                        Bạn Chắc Chắng sẽ xoá dữ liệu <b
                                            class="text-uppercase text-danger">@{{ delDM.ten_danh_muc }}</b>!.việc này không
                                        thể thay
                                        đổi, hãy cẩn thận!
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="accpectdelete()" type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal">Xác Nhận Xoá</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </template>

                    {{-- MODEL-UPPDATE --}}
                    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cập Nhật Danh Mục</h1>
                                    <div class="text-end">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <input type="text" hidden class="form-control" id="edit_id">
                                        <label class="form-label"> Tên Danh Mục</label>
                                        <input v-model="editDM.ten_danh_muc" v-on:keyup="updateSlug()"
                                            v-on:blur="CheckSlugUpdate()" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"> Slug Danh Mục</label>
                                        <input v-model="editDM.slug_danh_muc" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><b>Tình Trạng</b></label>
                                        <select v-model="editDM.tinh_trang" class="form-control">
                                            <option value="1">Hiển THị</option>
                                            <option value="0">Tạm Tắt</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="acceptupdate()" id="accpectupdate" type="button"
                                        class="btn btn-info">Cập Nhật</button>
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
                listDM: [],
                addDM: {
                    'ten_danh_muc': '',
                    'slug_danh_muc': '',
                    'tinh_trang': -1
                },
                delDM: {},
                editDM: {},
                key_search: '',
            },
            created() {
                this.loadData();
            },
            methods: {
                destroyall(){
                    var payload = {
                        'list' : this.listDM,
                    };
                    axios
                        .post('{{Route("destroyall-DanhMuc")}}', payload)
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
                }
                ,
                search() {
                    var payload = {
                        'key_search': this.key_search
                    };
                    axios
                        .post('/admin/danh-muc/search', payload)
                        .then((res) => {
                            this.listDM = res.data.list;
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },

                add() {
                    $("#add").prop('disabled', true);
                    axios
                        .post('/admin/danh-muc/create', this.addDM)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, "Success");
                                this.loadData();
                                this.addDM = {
                                    'ten_danh_muc': '',
                                    'slug_danh_muc': '',
                                    'tinh_trang': -1
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
                        .post('/admin/danh-muc/delete', this.delDM)
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
                acceptupdate() {
                    axios
                        .post('/admin/danh-muc/update', this.editDM)
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
                            $("#accpectupdate").removeAttr("disabled");
                        });
                },

                loadData() {
                    axios
                        .get('/admin/danh-muc/data')
                        .then((res) => {
                            this.listDM = res.data.list;
                        });
                },
                changeStatus(payload) {
                    axios
                        .post('/admin/danh-muc/doi-trang-thai', payload)
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
                    var slug = this.toSlug(this.addDM.ten_danh_muc);
                    this.addDM.slug_danh_muc = slug;
                },
                updateSlug() {
                    var slug = this.toSlug(this.editDM.ten_danh_muc);
                    this.editDM.slug_danh_muc = slug;
                },
                CheckSlug() {
                    var payload = {
                        'slug_danh_muc': this.addDM.slug_danh_muc
                    };
                    axios
                        .post('/admin/danh-muc/check-slug', payload)
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
                        'slug_danh_muc': this.editDM.slug_danh_muc
                    };
                    axios
                        .post('/admin/danh-muc/check-slug', payload)
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
0
