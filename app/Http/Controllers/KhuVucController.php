<?php

namespace App\Http\Controllers;

use App\Http\Requests\KhuVuc\CreateKhuVucRequest;
use App\Http\Requests\KhuVuc\UpDateKhuVucRequest;
use App\Models\Ban;
use App\Models\KhuVuc;
use Illuminate\Http\Request;

class KhuVucController extends Controller
{
    public function index()
    {
        $x          = $this->checkRule(63);
        if ($x) {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }
        return view('admin.page.khu_vuc.index');
    }

    public function getData()
    {
        $x          = $this->checkRule(64);
        if ($x) {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }
        $list = KhuVuc::get();
        return response()->json([
            'list' => $list
        ]);
    }

    public function doiTrangThai(Request $request)
    {    $x = $this->checkRule(65);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $KhuVuc = KhuVuc::find($request->id);

        if ($KhuVuc) {
            $KhuVuc->tinh_trang = !$KhuVuc->tinh_trang;
            $KhuVuc->save();

            return response()->json([
                'status' => true,
                'message' => 'Đã đổi trạng thái thành công '
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Khu Vực Không Tồn Tại! '
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $x = $this->checkRule(66);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $KhuVuc = KhuVuc::find($request->id);
        if ($KhuVuc) {
            $ban = Ban::where('id_khu_vuc', $request->id)->first();

            if ($ban) {
                return response()->json([
                    'status' => 2,
                    'message' => 'Khu Vực Này Đang Có Bàn, Bạn Không Thể Xoá '
                ]);
            } else {
                $KhuVuc->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Đã Xoá  khu vực Thành Công!'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Khu Vực Không Tồn Tại!'
            ]);
        }
    }

    public function edit(Request $request)
    {
        $KhuVuc = KhuVuc::find($request->id);

        if ($KhuVuc) {
            return response()->json([
                'status' => true,
                'message' => 'Đã Lấy Được Dữ Liệu!',
                'KhuVuc' => $KhuVuc
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Khu Vực Không Tồn Tại!',
            ]);
        }
    }

    public function store(CreateKhuVucRequest $request)
    {    $x = $this->checkRule(68);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $data = $request->all();

        KhuVuc::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Bàn Không Tồn Tại'
        ]);
    }

    public function checkslug(Request $request)
    {
        if (isset($request->id)) {
            $check = KhuVuc::where('slug_khu_vuc', $request->slug_khu_vuc)
                ->where('id', '<>', $request->id)
                ->first();
        } else {
            $check = KhuVuc::where('slug_khu_vuc', $request->slug_khu_vuc)->first();
        }

        if ($check) {
            return response()->json([
                'status' => false,
                'message' => 'Khu Vực Đã Tồn Tại!'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Khu Vực Không Tồn Tại Có Thể Thêm Mới'
            ]);
        }
    }

    public function update(UpDateKhuVucRequest $request)
    {
        $x = $this->checkRule(69);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }

        $KhuVuc = KhuVuc::where('id', $request->id)->first();
        $data = $request->all();
        $KhuVuc->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Đã Cập Nhật Được Thông Tin!'
        ]);
    }
}
