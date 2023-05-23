<?php

namespace App\Http\Controllers;

use App\Http\Requests\MonAn\CreteMonAnRequest;
use App\Http\Requests\MonAn\UpDateMonAnRequest;
use App\Models\DanhMuc;
use App\Models\MonAn;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MonAnController extends Controller
{
    public function index()
    {   $x          = $this->checkRule(41);
        if ($x) {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }
        $danhmuc = DanhMuc::all();
        return view('admin.page.Mon_an.index', compact('danhmuc'));
    }

    public function index_vue()
    {   $x          = $this->checkRule(41);
        if ($x) {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }
        $danhmuc = DanhMuc::all();
        return view('admin.page.Mon_an.indexvue', compact('danhmuc'));
    }

    public function getData()
    {
        $x          = $this->checkRule(42);
        if ($x) {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }
        $data = MonAn::join('danh_mucs', 'mon_ans.id_danh_muc', 'danh_mucs.id')
            // ->where('mon_ans.tinh_trang', 0)
            ->select('mon_ans.*', 'danh_mucs.ten_danh_muc')
            ->orderBy('mon_ans.id')
            ->get();
        return response()->json([
            'list' => $data
        ]);
    }

    public function doiTrangThai(Request $request)
    {   $x = $this->checkRule(43);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $monan = MonAn::find($request->id);
        if ($monan) {
            $monan->tinh_trang = !$monan->tinh_trang;
            $monan->save();
            return response()->json([
                'status' => true,
                'message' => 'Đổi Trạng Thái Thành Công'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Đổi Trạng Thái Thất Bại!!'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $x = $this->checkRule(44);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $monan = MonAn::find($request->id);
        if ($monan) {
            $monan->delete();
            return response()->json([
                'status' => true,
                'message' => 'Xoá Thành Công Món Ăn'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Món Ăn Không Tồn Tại'
            ]);
        }
    }

    public function edit(Request $request)
    {
        $monan = MonAn::find($request->id);
        if ($monan) {
            return response()->json([
                'status' => true,
                'message' => 'Đã Lấy Được Dữ Liệu Thành Công',
                'monan' => $monan
            ]);
        } else {
            return response()->jsonp([
                'status' => true,
                'message' => 'Món Ăn Không Tồn Tại',
            ]);
        }
    }

    public function store(CreteMonAnRequest $request)
    {
        $x = $this->checkRule(46);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $data = $request->all();
        $file = $request->file('hinh_anh');
        $ten_hinh_anh = Str::uuid() . '-' . $request->slug_mon_an . '.' . $file->getClientOriginalExtension();
        $data['hinh_anh'] = $ten_hinh_anh;
        $file->move('hinh-mon-an', $ten_hinh_anh);
        MonAn::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Món Ăn Không Tồn Tại'
        ]);
    }

    public function Checkslug(Request $request)
    {
        if (isset($request->id)) {
            $check = MonAn::where('slug_mon_an', $request->slug_mon_an)
                ->where('id', '<>', $request->id)
                ->first();
        } else {
            $check = MonAn::where('slug_mon_an', $request->slug_mon_an)->first();
        }
        if ($check) {
            return response()->json([
                'status' => false,
                'message' => 'Tên Món Ăn Đã Tồn Tại'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Tên Món Ăn Có thể Có Thể Sử Dụng!'
            ]);
        }
    }

    public function update(UpDateMonAnRequest $request)
    {
        $x = $this->checkRule(47);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $monan = MonAn::where('id', $request->id)->first();
        $data = $request->all();
        $file = $request->file('hinh_anh');
        if ($file == null) {
            $data['hinh_anh'] = $data['hinh_anh_old'];
        } else {
            $ten_hinh_anh = Str::uuid() . '-' . $request->slug_mon_an . '.' . $file->getClientOriginalExtension();
            $data['hinh_anh'] = $ten_hinh_anh;
            $file->move('hinh-mon-an', $ten_hinh_anh);
        }

        $monan->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Đã Cập Nhật Được Thông Tin'
        ]);
    }

    public function search(Request $request)
    {
        $data = MonAn::leftjoin('danh_mucs', 'mon_ans.id_danh_muc', 'danh_mucs.id')
            ->select('mon_ans.*', 'danh_mucs.ten_danh_muc')
            ->where('ten_mon_an', 'like', '%' . $request->key_search . '%')
            ->orwhere('danh_mucs.ten_danh_muc', 'like', '%' . $request->key_search . '%')
            ->orderBy('mon_ans.id')
            ->get();
        return response()->json([
            'list' => $data
        ]);
    }

    public function destroyall(Request $request)
    {
        $x = $this->checkRule(48);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $str = "";
        foreach ($request->list_mon as $key => $value) {
            if (isset($value['check'])) {
                $str .= $value['id'] . ',';
            }
        }
        $ids = rtrim($str, ','); // Remove trailing comma

        if ($ids) {
            $deleted = MonAn::whereIn('id', explode(',', $ids))->delete();
            if ($deleted) {
                return response()->json([
                    'status' => true,
                    'message' => 'Xoá Thành Công Các Món Ăn Được Chọn'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Không Thể Xoá Các Món Ăn Được Chọn'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Bạn Chưa Chọn Món Ăn Để Xoá'
            ]);
        }
    }
}
