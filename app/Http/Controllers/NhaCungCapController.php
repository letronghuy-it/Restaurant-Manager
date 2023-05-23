<?php

namespace App\Http\Controllers;

use App\Http\Requests\NhaCungCap\CreateNhaCungCapRequest;
use App\Http\Requests\NhaCungCap\UpDateNhaCungCapRequest;
use App\Models\NhaCungCap;
use Illuminate\Http\Request;

class NhaCungCapController extends Controller
{
    public function index()
    {
        $x          = $this->checkRule(12);
        if ($x) {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }
        return view('admin.page.Nha_cung_cap.index',);
    }

    public function getData()
    {
        $x          = $this->checkRule(14);
        if($x)  {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }
        $data = NhaCungCap::get();
        return response()->json([
            'list' => $data
        ]);
    }

    public function doiTrangThai(Request $request)
    {
        $x          = $this->checkRule(17);
        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        $NhaCungCap = NhaCungCap::find($request->id);
        if ($NhaCungCap) {
            $NhaCungCap->tinh_trang = !$NhaCungCap->tinh_trang;
            $NhaCungCap->save();
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
        $x          = $this->checkRule(15);
        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        $NhaCungCap = NhaCungCap::find($request->id);
        if ($NhaCungCap) {
            $NhaCungCap->delete();
            return response()->json([
                'status' => true,
                'message' => 'Xoá Thành Công Nhà Cung Cấp'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Nhà Cung Cấp Không Tồn Tại'
            ]);
        }
    }

    public function edit(Request $request)
    {
        $NhaCungCap = NhaCungCap::find($request->id);
        if ($NhaCungCap) {
            return response()->json([
                'status' => true,
                'message' => 'Đã Lấy Được Dữ Liệu Thành Công',
                'NhaCungCap' => $NhaCungCap
            ]);
        } else {
            return response()->jsonp([
                'status' => true,
                'message' => 'Nhà Cung Không Tồn Tại',
            ]);
        }
    }

    public function store(CreateNhaCungCapRequest $request)
    {
        $x          = $this->checkRule(13);
        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        $data = $request->all();

        NhaCungCap::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Nhà Cung Không Tồn Tại'
        ]);
    }

    public function ChecksMasothue1(Request $request)
    {
        if (isset($request->id)) {
            $check = NhaCungCap::where('ma_so_thue', $request->ma_so_thue)
                ->where('id', '<>', $request->id)
                ->first();
        } else {
            $check = NhaCungCap::where('ma_so_thue', $request->ma_so_thue)->first();
        }
        if ($check) {
            return response()->json([
                'status' => false,
                'message' => 'Mã Số Thuế  Cấp Đã Tồn Tại'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Mã Số Thuế  Cấp Có thể Có Thể Sử Dụng!'
            ]);
        }
    }

    public function update(UpDateNhaCungCapRequest $request)
    {
        $x          = $this->checkRule(16);
        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        $NhaCungCap = NhaCungCap::where('id', $request->id)->first();

        $data = $request->all();
        $NhaCungCap->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Đã Cập Nhật Được Thông Tin'
        ]);
    }
}
