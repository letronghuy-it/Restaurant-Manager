<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoaiKhachHang\createLoaiKhachHangRequest;
use App\Http\Requests\LoaiKhachHang\updateLoaiKhachHangRequest;
use App\Models\LoaiKhachHang;
use App\Models\MonAn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoaiKhachHangController extends Controller
{
    public function index()
    {   $x          = $this->checkRule(26);
        if ($x) {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }

        return view('admin.page.Loai_Khach_Hang.index');
    }

    public function getData()
    {
        $x          = $this->checkRule(27);
        if ($x) {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }
        $list = LoaiKhachHang::get();
        foreach ($list as $key => $value) {
            $value->list_mon_tang =  explode(",", $value->list_mon_tang);
            $danhSachMon       = MonAn::whereIn('id', $value->list_mon_tang)->select('ten_mon_an')->get();
            $ten_mon_an            = "";
            foreach ($danhSachMon as $k => $v) {
                $ten_mon_an = $ten_mon_an . $v->ten_mon_an . ', ';
            }
            $ten_mon_an = rtrim($ten_mon_an, ", ");
            $value->ten_mon_an = $ten_mon_an;
        }

        return response()->json([
            'list' => $list
        ]);
    }

    public function doiTrangThai(Request $request)
    {
        $LoaiKhachHang = LoaiKhachHang::find($request->id);
        if ($LoaiKhachHang) {
            $LoaiKhachHang->tinh_trang = !$LoaiKhachHang->tinh_trang;
            $LoaiKhachHang->save();
            return response()->json([
                'status' => true,
                'massage' => 'Đổi Trạng Thái Thành Công'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'massage' => 'Đổi Trạng Thái Thất Bại!!'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $x = $this->checkRule(28);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $LoaiKhachHang = LoaiKhachHang::find($request->id);
        if ($LoaiKhachHang) {
            $LoaiKhachHang->delete();
            return response()->json([
                'status' => true,
                'message' => 'Xoá Thành Công Loại Khách Hàng'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Loại Khách Hàng Không Tồn Tại'
            ]);
        }
    }

    public function edit(Request $request)
    {
        $LoaiKhachHang = LoaiKhachHang::find($request->id);
        if ($LoaiKhachHang) {
            return response()->json([
                'status' => true,
                'message' => 'Đã Lấy Được Dữ Liệu Thành Công',
                'LoaiKhachHang' => $LoaiKhachHang
            ]);
        } else {
            return response()->jsonp([
                'status' => true,
                'message' => 'Loại Khách Không Tồn Tại',
            ]);
        }
    }

    public function store(createLoaiKhachHangRequest $request)
    {
        $x = $this->checkRule(29);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $data = $request->all();
        $str = "";
        foreach ($request->list_mon as $key => $value) {
            if (isset($value['check'])) {
                $str = $str . $value['id'] .',';
            }
        }
        $str = rtrim($str, ",");
        $data['list_mon_tang'] = $str;

        LoaiKhachHang::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Thêm Mới thành Công'
        ]);
    }

    public function ChecksMasothue1(Request $request)
    {
        if (isset($request->id)) {
            $check = LoaiKhachHang::where('ten_loai_khach', $request->ten_loai_khach)
                ->where('id', '<>', $request->id)
                ->first();
        } else {
            $check = LoaiKhachHang::where('ten_loai_khach', $request->ten_loai_khach)->first();
        }
        if ($check) {
            return response()->json([
                'status' => false,
                'message' => 'Tên Loại Khách Đã Tồn Tại'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Tên Loại Khách Có thể Có Thể Sử Dụng!'
            ]);
        }
    }

    public function update(updateLoaiKhachHangRequest $request)
    {
        $x = $this->checkRule(30);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $LoaiKhachHang = LoaiKhachHang::where('id', $request->id)->first();

        $data = $request->all();
        $LoaiKhachHang->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Đã Cập Nhật Được Thông Tin'
        ]);
    }

    public function search(Request $request)
    {
        $x = $this->checkRule(31);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $list = DB::table('loai_khach_hangs')
            ->where('ten_loai_khach', 'like', '%' . $request->key_search . '%')
            ->get();

        return response()->json([
            'list' => $list
        ]);
    }

    public function destroyall(Request $request){
        $x = $this->checkRule(32);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $str = "";
        foreach($request->list as $key=>$value){
            if(isset($value['check'])){
                $str.=$value['id'].',';
            }
        }
        $ids = rtrim($str,',');
        if($ids){
            $delete =LoaiKhachHang::whereIn('id',explode(',',$ids))->delete();
            if($delete){
                return response()->json([
                    'status'    => true,
                    'message'   => 'Xoá Thành Công Tất Cả Các Loại Khách Hàng Được Chọn',
                ]);
            }else{
                return response()->json([
                    'status'    => false,
                    'message'   => 'Không Thể Xoá Các Loại Khách Hàng Được Chọn',
                ]);
            }
        }else{
            return response()->json([
                'status'    => false,
                'message'   => 'Bạn Chưa Chọn Các Loại Khách Hàng Để Xoá',
            ]);
        }
    }
}
