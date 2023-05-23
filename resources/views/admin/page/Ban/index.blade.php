@extends('admin.share.master')
@section('noi_dung')
    <div id="app">
        <div class="row">
            <div class="col-4">
                <div class="card border-primary border-bottom border-3 border-0">
                    <div class="card-header text-center bg-success">
                        <p class="card-text"><b>Thêm Mới Bàn</b></p>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label"><b>Tên Bàn</b></label>
                            <input v-model="add_ban.ten_ban" v-on:keyup="createSlug()" v-on:blur="CheckSlug()" type="text"
                                class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><b>Slug Bàn</b></label>
                            <input v-model="add_ban.slug_ban" type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><b>Khu Vực</b></label>
                            <select v-model="add_ban.id_khu_vuc" class="form-control">
                                <option value="0">Vui Lòng Thêm Khu Vực</option>
                                @foreach ($khuvuc as $key => $value)
                                    <option value="{{ $value->id }}">{{ $value->ten_khu_vuc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><b>Giá Mở Bán</b></label>
                            <input v-model="add_ban.gia_mo_ban" type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><b>Tiền Giờ</b></label>
                            <input v-model="add_ban.tien_gio" type="number" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><b>Tình Trạng</b></label>
                            <select v-model="add_ban.tinh_trang" class="form-control">
                                <option value="-1">Vui Lòng Thêm Tình Trạng</option>
                                <option value="1">Hiển THị</option>
                                <option value="0">Tạm Tắt</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button id="add" v-on:click="add()" class="btn btn-primary" style="margin-left: 76%">Thêm
                            Mới</button>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card border-primary border-bottom border-3 border-0">
                    <div class="card-header text-center bg-info">
                        <p class="card-text"><b>Danh Sách Bàn</b></p>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Tìm Kiếm </th>
                                    <th colspan="7" class="text-center"><input v-model="key_search" v-on:keyup.enter="search()" type="text" class="form-control"></th>
                                    <th><button v-on:click="search()" class="btn btn-primary">Tìm Kiếm <i class='bx bx-search'></i></button></th>

                                </tr>
                                <tr>
                                    <th class="text-center">
                                        <button v-on:click="destroyall()" class="btn btn-danger">Xoá Tất Cả </button>
                                    </th>
                                    <th class="text-center">Tên Bàn</th>
                                    <th class="text-center">Slug Bàn</th>
                                    <th class="text-center">ID_Khu Vực</th>
                                    <th class="text-center" v-on:click="sort()">Giá Mở Bàn
                                        <i v-if="order_by == 2" class="text-primary fa-solid fa-arrow-up"></i>
                                        <i v-else-if="order_by == 1" class="text-danger fa-solid fa-arrow-down"></i>
                                        <i v-else class="text-success fa-solid fa-spinner fa-pulse" style="animation: spin 2s infinite linear;"></i>
                                    </th>
                                    <th class="text-center" v-on:click="sort()">Tiền Giờ
                                        <i v-if="order_by == 2" class="text-primary fa-solid fa-arrow-up"></i>
                                        <i v-else-if="order_by == 1" class="text-danger fa-solid fa-arrow-down"></i>
                                        <i v-else class="text-success fa-solid fa-spinner fa-pulse" style="animation: spin 2s infinite linear;"></i>
                                    </th>
                                    <th class="text-center">Ngày Mở Bán</th>
                                    <th class="text-center">Tình Trạng</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value,key) in list_ban">
                                    <tr>
                                        <th class="text-center align-middle">
                                            <input  style="transform: scale(1.5);cursor: pointer;" type="checkbox" v-model="value.check" name="" id="">
                                        </th>
                                        <td class="align-middle">@{{ value.ten_ban }}</td>
                                        <td class="align-middle">@{{ value.slug_ban }}</td>
                                        <td class="align-middle">@{{ value.ten_khu_vuc }}</td>
                                        <td class="align-middle">@{{ number_format(value.gia_mo_ban) }}</td>
                                        <td class="align-middle">@{{ number_format(value.tien_gio) }}</td>
                                        <td class="align-middle">@{{ date_format(value.updated_at) }}</td>
                                        <td class="align-middle">
                                            <button class="btn btn-success" v-on:click="changeStatus(value)"
                                                v-if="value.tinh_trang == 1">Đang Bán</button>
                                            <button class="btn btn-danger" v-on:click="changeStatus(value)" v-else>Dừng
                                                Bán</button>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <button class="btn btn-info " data-bs-toggle="modal"
                                                data-bs-target="#updateModal" v-on:click="edit_ban=Object.assign({},value)">Cập Nhật</button>
                                            <button class="btn btn-danger " data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" v-on:click="del_ban=value"> Xoá</button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    {{-- MODEL-DELETE --}}
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xoá Bàn </h1>
                                    <div class="text-end">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    {{-- <input type="text" class="form-control" v-model="list_ban.id"> --}}
                                    <div class="alert alert-primary" role="alert">
                                        Bạn Chắc Chắng sẽ xoá :<b
                                            class="text-uppercase text-danger">@{{ del_ban.ten_ban }}</b> này!.việc này
                                        không thể thay đổi, hãy cẩnthận
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                        v-on:click="accpecDel()">Xác Nhận Xoá</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- MODEL-UPDATE --}}
                    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cập Nhật Thông Tin Bàn</h1>
                                    <div class="text-end">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" class="form-control" >
                                    <div class="mb-3">
                                        <label class="form-label"><b>Tên Bàn</b></label>
                                        <input v-model="edit_ban.ten_ban" type="text" v-on:blur="CheckSlugUpdate()" v-on:keyup="updateSlug()"
                                            class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><b>Slug Bàn</b></label>
                                        <input v-model="edit_ban.slug_ban" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><b>Khu Vực</b></label>
                                        <select v-model="edit_ban.id_khu_vuc" class="form-control">
                                            <option value="0">Vui Lòng Them Khu Vực</option>
                                            @foreach ($khuvuc as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->ten_khu_vuc }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><b>Giá Mở Bán</b></label>
                                        <input v-model="edit_ban.gia_mo_ban" type="number" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><b>Tiền Giờ</b></label>
                                        <input v-model="edit_ban.tien_gio" type="number" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><b>Tình Trạng</b></label>
                                        <select v-model="edit_ban.tinh_trang" class="form-control">
                                            <option value="1">Hiển THị</option>
                                            <option value="0">Tạm Tắt</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="accpecupdate()" id="accpectupdate" type="button" class="btn btn-success">Cập Nhật</button>
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
                add_ban: {
                    'ten_ban': '',
                    'slug_ban': '',
                    'id_khu_vuc': 0,
                    'tinh_trang': -1,

                },
                list_ban: [],
                edit_ban: {},
                del_ban: {},
                key_search:'',
                order_by:0,
            },
            created() {
                this.loadData();
            },
            methods: {
                destroyall(){
                    var payload ={
                        'list'  : this.list_ban
                    };
                    axios
                        .post('{{Route("destoyall-ban")}}', payload)
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
                sort(){
                    this.order_by = this.order_by+1;
                    if(this.order_by>2){
                        this.order_by = 0;
                    }
                     //quy ước :1 là tăng dần , 2 là giảm xuông , 0 là giảm dần theo id
                    if(this.order_by==1){
                        this.list_ban = this.list_ban.sort(function(a,b){
                            return a.gia_mo_ban - b.gia_mo_ban;

                        });
                    }else if(this.order_by == 2){
                         this.list_ban = this.list_ban.sort(function(a,b){
                            return b.gia_mo_ban - a.gia_mo_ban;

                        });
                    }else{
                        this.list_ban = this.list_ban.sort(function(a,b){
                            return a.id - b.id;
                        });
                    }
                },
                search(){
                    var payload = {
                        'key_search' :this.key_search,
                    }
                    axios
                    .post('/admin/ban/search',payload)
                    .then((res) => {
                            this.list_ban = res.data.list;
                        })
                        .catch((res)=>{
                            $.each(res.response.data.errors ,function(k,v){
                                toastr.error(v[0]);
                            });

                        });
                },
                add() {
                    $("#add").prop('disabled', true);
                    axios
                        .post('/admin/ban/create', this.add_ban)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, "Success");
                                this.loadData();
                                this.add_ban = {
                                    'ten_ban': '',
                                    'slug_ban': '',
                                    'id_khu_vuc': 0,
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
                            $.each(res.response.data.errors,function(k,v){
                                toastr.error(v[0]);
                            });
                            $("#add").removeAttr("disabled");
                        });
                },
                accpecDel() {
                    axios
                        .post('/admin/ban/delete', this.del_ban)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.massage, "Success");
                                this.loadData();
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.massage, "Error");
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.massage, "Warning");
                            }

                        });
                },
                accpecupdate() {
                    axios
                        .post('/admin/ban/update', this.edit_ban)
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
                            $.each(res.response.data.errors,function(k,v) {
                                toastr.error(v[0]);
                            });
                            $("#accpectupdate").removeAttr("disabled");
                        });

                },
                loadData() {
                    axios
                        .get('/admin/ban/data')
                        .then((res) => {
                            this.list_ban = res.data.list;

                        });
                },
                changeStatus(payload) {
                    axios
                        .post('/admin/ban/doi-trang-thai', payload)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.massage, "Thông Báo")
                                this.loadData();
                            } else {
                                toastr.error(res.data.massage, "Thông Báo!!")
                            }
                        });
                },
                number_format(number) {
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
                    var slug = this.toSlug(this.add_ban.ten_ban);
                    this.add_ban.slug_ban = slug;
                },
                updateSlug() {
                    var slug = this.toSlug(this.edit_ban.ten_ban);
                    this.edit_ban.slug_ban = slug;
                },
                CheckSlug() {
                    var payload = {
                        'slug_ban': this.add_ban.slug_ban,
                    };
                    axios.post('/admin/ban/check-slug', payload)
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
                CheckSlugUpdate(){
                    var payload = {
                        'slug_ban': this.edit_ban.slug_ban,
                    };
                    axios.post('/admin/ban/check-slug', payload)
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
                },

            },


        });
    </script>
@endsection
