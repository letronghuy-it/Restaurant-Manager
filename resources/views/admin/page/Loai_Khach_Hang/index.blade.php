
@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-5">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <b>Thêm Mới Loại Khách Hàng</b>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label"> Tên Loại Khách Hàng</label>
                        <input v-model="add.ten_loai_khach"   type="text"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> Phần Trăm Giảm Giá </label>
                        <input v-model="add.phan_tram_giam" type="number" class="form-control">
                    </div>
                    <div class="mb-3">
                        <div class="card">
                            <div class="card-body table-responsive" style="max-height: 720px">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tìm Kiếm </th>
                                            <th colspan="2">
                                                <input v-model="search_mon" v-on:keyup.enter="searchMon()"
                                                    class="form-control" type="text"
                                                    placeholder="Nhập Nội Dung Tìm Kiếm.....">
                                            </th>
                                            <th><button v-on:click="searchMon()" class="btn btn-primary">Tìm Kiếm <i
                                                        class='bx bx-search'></i></button></th>
                                        </tr>
                                        <tr>
                                            <th class="text-center middle-align">#</th>
                                            <th class="text-center middle-align">Tên Món</th>
                                            <th class="text-center middle-align" >
                                                Đơn Giá
                                                <i v-if="order_by == 2"
                                                    class="text-primary fa-solid fa-arrow-up"></i>
                                                <i v-else-if="order_by == 1"
                                                    class="text-danger fa-solid fa-arrow-down"></i>
                                                <i v-else class="text-success fa-solid fa-spinner fa-pulse"
                                                    style="animation: spin 2s infinite linear;"></i>
                                            </th>
                                            <th class="text-center middle-align">ĐVT</th>


                                        </tr>
                                    </thead>

                                    <tbody>
                                        <template v-for="(value,key) in list_mon">
                                            <tr>
                                                <th class="text-center">
                                                    <input v-model="value.check" type="checkbox" name="" id="">
                                                </th>
                                                <td class="text-center">@{{ value.ten_mon_an }}</td>
                                                <td class="text-center">@{{ number_format(value.gia_ban) }}</td>
                                                <td class="text-center">@{{ value.DVT }}</td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button id="add" v-on:click="addnew()" class="btn btn-primary">Thêm Mới</button>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <b>Thông Tin Loại Khách Hàng</b>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                                <th class="text-center align-middle">Tìm Kiếm</th>
                                <th colspan="3"><input type="text" v-model="key_search" v-on:keyup.enter="search()"
                                        class="form-control" name="" id=""></th>
                                <th><button v-on:click="search()" class="btn btn-primary">Tìm Kiếm<i class='bx bx-search'></i></button></th>
                            </tr>
                            <tr>
                                <th class="text-center">
                                        <button v-on:click="destroyall()" class="btn btn-danger"> Xoá Tất Cả</button>

                                </th>
                                <th class="text-center">Tên Loại Khách Hàng</th>
                                <th class="text-center" v-on:click="sort()">Phần Trăm Giảm Giá
                                    <i v-if="order_by == 2" class="text-primary fa-solid fa-arrow-up"></i>
                                    <i v-else-if="order_by == 1" class="text-danger fa-solid fa-arrow-down"></i>
                                    <i v-else class="text-success fa-solid fa-spinner fa-pulse" style="animation: spin 2s infinite linear;"></i>
                                </th>
                                <th class="text-center">List Món Tặng</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value,key) in list" >
                                <tr>
                                    <th class="text-center align-middle">
                                        <input type="checkbox" v-model="value.check" style="transform: scale(1.5);cursor: pointer;" name="" id="">
                                    </th>
                                    <td class="align-middle">@{{ value.ten_loai_khach }}</td>
                                    <td class="align-middle">@{{ value.phan_tram_giam }}</td>
                                    <td class="align-middle">@{{ value.ten_mon_an}}</td>
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
                </div>
                    {{-- MODEL-DELETE --}}
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Xoá Loại Khách Hàng </h1>
                                <div class="text-end">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-primary" role="alert">
                                    Bạn Chắc Chắng sẽ xoá dữ liệu <b
                                        class="text-uppercase text-danger">@{{ del.ten_loai_khach }}</b>!.việc này không
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
                                    <label class="form-label"> Tên Loại Khách</label>
                                    <input v-model="edit.ten_loai_khach"
                                        v-on:blur="CheckSlugUpdate()" type="text" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"> Phần Trăm Giảm</label>
                                    <input v-model="edit.phan_tram_giam" type="text" class="form-control">
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
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                list: [],
                add: { },
                del:{},
                edit: {},
                key_search: '',
                search_mon:'',
                order_by:0,
                list_mon:[],
            },
            created() {
                this.loadData();
                this.loadDataMonAn();
            },
            methods: {
                destroyall(){
                    var payload ={
                        'list'  : this.list
                    };
                    axios
                    .post('{{Route("destoyall-loai-khach-hang")}}', payload)
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
                loadDataMonAn() {
                    axios
                        .get('/admin/mon-an/data')
                        .then((res) => {
                            this.list_mon = res.data.list;

                        });
                },
                searchMon() {
                    var payload = {
                        'key_search': this.search_mon,
                    }
                    axios
                        .post('/admin/mon-an/search', payload)
                        .then((res) => {
                            this.list_mon = res.data.list;
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });

                        });
                },
                sort(){
                    this.order_by = this.order_by+1
                    if(this.order_by >2){
                        this.order_by =0;
                    }
                    //quy ước :1 là tăng dần , 2 là giảm xuông , 0 là giảm dần theo id
                    if(this.order_by==1){
                        this.list=this.list.sort(function(a,b){
                          return a.phan_tram_giam - b.phan_tram_giam;
                        });
                    }else if(this.order_by==2){
                        this.list=this.list.sort(function(a,b){
                          return b.phan_tram_giam - a.phan_tram_giam;
                        });
                    }else{
                        this.list=this.list.sort(function(a,b){
                          return a.id - b.id;
                        });
                    }
                },
                search(){
                    var payload = {
                        'key_search': this.key_search
                    };
                    axios
                        .post('/admin/loai-khach-hang/search', payload)
                        .then((res) => {
                            this.list = res.data.list;
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                addnew() {
                    $("#add").prop('disabled', true);
                    var payload={
                        'ten_loai_khach' : this.add.ten_loai_khach,
                        'phan_tram_giam' :this.add.phan_tram_giam,
                        'list_mon'       :this.list_mon,

                    }
                    axios
                        .post('/admin/loai-khach-hang/create', payload)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, "Success");
                                this.loadData();
                                this.loadDataMonAn();
                                this.add= {
                                    'ten_loai_khach':'',
                                    'phan_tram_giam':'',
                                    'list_mon_tang': '',
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
                        .post('/admin/loai-khach-hang/delete',this.del)
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
                acceptupdate() {
                    axios
                        .post('/admin/loai-khach-hang/update', this.edit)
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
                        .get('/admin/loai-khach-hang/data')
                        .then((res) => {
                            this.list = res.data.list;
                        });
                },
                CheckSlugUpdate() {
                    var payload = {
                        'ten_loai_khach': this.edit.ten_loai_khach
                    };
                    axios
                        .post('/admin/loai-khach-hang/ten-loai-khach', payload)
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
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                            $("#accpectupdate").removeAttr("disabled");
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


