<?php

namespace App\Http\Controllers;

use App\Models\ChiTietHoaDon;
use App\Models\HoaDonBanHang;
use App\Models\KhachHang;
use App\Models\ThongKe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThongKeController extends Controller
{
    public function index()
    {
        return view('admin.page.Thong_Ke.index');
    }

    public function ThongKeBanHang(Request $request)
    {
        $data = HoaDonBanHang::where('trang_thai', 1)
            ->whereDate('ngay_thanh_toan', '>=', $request->begin)
            ->whereDate('ngay_thanh_toan', '<=', $request->end)
            ->get();
        return response()->json([
            'status'    => 1,
            'message'   => 'Đã Lấy Dữ Liệu Thành Công',
            'data'      => $data
        ]);
    }


    public function indexmonanban()
    {
        return view('admin.page.Thong_Ke.monaanban');
    }

    public function ThongKeMonAnBan(Request $request)
    {
        $data = ChiTietHoaDon::join('hoa_don_ban_hangs', 'chi_tiet_hoa_dons.id_hoa_don_ban_hang', 'hoa_don_ban_hangs.id')
            ->join('mon_ans', 'chi_tiet_hoa_dons.id_mon_an', '=', 'mon_ans.id')
            ->join('danh_mucs', 'danh_mucs.id', 'mon_ans.id_danh_muc')
            ->select('mon_ans.ten_mon_an', 'mon_ans.id', 'danh_mucs.ten_danh_muc', DB::raw('SUM(chi_tiet_hoa_dons.so_luong_ban*chi_tiet_hoa_dons.don_gia_ban) as thanh_tien'))
            ->where('hoa_don_ban_hangs.trang_thai', 1)
            ->whereDate('ngay_thanh_toan', '>=', $request->begin)
            ->whereDate('ngay_thanh_toan', '<=', $request->end)
            ->groupBy('mon_ans.ten_mon_an', 'mon_ans.id', 'danh_mucs.ten_danh_muc')
            ->get();



        return response()->json([
            'status'    => 1,
            'message'   => 'Đã Lấy Dữ Liệu Thành Công',
            'data'      => $data
        ]);
    }

    public function chartindex()
    {
        return view('admin.page.Thong_Ke.ThongkeKhachHangAnNhieu');
    }


    public function ThongKeKhach(Request $request)
    {
        $data   = KhachHang::join('hoa_don_ban_hangs', 'khach_hangs.id', 'hoa_don_ban_hangs.id_khach_hang')
            ->whereDate('hoa_don_ban_hangs.ngay_thanh_toan', '>=', $request->begin)
            ->whereDate('hoa_don_ban_hangs.ngay_thanh_toan', '<=', $request->end)
            ->select('khach_hangs.ma_khach_hang', 'khach_hangs.ho_va_ten', DB::raw('SUM(hoa_don_ban_hangs.tong_tien) as tong_tien'))
            ->groupBy('khach_hangs.ma_khach_hang', 'khach_hangs.ho_va_ten')
            ->orderByDESC('tong_tien')
            ->take(10)
            ->get();
        $list_ten = [];
        $list_tien = [];
        foreach ($data as $key => $value) {
            array_push($list_ten, $value->ho_va_ten);
            array_push($list_tien, $value->tong_tien);
        }
        return response()->json([
            'list_ten'    => $list_ten,
            'list_tien'   => $list_tien,
        ]);
    }

    public function indexMonAnNhieu(){
        return view('admin.page.Thong_Ke.monAnBanNhieuNhat');
    }
}
