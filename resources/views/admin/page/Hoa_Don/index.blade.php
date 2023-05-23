@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <template v-for="(value,key) in list_ban" v-if="value.tinh_trang==1">
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body text-center" style="cursor: pointer;">
                        <template v-if="value.trang_thai==0">
                            <p class="text-upercase"><b>Bàn @{{ value.ten_ban }}</b></p>
                        </template>

                        <template v-if="value.trang_thai==1">
                            <p class="text-upercase text-success"><b>Bàn @{{ value.ten_ban }}</b></p>
                        </template>

                        <template v-if="value.trang_thai==2">
                            <p class="text-upercase text-warning"><b>Bàn @{{ value.ten_ban }}</b></p>
                        </template>

                        <div v-on:click="getidHoaDon(value.id)">
                            <template v-if="value.trang_thai==0">
                                <img src="/hinh_anh/ban_trong2.png" data-bs-toggle="modal" data-bs-target="#ChiTietModel"
                                    v-on:click="OpenTable(value.id)" class="img-fluid" alt="Image 1">
                            </template>
                            <template v-if="value.trang_thai==1 ">
                                <img src="/hinh_anh/dang_hoat_dong.png" data-bs-toggle="modal"
                                    data-bs-target="#ChiTietModel" class="img-fluid" alt="Image 2">
                            </template>
                            <template v-if="value.trang_thai==2 ">
                                <img src="/hinh_anh/dang_tinh_tien.png" data-bs-toggle="modal"
                                    data-bs-target="#ChiTietModel" class="img-fluid" alt="Image 3">
                            </template>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <div class="btn-group" role="group" aria-label="Bacsic example">
                            <div v-if="value.trang_thai > 0" class="btn-group">
                                <button type="button" class="btn btn-outline-secondary">ACTION</button>
                                <button type="button"
                                    class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split"
                                    data-bs-toggle="dropdown" aria-expanded="false"> <span class="visually-hidden">Toggle
                                        Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Another action</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Something else here</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">Separated link</a>
                                    </li>
                                </ul>
                            </div>
                            <div v-else class="btn-group">
                                <button type="button" v-on:click="OpenTable(value.id)"
                                    class="btn btn-outline-secondary">Open!s</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </template>
        <div class="modal fade" id="ChiTietModel" tabindex="-1" aria-labelledby="ChiTietModelLabel" aria-hidden="true">
            <div class="modal-dialog "  style="max-width:100%; margin:0 50px   ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="ChiTietModelLabel">Chi Tiết Bán Hàng @{{ add_mon.id_hoa_don_ban_hang }}</h1>
                        <button type="button" class="btn-close" v-on:click="trang_thai=0" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row" v-if="trang_thai==0">
                            <div class="col-5">
                                <div class="card">
                                    <div class="card-body table-responsive" style="max-height: 720px">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Tìm Kiếm </th>
                                                    <th colspan="4">
                                                        <input v-model="key_search" v-on:keyup.enter="search()"
                                                            class="form-control" type="text"
                                                            placeholder="Nhập Nội Dung Tìm Kiếm.....">
                                                    </th>
                                                    <th><button v-on:click="search()" class="btn btn-primary">Tìm Kiếm <i
                                                                class='bx bx-search'></i></button></th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center middle-align">#</th>
                                                    <th class="text-center middle-align">Hình Ảnh</th>
                                                    <th class="text-center middle-align">Tên Món</th>
                                                    <th class="text-center middle-align" v-on:click="sort()">
                                                        Đơn Giá
                                                        <i v-if="order_by == 2"
                                                            class="text-primary fa-solid fa-arrow-up"></i>
                                                        <i v-else-if="order_by == 1"
                                                            class="text-danger fa-solid fa-arrow-down"></i>
                                                        <i v-else class="text-success fa-solid fa-spinner fa-pulse"
                                                            style="animation: spin 2s infinite linear;"></i>
                                                    </th>
                                                    <th class="text-center middle-align">Tên Danh Mục</th>
                                                    <th class="text-center middle-align">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <template v-for="(value,key) in list_mon">
                                                    <tr>
                                                        <th class="text-center">@{{ key + 1 }}</th>
                                                        <td class="text-center align-middle">
                                                            <img v-bind:src="'/hinh-mon-an/' + value.hinh_anh" class="img-fluid">
                                                        </td>
                                                        <td class="text-center">@{{ value.ten_mon_an }}</td>
                                                        <td class="text-center">@{{ number_format(value.gia_ban) }}</td>
                                                        <td class="text-center">@{{ value.ten_danh_muc }}</td>
                                                        <td class="text-center">
                                                            <button class="btn btn-primary"
                                                                v-on:click="ChiTietBanHang(value.id)">Thêm Mới</button>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="card">
                                    <div class="card-body table-responsive "style="height: 720px; overflow-y: scroll;">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="align-middle" colspan="3">
                                                        <select v-if="hoa_don.is_xac_nhan==0" class="form-control"
                                                            v-model="hoa_don.id_khach_hang">
                                                            <option value="0">Chọn tên khách hàng</option>
                                                            <template v-for="(value,key) in list_khach">
                                                                <option v-bind:value="value.id">@{{ value.ho_va_ten }}
                                                                </option>
                                                            </template>
                                                        </select>
                                                        <select v-else class="form-control"
                                                            v-model="hoa_don.id_khach_hang" disabled>
                                                            <option value="0">Chọn tên khách hàng</option>
                                                            <template v-for="(value,key) in list_khach">
                                                                <option v-bind:value="value.id">@{{ value.ho_va_ten }}
                                                                </option>
                                                            </template>
                                                        </select>
                                                    </th>
                                                    <th class="align-middle text-nowrap text-center">
                                                        <button v-if="hoa_don.is_xac_nhan==1" class="btn btn-primary"
                                                            disabled>Xác Nhận Khách</button>
                                                        <button v-else class="btn btn-primary" v-on:click="XacNhan()">Xác
                                                            Nhận </button>
                                                        <a href="/admin/khach-hang" target="_blank"
                                                            class="btn btn-info">Thêm Khách Hàng</a>
                                                    </th>
                                                    <th class="text-center align-middle">Tổng Tiền</th>
                                                    <td class="align-middle">
                                                        <b>@{{ number_format(tong_tien) }}</b>
                                                    </td>
                                                    <td class="align-middle">
                                                        <i class="text-capitalize">@{{ tien_chu }}</i>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-center align-middle">
                                                        <button v-on:click="destroyall()" class="btn btn-danger"><i
                                                                class="fa-regular fa-trash-can"></i>
                                                        </button>
                                                    </th>
                                                    <th class="text-center align-middle">Tên Món</th>
                                                    <th class="text-center align-middle">Số Lượng</th>
                                                    <th class="text-center align-middle">Đơn Giá</th>
                                                    <th class="text-center align-middle">Chiếc Khấu</th>
                                                    <th class="text-center align-middle">Thành Tiền</th>
                                                    <th class="text-center align-middle">Ghi Chú</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template v-for="(value,key) in list_detail">
                                                    <tr>
                                                        <template v-if="value.is_in_bep==0">
                                                            <td class="text-center align-middle m-5">
                                                                <i style="cursor: pointer;"
                                                                    class="fa-solid fa-trash-can text-danger"
                                                                    v-on:click="destroy(value)"></i>
                                                                <input style="transform: scale(1.5);cursor: pointer;"
                                                                    type="checkbox" v-model="value.check" name=""
                                                                    id="">
                                                            </td>
                                                        </template>
                                                        <template v-else>
                                                            <th class="text-center align-middle"><input type="checkbox"
                                                                    v-model="value.check"
                                                                    style="transform: scale(1.5); cursor: pointer;"
                                                                    name="" id="">
                                                            </th>
                                                        </template>


                                                        <td class="text-center align-middle">@{{ value.ten_mon_an }}</td>
                                                        <template v-if="value.is_in_bep">
                                                            <td class="text-center">
                                                                @{{ value.so_luong_ban }}
                                                            </td>
                                                        </template>
                                                        <template v-else>
                                                            <td class="text-center align-middle" style="width: 15%">
                                                                <input v-on:change="update(value)"
                                                                    v-model="value.so_luong_ban" type="number"
                                                                    class="form-control">
                                                            </td>
                                                        </template>

                                                        <td class="text-center align-middle">@{{ number_format(value.don_gia_ban) }}</td>
                                                        <td class="text-center align-middle" style="width: 15%">
                                                            <input v-on:change="updateChietKhau(value)"
                                                                v-model="value.tien_chiet_khau" class="form-control"
                                                                type="number">
                                                        </td>
                                                        <td class="text-center align-middle">@{{ number_format(value.thanh_tien) }} </td>
                                                        <td class="text-center align-middle" style="width: 15%">
                                                            <input v-on:change="update(value)" v-model="value.ghi_chu"
                                                                class="form-control" type="text">
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="2" class="text-center"><b>Giảm giá</b></th>
                                                    <td colspan="2">
                                                        <input v-on:change="updateHoaDon()" v-model="giam_gia"
                                                            type="number" class="form-control">
                                                    </td>
                                                    <th class="text-center"><b>Thực trả</b></th>
                                                    <th class="text-danger">@{{ number_format(thanh_tien) }}</th>
                                                    <td>
                                                        <i>@{{ tt_chu }}</i>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="trang_thai==1">
                            <div class="col-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="align-middle">Chọn Bàn</th>
                                            <th>
                                                <select class="form-control"
                                                    v-on:change="LoadDanhSachMonTheoHoaDonChuyenBan(id_ban_nhan)"
                                                    v-model="id_ban_nhan">
                                                    <option value="0">Chọn Bàn Cần Chuyển </option>
                                                    <template v-for="(value,key) in list_ban"
                                                        v-if="value.tinh_trang==1 && value.trang_thai !=0">
                                                        <option v-if="value.id != add_mon.id_ban" v-bind:value="value.id">
                                                            @{{ value.ten_ban }}</option>
                                                    </template>
                                                </select>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="align-middle text-center">#</th>
                                            <th class="align-middle text-center">Tên Món</th>
                                            <th class="align-middle text-center">Số Lượng</th>
                                            <th class="align-middle text-center">Ghi Chú</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-for="(value,key) in list_mon2">
                                            <tr>
                                                <th class="text-center align-middle">@{{ key + 1 }}</th>
                                                <td class="text-center align-middle">@{{ value.ten_mon_an }}</td>
                                                <td class="text-center align-middle">@{{ value.so_luong_ban }}</td>
                                                <td class="text-center align-middle">@{{ value.ghi_chu }}</td>
                                            </tr>
                                        </template>

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-7">
                                <div class="card">
                                    <div class="card-body table-responsive "style="height: 720px; overflow-y: scroll;">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center align-middle">
                                                        #
                                                    </th>
                                                    <th class="text-center align-middle">Tên Món</th>
                                                    <th class="text-center align-middle">Số Lượng</th>
                                                    <th class="text-center align-middle">Số Lượng Chuyển</th>
                                                    <th class="text-center align-middle">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template v-for="(value,key) in list_detail">
                                                    <tr>

                                                        <th class="text-center align-middle">
                                                            @{{ key + 1 }}
                                                        </th>
                                                        <td class="text-center align-middle">@{{ value.ten_mon_an }}</td>

                                                        <td class="text-center">
                                                            @{{ value.so_luong_ban }}
                                                        </td>

                                                        <td class="text-center align-middle" style="width: 15%">
                                                            <input v-model="value.so_luong_chuyen" type="number"
                                                                class="form-control">
                                                        </td>

                                                        <td class="text-center align-middle" style="width: 15%">
                                                            <button v-on:click="chuyenban(value)"
                                                                class="btn btn-primary">Chuyển </button>
                                                        </td>

                                                    </tr>
                                                </template>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" v-on:click="trang_thai=0"
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" v-on:click="inBep(add_mon.id_hoa_don_ban_hang)" class="btn btn-primary">IN
                            BẾP</button>
                        <button v-if="trang_thai==0" v-on:click="trang_thai=1"
                            type="button"class="btn btn-danger">CHUYỂN
                            BÀN</button>
                        <button v-if="trang_thai==1" v-on:click="trang_thai=0" type="button"class="btn btn-danger"
                            id="chuyenban">Xong
                            chuyển Bàn</button>
                        <a target="_blank" v-bind:href="'/admin/ban-hang/in-bill/' + add_mon.id_hoa_don_ban_hang"
                            class="btn btn-warning">In Bill</a>
                        <button v-on:click="thanhToan()" type="button" class="btn btn-success">Thanh Toán</button>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            toastr.options = {
                "positionClass": "toast-bottom-center",
                "preventDuplicates": true,
                "timeOut": "5000"
            }

            new Vue({
                el: '#app',
                data: {
                    list_ban: [],
                    list_mon: [],
                    list_mon2: [],
                    list_detail: [],
                    key_search: '',
                    order_by: 0,
                    id_ban: 0,
                    add_mon: {
                        'id_hoa_don_ban_hang': 0,
                        'id_ban': 0
                    },
                    trang_thai: 0,
                    id_ban_nhan: 0,
                    id_hd_nhan: 0,
                    list_khach: [],
                    hoa_don: {},
                    tong_tien: 0,
                    tien_chu: '',
                    giam_gia: 0,
                    thanh_tien: 0,
                    tt_chu: '',



                },


                created() {
                    this.LoadDataBan();
                    this.loadDataMonAn();
                    this.loadDaTaKhachHang();
                },
                methods: {
                    updateHoaDon() {
                        var payload = {
                            'id': this.add_mon.id_hoa_don_ban_hang,
                            'giam_gia': this.giam_gia,
                        };
                        axios
                            .post('{{ Route('updateHoaDon') }}', payload)
                            .then((res) => {
                                this.LoadDanhSachMonTheoHoaDon(this.add_mon.id_hoa_don_ban_hang);
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },
                    thanhToan() {
                        axios
                            .post('{{ Route('6') }}', this.add_mon)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message);
                                    $('#ChiTietModel').modal('hide');
                                    var link = '/admin/ban-hang/in-bill/' + this.add_mon
                                        .id_hoa_don_ban_hang;
                                    window.open(link, "_blank");
                                    location.reload(); // reload the current page
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

                    XacNhan() {
                        axios
                            .post('{{ Route('5') }}', this.hoa_don)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message);
                                    this.hoa_don = res.data.data;
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

                    loadDaTaKhachHang() {
                        axios
                            .get('{{ Route('loadDaTa') }}')
                            .then((res) => {
                                this.list_khach = res.data.list;
                            });
                    },
                    chuyenban(v) {
                        v['id_hoa_don_nhan'] = this.id_hd_nhan;
                        console.log(this.id_hd_nhan);
                        axios
                            .post('{{ Route('3') }}', v)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message);
                                } else {
                                    toastr.error(res.data.message);
                                }
                                this.LoadDanhSachMonTheoHoaDon(this.add_mon.id_hoa_don_ban_hang);
                                this.LoadDanhSachMonTheoHoaDonChuyenBan(this.id_ban_nhan)
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });

                    },
                    LoadDanhSachMonTheoHoaDonChuyenBan(id_ban_nhan) {
                        var payload = {
                            'id_ban': id_ban_nhan,
                        };
                        axios
                            .post('{{ Route('2') }}', payload)
                            .then((res) => {
                                if (res.data.status) {
                                    this.list_mon2 = res.data.data;
                                    this.id_hd_nhan = res.data.id_hd;
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
                    destroyall() {
                        var payload = {
                            'list_detail': this.list_detail,
                        };
                        axios
                            .post('{{ Route('destroyall-chi-tiet-bang-hang') }}', payload)
                            .then((res) => {
                                if (res.data.status == 1) {
                                    toastr.success(res.data.message, "Success");
                                    this.LoadDanhSachMonTheoHoaDon(this.add_mon.id_hoa_don_ban_hang);

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
                    updateChietKhau(v) {
                        axios
                            .post('{{ Route('update-chi-tiet-bang-hang') }}', v)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message);
                                    this.LoadDanhSachMonTheoHoaDon(v.id_hoa_don_ban_hang);
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
                    destroy(payload) {
                        axios
                            .post('{{Route("xoachitiet")}}', payload)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message);
                                    this.LoadDanhSachMonTheoHoaDon(payload.id_hoa_don_nhap_hang);
                                } else {
                                    toastr.error(res.data.message);
                                    this.LoadDanhSachMonTheoHoaDon(payload.id_hoa_don_nhap_hang);
                                }

                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },
                    inBep(id_hoa_don_ban_hang) {
                        var payload = {
                            'id_hoa_don_ban_hang': id_hoa_don_ban_hang
                        }
                        axios
                            .post('/admin/ban-hang/in-bep', payload)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message);

                                } else {
                                    toastr.error(res.data.message);
                                }
                                this.LoadDanhSachMonTheoHoaDon(payload.id_hoa_don_ban_hang);
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },
                    update(v) {
                        axios
                            .post('/admin/ban-hang/update', v)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message);
                                    this.LoadDanhSachMonTheoHoaDon(v.id_hoa_don_ban_hang);
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
                    LoadDanhSachMonTheoHoaDon(id_hoa_don) {
                        var payload = {
                            'id_hoa_don_ban_hang': id_hoa_don,
                        };
                        axios
                            .post('/admin/ban-hang/danh-sach-mon-theo-hoa-don', payload)
                            .then((res) => {
                                if (res.data.status) {

                                    this.list_detail = res.data.data;
                                    this.tong_tien = res.data.tong_tien;
                                    this.tien_chu = res.data.tien_chu;
                                    this.thanh_tien = res.data.thanh_tien;
                                    this.tt_chu = res.data.tt_chu;
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

                    ChiTietBanHang(id_mon) {
                        var payload = {
                            'id_mon': id_mon,
                            'id_hoa_don_ban_hang': this.add_mon.id_hoa_don_ban_hang,
                        };
                        axios
                            .post('/admin/ban-hang/them-mon-an', payload)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message);
                                    this.LoadDanhSachMonTheoHoaDon(this.add_mon.id_hoa_don_ban_hang);
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
                    getidHoaDon(id_ban) {
                        var payload = {
                            'id_ban': id_ban
                        };
                        axios
                            .post('/admin/ban-hang/find-id-by-idban', payload)
                            .then((res) => {
                                this.add_mon.id_hoa_don_ban_hang = res.data.id_hoa_don;
                                this.add_mon.id_ban = id_ban;
                                this.hoa_don = res.data.hoa_don;
                                this.LoadDanhSachMonTheoHoaDon(this.add_mon.id_hoa_don_ban_hang);
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },
                    sort() {
                        this.order_by = this.order_by + 1
                        if (this.order_by > 2) {
                            this.order_by = 0;
                        }
                        //quy ước :1 là tăng dần , 2 là giảm xuông , 0 là giảm dần theo id
                        if (this.order_by == 1) {
                            this.list_mon = this.list_mon.sort(function(a, b) {
                                return a.gia_ban - b.gia_ban;
                            });
                        } else if (this.order_by == 2) {
                            this.list_mon = this.list_mon.sort(function(a, b) {
                                return b.gia_ban - a.gia_ban;
                            });
                        } else {
                            this.list_mon = this.list_mon.sort(function(a, b) {
                                return a.id - b.id;
                            });
                        }
                    },
                    search() {
                        var payload = {
                            'key_search': this.key_search,
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

                    loadDataMonAn() {
                        axios
                            .get('/admin/mon-an/data')
                            .then((res) => {
                                this.list_mon = res.data.list;

                            });
                    },
                    LoadDataBan() {
                        axios
                            .get('/admin/ban/data')
                            .then((res) => {
                                this.list_ban = res.data.list;

                            });
                    },
                    OpenTable(id_ban) {
                        var payload = {
                            'id_ban': id_ban,
                        };
                        axios
                            .post('/admin/ban-hang/tao-hoa-don', payload)
                            .then((res) => {
                                if (res.data.status == 1) {
                                    toastr.success(res.data.message, "Success");
                                    this.LoadDataBan();
                                } else if (res.data.status == 0) {
                                    toastr.error(res.data.message, "Error");
                                    this.LoadDataBan();
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
        });
    </script>
@endsection
