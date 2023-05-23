@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-12">
            <div class="card card border-primary border-bottom border-3 border-0">
                <div class="card-header text-center">
                    <b>MENU Tiếp Thị </b>
                </div>
                <div class="card-body table-responsive" style="max-height: 720px">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center align-middle">
                                    <button class="btn btn-success" v-on:click="destroyall()">Xong Tất Cả Các Món </button>
                                </th>
                                <th class="text-center align-middle">Tên Món Ăn</th>
                                <th class="text-center align-middle">Số Lượng</th>
                                <th class="text-center align-middle">Tên Bàn</th>
                                <th class="text-center align-middle">Ghi Chú</th>
                                <th class="text-center align-middle">Thời Gian</th>
                                <th class="text-center align-middle">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value,key) in list">
                                <tr>
                                    <th class="text-center align-middle">
                                        <input type="checkbox" v-model="value.check"
                                            style="transform: scale(1.5);cursor: pointer;">
                                    </th>
                                    <td class="text-center align-middle">@{{ value.ten_mon_an }}</td>
                                    <td class="text-center align-middle">@{{ value.so_luong_ban }}</td>
                                    <td class="text-center align-middle">@{{ value.ten_ban }}</td>
                                    <td class="text-center align-middle">@{{ value.ghi_chu }}</td>
                                    <td class="text-center align-middle">@{{ date_format(value.updated_at) }}</td>
                                    <td class="text-center align-middle">
                                        <button v-on:click="donemonTT(value)" class="btn btn-success">Xong Món</button>
                                    </td>
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
            el: '#app',
            data: {
                list: []
            },
            created() {
                setInterval(() => {
                    this.loadData();
                }, 5000);
            },
            methods: {
                destroyall() {
                    var payload = {
                        'list': this.list
                    };
                    axios
                        .post('{{ Route('doneallmon-tiep-thi') }}', payload)
                        .then((res) => {
                            if (res.data.status) {
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
                loadData() {
                    axios
                        .get('/admin/tiep-thuc/data')
                        .then((res) => {
                            this.list = res.data.list;
                        });
                },

                donemonTT(payload) {
                    axios
                        .post('/admin/tiep-thuc/donemonTT', payload)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData(payload.id)
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
                date_format(now) {
                    return moment(now).format('HH:mm:ss DD/MM/yyyy');
                },
            },
        });
    </script>
@endsection
