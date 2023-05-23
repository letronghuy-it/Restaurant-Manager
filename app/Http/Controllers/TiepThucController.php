<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Models\ChiTietHoaDon;
use App\Models\TiepThuc;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TiepThucController extends Controller
{
    public function indexTT()
    {
        $x          = $this->checkRule(18);
        if ($x) {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }
        $ten_ban = Ban::all();
        return view('admin.page.Tiep_Thi.index', compact('ten_ban'));
    }

    public function getDataTT()
    {   $x          = $this->checkRule(19);
        if ($x) {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }

        $data = ChiTietHoaDon::join('hoa_don_ban_hangs', 'chi_tiet_hoa_dons.id_hoa_don_ban_hang', 'hoa_don_ban_hangs.id')
            ->join('bans', 'hoa_don_ban_hangs.id_ban', 'bans.id')
            ->select('chi_tiet_hoa_dons.*', 'bans.ten_ban')
            ->where('is_in_bep', 1)
            ->where('is_che_bien', 1)
            ->where('is_tiep_thuc', 0)
            ->get();
        return response()->json([
            'list' => $data
        ]);
    }

    public function donemonTT(Request $request){
        $x = $this->checkRule(20);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $check = ChiTietHoaDon::find($request->id);
        if($check &&$check->is_che_bien==1 && $check->is_tiep_thuc==0){
            $check->is_tiep_thuc =1;
            $check->save();
            return response()->json([
                'status'    => true,
                'message'   => 'Đã Tiếp Thực Món Ăn',
            ]);
        }else{
            return response()->json([
                'status'    => false,
                'message'   => 'Bưng Món Chưa Thành Công',
            ]);
        }
    }

    public function doneallmon(Request $request){
        $x = $this->checkRule(21);

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
        $check = ChiTietHoaDon::whereIn('id', explode(',', $ids))
            ->where('is_che_bien', 1)
            ->where('is_tiep_thuc', 0)
            ->update(['is_tiep_thuc' => 1, 'thoi_gian_che_bien' => strtotime(Carbon::now()) - strtotime('created_at')]);

        if ($check) {
            return response()->json([
                'status'    => true,
                'message'   => 'Đã Tiếp Thực Món Ăn',
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Hệ Thống Bị Sự Cố',
            ]);
        }
    }
}
