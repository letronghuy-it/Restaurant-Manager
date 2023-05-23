@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-4">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <b>Nhập Thông Tin Món Ăn</b>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Tên Món Ăn</label>
                        <input v-model="add_mon_an.ten_mon_an" v-on:blur="checkSlug()" v-on:keyup="createSlug()"
                            type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug Món Ăn</label>
                        <input v-model="add_mon_an.slug_mon_an" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giá Bán</label>
                        <input v-model="add_mon_an.gia_ban" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hình Ảnh</label>
                        <input type="file" ref="file" v-on:change="updatefile()" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Tình Trạng</b></label>
                        <select v-model="add_mon_an.tinh_trang" class="form-control">
                            <option value="-1">Vui Lòng Chọn Tình Trạng</option>
                            <option value="1">Hiển THị</option>
                            <option value="0">Tạm Tắt</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Danh Mục</label>
                        <select v-model="add_mon_an.id_danh_muc" class="form-control">
                            <option value="2">Vui Lòng Thêm Danh Mục Món Ăn</option>
                            @foreach ($danhmuc as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->ten_danh_muc }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="card-footer text-end">
                    <button id="add" v-on:click="addMonAn()" class="btn btn-primary">Thêm Mới</button>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <b>Danh Sách Món Ăn</b>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                                <th class="text-center">Tìm Kiếm</th>
                                <th colspan="5"><input v-model="key_search" v-on:keyup.enter="search()" type="text"
                                        name="" id="" class="form-control"></th>
                                <th><button v-on:click="search()" class="btn btn-primary">Tìm Kiếm</button></th>
                            </tr>
                            <tr>
                                <th class="text-center">
                                    <button v-on:click="destroyall()" class="btn btn-danger">
                                        Xoá Tất Cả
                                    </button>
                                </th>
                                <th class="text-center">hình Ảnh</th>
                                <th class="text-center">Tên Món Ăn</th>
                                <th class="text-center" v-on:click="sort()">Giá Bán
                                    <i v-if="order_by == 2" class="text-primary fa-solid fa-arrow-up"></i>
                                    <i v-else-if="order_by == 1" class="text-danger fa-solid fa-arrow-down"></i>
                                    <i v-else class="text-success fa-solid fa-spinner fa-pulse"
                                        style="animation: spin 2s infinite linear;"></i>
                                </th>
                                <th class="text-center">Ngày Mở Bán</th>
                                <th class="text-center">Tình Trạng</th>
                                <th class="text-center">Danh Mục</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value,key) in list">
                                <tr>
                                    <th class="text-center align-middle">
                                        <input type="checkbox" v-model="value.check"
                                            style="transform: scale(1.5);cursor: pointer;" name="" id="">
                                    </th>
                                    <td class="text-center align-middle ">
                                        <img v-bind:src="'/hinh-mon-an/' + value.hinh_anh" class="img-fluid">
                                    </td>
                                    <td class="align-middle">@{{ value.ten_mon_an }}</td>
                                    <td class="align-middle text-center">@{{ number_fomat(value.gia_ban) }}</td>
                                    <td class="align-middle text-center">@{{ date_format(value.updated_at) }}</td>
                                    <td class="align-middle text-center">
                                        <button v-on:click="changeStatus(value)" v-if="value.tinh_trang == 0"
                                            class="btn btn-danger">Dừng Bán</button>
                                        <button v-on:click="changeStatus(value)" v-else class="btn btn-success">Đang
                                            Bán</button>
                                    </td>
                                    <td class="align-middle text-center"> @{{ value.ten_danh_muc }}
                                    </td>
                                    <td class="text-center text-nowrap align-middle">
                                        <button class="btn btn-info " data-bs-toggle="modal"data-bs-target="#updateModal"
                                            v-on:click="edit_mon_an= Object.assign({},value)">Cập Nhật</button>
                                        <button class="btn btn-danger " data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" v-on:click="del_mon_an=value"> Xoá</button>
                                    </td>
                                </tr>
                            </template>
                    </table>
                </div>
            </div>

            {{-- Model Delete --}}
            <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
                                <b>Bạn Chắc Chắng sẽ xoá Món :<b class="text-uppercase text-danger">@{{ del_mon_an.ten_mon_an }}
                                    </b> việc này không thể thay đổi, hãy cẩn thận </b>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button v-on:click="accpectDel()" type="button" class="btn btn-danger"
                                data-bs-dismiss="modal">Xác
                                Nhận Xoá</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Model Update --}}
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
                            <div class="mb-3">
                                <label class="form-label">Tên Món Ăn</label>
                                <input v-model="edit_mon_an.ten_mon_an" v-on:keyup="updateSlug()"
                                    v-on:blur="checkupdateSlug()" type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Slug Món Ăn</label>
                                <input v-model="edit_mon_an.slug_mon_an" type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Giá Bán</label>
                                <input v-model="edit_mon_an.gia_ban" type="number" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Hình Ảnh</label>
                                <input  type="file" ref="file" v-on:change="updatefile()" class="form-control">
                                <input hidden v-model="edit_mon_an.hinh_anh" type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><b>Tình Trạng</b></label>
                                <select v-model="edit_mon_an.tinh_trang" class="form-control">
                                    <option value="1">Hiển THị</option>
                                    <option value="0">Tạm Tắt</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Danh Mục</label>
                                <select v-model="edit_mon_an.id_danh_muc" class="form-control">
                                    <option value="0">Vui Lòng Thêm Danh Mục Món Ăn</option>
                                    @foreach ($danhmuc as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->ten_danh_muc }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button v-on:click="accpetupdate()" id="accpetupdate" type="button"
                                class="btn btn-primary">Cập Nhật</button>
                        </div>
                    </div>
                </div>
            </div>
            </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                list: [],
                add_mon_an: {
                    'ten_mon_an': '',
                    'gia_ban': '',
                    'slug_mon_an': '',
                    'tinh_trang': -1,
                    'id_danh_muc': 2
                },
                del_mon_an: {},
                edit_mon_an: {},
                key_search: '',
                order_by: 0,
                file: '',
            },
            created() {
                this.loadData();
            },
            methods: {
                updatefile() {
                    this.file = this.$refs.file.files[0]
                    console.log(this.file);
                },
                destroyall() {
                    var payload = {
                        'list_mon': this.list,
                    };
                    axios
                        .post('{{ Route('destroyall') }}', payload)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, "Success");
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
                        });
                },
                sort() {
                    this.order_by = this.order_by + 1;
                    if (this.order_by > 2) {
                        this.order_by = 0;
                    }
                    // quy ước :1 là tăng dần, 2 là giảm xuống, 0 là giảm dần theo id
                    if (this.order_by == 1) {
                        this.list = this.list.sort(function(a, b) {
                            return a.gia_ban - b.gia_ban;
                        });
                    } else if (this.order_by == 2) {
                        this.list = this.list.sort(function(a, b) {
                            return b.gia_ban - a.gia_ban;
                        });
                    } else {
                        this.list = this.list.sort(function(a, b) {
                            return a.id - b.id;
                        });
                    }
                },
                search() {
                    var payload = {
                        'key_search': this.key_search
                    };
                    axios
                        .post('/admin/mon-an/search', payload)
                        .then((res) => {
                            this.list = res.data.list;
                        })

                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });

                        });

                },
                loadData() {
                    axios
                        .get('/admin/mon-an/data')
                        .then((res) => {
                            this.list = res.data.list;
                        });
                },
                changeStatus(xxx) {
                    axios
                        .post('/admin/mon-an/doi-trang-thai', xxx)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, "Thông Báo")
                                this.loadData();
                            } else {
                                toastr.error(res.data.message, "Thông Báo!!")
                            }
                        });
                },
                number_fomat(number) {
                    return new Intl.NumberFormat('vi-VI', {
                        style: 'currency',
                        currency: 'VND'
                    }).format(number);

                },
                date_format(now) {
                    return moment(now).format('HH:mm:ss DD/MM/yyyy');
                },
                toSlug(str) {
                    str = str.toLowerCase();
                    str = str
                        .normalize('NFD') // chuyển chuỗi sang unicode tổ hợp
                        .replace(/[\u0300-\u036f]/g, ''); // xóa các ký tự dấu sau khi tách tổ hợp
                    str = str.replace(/[đĐ]/g, 'd');
                    str = str.replace(/([^0-9a-z-\s])/g, '');
                    str = str.replace(/(\s+)/g, '-');
                    str = str.replace(/-+/g, '-');
                    str = str.replace(/^-+|-+$/g, '');
                    return str;
                },
                createSlug() {
                    var slug = this.toSlug(this.add_mon_an.ten_mon_an);
                    this.add_mon_an.slug_mon_an = slug;
                },
                checkSlug() {
                    var payload = {
                        'slug_mon_an': this.add_mon_an.slug_mon_an
                    };
                    axios
                        .post('/admin/mon-an/check-slug', payload)
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
                checkupdateSlug() {
                    var payload = {
                        'slug_mon_an': this.edit_mon_an.slug_mon_an
                    };
                    axios
                        .post('/admin/mon-an/check-slug', payload)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, "Success");
                                $("#accpetupdate").removeAttr("disabled");
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, "Error");
                                $("#accpetupdate").prop('disabled', true);
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message, "Warning");
                            }
                        });

                },
                updateSlug() {
                    var slug = this.toSlug(this.edit_mon_an.ten_mon_an);
                    this.edit_mon_an.slug_mon_an = slug;
                },
                addMonAn() {
                    $("#add").prop('disabled', true);
                    var formData =new FormData();
                    formData.append('hinh_anh',this.file);
                    formData.append('ten_mon_an',this.add_mon_an.ten_mon_an);
                    formData.append('slug_mon_an',this.add_mon_an.slug_mon_an);
                    formData.append('gia_ban',this.add_mon_an.gia_ban);
                    formData.append('tinh_trang',this.add_mon_an.tinh_trang);
                    formData.append('id_danh_muc',this.add_mon_an.id_danh_muc);

                    axios
                    .post('/admin/mon-an/create', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })

                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, "Success");
                                this.loadData();
                                this.add_mon_an = {'ten_mon_an' : '', 'slug_mon_an' : '', 'id_danh_muc' : 0, 'gia_ban' : '', 'tinh_trang' : 1};
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
                            })
                            $("#add").removeAttr("disabled");
                        });
                },
                accpectDel() {
                    axios
                        .post('/admin/mon-an/delete', this.del_mon_an)
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
                accpetupdate() {
                    var formData =new FormData();
                    formData.append('hinh_anh',this.file);
                    formData.append('hinh_anh_old',this.edit_mon_an.hinh_anh);
                    formData.append('id',this.edit_mon_an.id);
                    formData.append('ten_mon_an',this.edit_mon_an.ten_mon_an);
                    formData.append('slug_mon_an',this.edit_mon_an.slug_mon_an);
                    formData.append('gia_ban',this.edit_mon_an.gia_ban);
                    formData.append('tinh_trang',this.edit_mon_an.tinh_trang);
                    formData.append('id_danh_muc',this.edit_mon_an.id_danh_muc);
                    axios
                        .post('/admin/mon-an/update', formData,{
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, "success");
                                $('#updateModal').modal('hide');
                                this.loadData();
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, "Error");
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                            $("#accpetupdate").removeAttr("disabled");
                        });

                },

            }
        })
    </script>
@endsection
