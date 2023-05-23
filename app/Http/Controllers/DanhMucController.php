<?php

namespace App\Http\Controllers;

use App\Http\Requests\DanhMuc\CreateDanhMucRequest;
use App\Http\Requests\DanhMuc\UpdateDanhMucRequest;
use App\Models\DanhMuc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DanhMucController extends Controller
{
    public function index()
    {   $x          = $this->checkRule(49);
        if ($x) {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }

        return view('admin.page.Danh_Muc.index');
    }

    public function getData()
    {
        $x          = $this->checkRule(50);
        if ($x) {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }
        $data = DanhMuc::all();

        return response()->json([
            'list' => $data
        ]);
    }
    public function doiTrangThai(Request $request)
    {
        $x = $this->checkRule(51);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $danhmuc = DanhMuc::find($request->id);

        if ($danhmuc) {
            $danhmuc->tinh_trang = !$danhmuc->tinh_trang;
            $danhmuc->save();

            return response()->json([
                'status' => true,
                'massage' => 'Đổi Trạng Thái Thành Công'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'massage' => 'Danh Mục Không Tồn Tại'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $x = $this->checkRule(52);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $danhmuc = DanhMuc::find($request->id);
        if ($danhmuc) {
            $danhmuc->delete();
            return response()->json([
                'status' => true,
                'message' => 'Xoá Danh Mục thành công'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Danh Mục không tồn tại'
            ]);
        }
    }

    public function edit(Request $request)
    {
        $danhmuc = DanhMuc::find($request->id);
        if ($danhmuc) {
            return response()->json([
                'status' => true,
                'message' => 'Đã Lấy Được Dữ Liệu ',
                'danhmuc' => $danhmuc
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Danh Mục Không Tồn Tại'
            ]);
        }
    }

    public function store(CreateDanhMucRequest $request)
    {
        $x = $this->checkRule(54);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $data = $request->all();
        DanhMuc::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Thêm Mới Thành Công'
        ]);
    }

    public function Checkslug(Request $request)
    {
        if (isset($request->id)) {
            $check = DanhMuc::where('slug_danh_muc', $request->slug_danh_muc)
                ->where('id', '<>', $request->id)
                ->first();
        } else {
            $check = DanhMuc::where('slug_danh_muc', $request->slug_danh_muc)->first();
        }
        if ($check) {
            return response()->json([
                'status' => false,
                'message' => 'Danh Mục Đã Tồn Tại'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Tên Danh Mục Có Thể Sử Dụng'
            ]);
        }
    }

    public function update(UpdateDanhMucRequest $request)
    {
        $x = $this->checkRule(53);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $danhmuc = DanhMuc::where('id', $request->id)->first();

        $data = $request->all();
        $danhmuc->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Đã Cập Nhật Được Thông Tin!'
        ]);
    }
    public function search(Request $request)
    {
        $list = DB::table('danh_mucs')
            ->where('ten_danh_muc', 'like', '%' . $request->key_search . '%')
            ->get();

        return response()->json([
            'list' => $list
        ]);
    }

    public function destoyall(Request $request){
        $x = $this->checkRule(55);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $str = "";
        foreach ($request->list as $key => $value) {
            if (isset($value['check'])) {
                $str .= $value['id'] .',';
            }
        }

        $ids = rtrim($str, ','); // Remove trailing comma

        if ($ids) {
            $deleted = DanhMuc::whereIn('id', explode(',', $ids))->delete();
            if ($deleted) {
                return response()->json([
                    'status' => true,
                    'message' => 'Xoá Thành Công Các Danh Mục Được Chọn'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Không Thể Xoá Các Danh Mục Được Chọn'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Bạn Chưa Chọn Danh Mục Để Xoá'
            ]);
        }
    }
}
