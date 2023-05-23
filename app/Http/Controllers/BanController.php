<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ban\CreateBanRequest;
use App\Http\Requests\Ban\UpdateBanRequest;
use App\Models\Ban;
use App\Models\HoaDonBanHang;
use App\Models\KhuVuc;
use Illuminate\Http\Request;

class BanController extends Controller
{
    public function index()
    {   $x          = $this->checkRule(56);
        if ($x) {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }
        $khuvuc = KhuVuc::all();
        return view('admin.page.Ban.index', compact('khuvuc'));
    }

    public function getData()
    {
        $x          = $this->checkRule(57);
        if ($x) {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }

        $list = Ban::leftjoin('khu_vucs', 'bans.id_khu_vuc', 'khu_vucs.id')
            ->select('bans.*', 'khu_vucs.ten_khu_vuc')
            ->orderBy('bans.id')
            ->get();
        return response()->json([
            'list' => $list
        ]);
    }

    public function doiTrangThai(Request $request)
    {
        $x = $this->checkRule(58);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $Ban = Ban::find($request->id);
        if ($Ban) {
            if ($Ban->trang_thai != 0 ) {
                return response()->json([
                    'status' => false,
                    'massage' => 'Bàn Đang Hoạt Động Không Thể Đổi Trạng Thái'
                ]);
            } else {
                $Ban->tinh_trang = !$Ban->tinh_trang;
                $Ban->save();

                return response()->json([
                    'status' => true,
                    'massage' => 'Đổi Trạng Thái Thành Công'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'massage' => 'Bàn Không Tồn Tại'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $x = $this->checkRule(59);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $Ban = Ban::find($request->id);
        if ($Ban) {
            $hoadon = HoaDonBanHang::where('id_ban', $request->id)->first();
            if ($Ban->trang_thai>0 && $hoadon->trang_thai>0) {
                return response()->json([
                    'status' => false,
                    'massage' => 'Bàn Đang Hoạt Động Hoá Đơn Chưa Tính Tiền Xoá Cho Đổ Nợ'
                ]);
            }else{
                $Ban->delete();
                return response()->json([
                    'status' => true,
                    'massage' => 'Xoá bàn thành công'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'massage' => 'Bàn không tồn tại'
            ]);
        }
    }

    public function edit(Request $request)
    {
        $Ban = Ban::find($request->id);
        if ($Ban) {
            return response()->json([
                'status' => true,
                'message' => 'Đã Lấy Được Dữ Liệu ',
                'Ban' => $Ban
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Bàn Không Tồn Tại'
            ]);
        }
    }

    public function store(CreateBanRequest $request)
    {
        $x = $this->checkRule(60);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $data = $request->all();

        Ban::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Bàn Không Tồn Tại Đã Thêm Mới Thành Công'
        ]);
    }

    public function Checkslug(Request $request)
    {
        if (isset($request->id)) {
            $check = Ban::where('slug_ban', $request->slug_ban)
                ->where('id', '<>', $request->id)
                ->first();
        } else {
            $check = Ban::where('slug_ban', $request->slug_ban)->first();
        }

        if ($check) {
            return response()->json([
                'status' => false,
                'message' => 'Tên Bàn Đã Tồn Tại'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Tên Bàn Có thể Có Thể Sử Dụng!'
            ]);
        }
    }

    public function update(UpdateBanRequest $request)
    {
        $x = $this->checkRule(61);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $Ban = Ban::where('id', $request->id)->first();

        $data = $request->all();
        $Ban->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Đã Cập Nhật Được Thông Tin!'
        ]);
    }

    public function search(Request $request)
    {
        $list = Ban::leftjoin('khu_vucs', 'bans.id_khu_vuc', 'khu_vucs.id')
            ->select('bans.*', 'khu_vucs.ten_khu_vuc')
            ->where('ten_ban', 'like', '%' . $request->key_search . '%')
            ->orwhere('khu_vucs.ten_khu_vuc', 'like', '%' . $request->key_search . '%')
            ->orderBy('bans.id')
            ->get();
        return response()->json([
            'list' => $list
        ]);
    }

    public function destroyall(Request $request)
    {    $x = $this->checkRule(62);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $str = "";
        foreach ($request->list as $key => $value) {
            if (isset($value['check'])) {
                $str .= $value['id'] . ',';
            }
        }
        $ids = rtrim($str, ',');
        if ($ids) {
            $delete = Ban::whereIn('id', explode(',', $ids))->delete();
            if ($delete) {
                return response()->json([
                    'status'    => true,
                    'message'   => 'Xoá Thành Công Tất Cả Các Bàn Được Chọn',
                ]);
            } else {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Không Thể Xoá Các Bàn Được Chọn',
                ]);
            }
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Bạn Chưa Chọn Các Bàn Để Xoá',
            ]);
        }
    }
}
