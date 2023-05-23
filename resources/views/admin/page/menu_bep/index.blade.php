@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-12">
            <div class="card card border-primary border-bottom border-3 border-0">
                <div class="card-header text-center">
                    <b>MENU BẾP </b>
                </div>
                <div class="card-body table-responsive" style="max-height: 720px">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center align-middle">
                                    <button class="btn btn-success" v-on:click="doneallmon()">Xong Tất Cả</button>
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
                                       <input  style="transform: scale(1.5);cursor: pointer;" v-model="value.check" type="checkbox" name="" id="">
                                    </th>
                                    <td class="text-center align-middle">@{{ value.ten_mon_an }}</td>
                                    <td class="text-center align-middle">@{{ value.so_luong_ban }}</td>
                                    <td class="text-center align-middle">@{{ value.ten_ban }}</td>
                                    <td class="text-center align-middle">@{{ value.ghi_chu }}</td>
                                    <td class="text-center align-middle">@{{ date_format(value.updated_at) }}</td>
                                    <td class="text-center align-middle">
                                        <button v-on:click="done(value)" class="btn btn-success">Xong Món</button>
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
                list: [],
                list_ban:[],
                id_bep:0,
            },
            created() {
                setInterval(() => {
                    this.loadData();
                }, 2000);


            },
            methods: {
                doneallmon(){
                    var payload ={
                        'list'  : this.list
                    };
                    axios
                    .post('{{Route("doneallmon-in-bep")}}', payload)
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
                done(payload){
                    axios
                        .post('/admin/bep/donemon', payload)
                        .then((res) => {
                            if(res.data.status) {
                                toastr.success(res.data.message);
                            } else {
                                toastr.error(res.data.message);
                            }
                            this.loadData(payload);
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                loadData() {
                    axios
                        .get('/admin/bep/data')
                        .then((res) => {
                            this.list = res.data.list;
                        });
                },

                date_format(now) {
                    return moment(now).format('HH:mm:ss DD/MM/yyyy');
                },
            },
        });
    </script>
@endsection
