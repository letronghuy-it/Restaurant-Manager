<?php

namespace App\Http\Controllers;

use App\Http\Requests\KhachHang\KhachHangrequest;
use App\Http\Requests\KhachHang\updateKhachHangRequest;
use App\Models\KhachHang;
use App\Models\LoaiKhachHang;
use Illuminate\Http\Request;

class KhachHangController extends Controller
{
    public function index()
    {
        $x          = $this->checkRule(33);
        if ($x) {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }
        $loai_khach_hang = LoaiKhachHang::all();
        return view('admin.page.khach_hang.index', compact('loai_khach_hang'));
    }

    public function getData()
    {
        $x          = $this->checkRule(38);
        if ($x) {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }
        $data = KhachHang::leftJoin('loai_khach_hangs', 'khach_hangs.id_loai_khach', 'loai_khach_hangs.id')
            ->select('khach_hangs.*', 'loai_khach_hangs.ten_loai_khach')
            ->orderBy('khach_hangs.id')
            ->get();
        return response()->json([
            'list' => $data
        ]);
    }


    public function destroy(Request $request)
    {
        $x = $this->checkRule(36);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $KhachHang = KhachHang::find($request->id);
        if ($KhachHang) {
            $KhachHang->delete();
            return response()->json([
                'status' => true,
                'message' => 'Xoá Thành Công Khách Hàng Cấp'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Khách Hàng Cấp Không Tồn Tại'
            ]);
        }
    }

    public function edit(Request $request)
    {
        $KhachHang = KhachHang::find($request->id);
        if ($KhachHang) {
            return response()->json([
                'status' => true,
                'message' => 'Đã Lấy Được Dữ Liệu Thành Công',
                'KhachHang' => $KhachHang
            ]);
        } else {
            return response()->jsonp([
                'status' => true,
                'message' => 'Khách Hàng Không Tồn Tại',
            ]);
        }
    }

    public function store(KhachHangrequest $request)
    {$x = $this->checkRule(34);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $data = $request->all();
        $data['ho_va_ten'] = $data['ho_lot'] . $data['ten_khach'];
        KhachHang::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Thêm Mới Thành Công'
        ]);
    }

    public function ChecksMakhachhang(Request $request)
    {
        if (isset($request->id)) {
            $check = KhachHang::where('ma_khach_hang', $request->ma_khach_hang)
                ->where('id', '<>', $request->id)
                ->first();
        } else {
            $check = KhachHang::where('ma_khach_hang', $request->ma_khach_hang)->first();
        }
        if ($check) {
            return response()->json([
                'status' => false,
                'message' => 'Mã Khách Hàng  Cấp Đã Tồn Tại'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Mã Khách Hàng  Cấp Có thể Có Thể Sử Dụng!'
            ]);
        }
    }

    public function update(updateKhachHangRequest $request)
    {   $x = $this->checkRule(35);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $KhachHang = KhachHang::where('id', $request->id)->first();

        $data = $request->all();
        $KhachHang->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Đã Cập Nhật Được Thông Tin'
        ]);
    }

    public function search(Request $request)
    {   $x = $this->checkRule(37);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $data = KhachHang::leftJoin('loai_khach_hangs', 'khach_hangs.id_loai_khach', 'loai_khach_hangs.id')
            ->select('khach_hangs.*', 'loai_khach_hangs.ten_loai_khach')
            ->where('ma_khach_hang', 'like', '%' . $request->key_search . '%')
            ->orWhere('ho_va_ten', 'like', '%' . $request->key_search . '%')
            ->orWhere('so_dien_thoai', 'like', '%' . $request->key_search . '%')
            ->orWhere('email', 'like', '%' . $request->key_search . '%')
            ->orWhere('loai_khach_hangs.ten_loai_khach', 'like', '%' . $request->key_search . '%')
            ->orderBy('khach_hangs.id')
            ->get();
        return response()->json([
            'list' => $data
        ]);
    }
    public function destroyall(Request $request)
    {   $x          = $this->checkRule(39);
        if ($x) {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }
        $str = "";
        foreach ($request->list as $key => $value) {
            if (isset($value['check'])) {
                $str .= $value['id'] . ',';
            }
        }
        $ids = rtrim($str, ',');
        if ($ids) {
            $delete = KhachHang::whereIn('id', explode(',', $ids))->delete();
            if ($delete) {
                return response()->json([
                    'status'    => true,
                    'message'   => 'Xoá Thành Công Tất Cả Các Khách Hàng Được Chọn',
                ]);
            } else {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Không Thể Xoá Các Khách Hàng Được Chọn',
                ]);
            }
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Bạn Chưa Chọn Các Khách Hàng Để Xoá',
            ]);
        }
    }
}
