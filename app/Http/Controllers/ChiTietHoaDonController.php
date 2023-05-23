<?php

namespace App\Http\Controllers;

use App\Http\Requests\HoaDon\checkIDbanrequest;
use App\Http\Requests\HoaDon\UpdateChiTietHoaDonrequest;
use App\Models\ChiTietHoaDon;
use App\Models\HoaDonBanHang;
use Illuminate\Http\Request;

class ChiTietHoaDonController extends Controller
{
    public function UpdateChiecKhau(UpdateChiTietHoaDonrequest $request)
    {
        $chiTietHoaDon = ChiTietHoaDon::find($request->id);
        $hoadonBanHang = HoaDonBanHang ::find($request->id_hoa_don_ban_hang);

        if ($hoadonBanHang &&  $hoadonBanHang->trang_thai == 0) {
            $thanh_tien                      =   $chiTietHoaDon->so_luong_ban * $chiTietHoaDon->don_gia_ban;
            $chiTietHoaDon->tien_chiet_khau  =   $request->tien_chiet_khau;
            if ($chiTietHoaDon->tien_chiet_khau > $thanh_tien) {
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Tiền Chiếc Khấu Chỉ được tối đa:' . number_format($thanh_tien, 0, '.', '.') . 'đ',
                ]);
            } else {
                $chiTietHoaDon->thanh_tien  = $thanh_tien - $request->tien_chiet_khau;
                $chiTietHoaDon->save();
                return response()->json([
                    'status'    => 1,
                    'message'   => 'Đã Chiết Khấu Thành Công',
                ]);
            }
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Hoá Đơn Không Tồn Tại',
            ]);
        }
    }

    public function destroyall(Request $request)
    {

        $str = "";
        foreach ($request->list_detail as $key => $value) {
            if (isset($value['check'])) {
                $str .= $value['id'] . ',';
            }
        }
        $ids = rtrim($str, ','); // Remove trailing comma

        if ($ids) {
            $deleted = ChiTietHoaDon::whereIn('id', explode(',', $ids))
                ->delete();
            if ($deleted) {
                // $deleted->giam_gia = 0;
                // $deleted->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Xoá Thành Công Các Món Ăn Được Chọn'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Nấu Gần Xong Không Thể Huỷ Món'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Bạn Chưa Chọn Món Ăn Để Xoá'
            ]);
        }
    }


    public function LoadDanhSachMonTheoHoaDonBanChuyen(checkIDbanrequest $request)
    {
        $hoaDon = HoaDonBanHang::where('id_ban', $request->id_ban)
            ->where('trang_thai', 0)
            ->first();
        if ($hoaDon) {
            $data = ChiTietHoaDon::where('id_hoa_don_ban_hang', $hoaDon->id)->get();
            return response()->json([
                'status' => 1,
                'data' => $data,
                'id_hd' => $hoaDon->id,
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Hoá Đơn Đã Tính Tiền'
            ]);
        }
    }

    public function ChuyenMonquabankhac(Request $request)
    {
        $so_luong_chuyen           = $request->so_luong_chuyen;
        $id_hoa_don_nhan           = $request->id_hoa_don_nhan;
        $check_id_chi_tiet_ban_hang = ChiTietHoaDon::find($id_hoa_don_nhan);

        if($check_id_chi_tiet_ban_hang) {

            $hoaDon = HoaDonBanHang::find($request->id_hoa_don_ban_hang);

            if ($hoaDon && $hoaDon->trang_thai == 0) {
                if ($so_luong_chuyen > 0 && $so_luong_chuyen == $request->so_luong_ban) {
                    $chiTietHoaDon                       = ChiTietHoaDon::find($request->id);
                    $chiTietHoaDon->id_hoa_don_ban_hang  = $id_hoa_don_nhan;
                    $dau_cach                            = $chiTietHoaDon->ghi_chu ? ": " : '';
                    $chiTietHoaDon->ghi_chu              = 'Chuyển món từ hoá đơn ' . $chiTietHoaDon->id_hoa_don_ban_hang . 'sang' . $dau_cach . $chiTietHoaDon->ghi_chu;
                    $chiTietHoaDon->save();
                    return response()->json([
                        'status' => 1,
                        'message' => 'Đã Chuyển Món Thành Công'
                    ]);
                } else if ($so_luong_chuyen > 0 && $so_luong_chuyen < $request->so_luong_ban) {
                    $chiTietHoaDon                      = ChiTietHoaDon::find($request->id);
                    $don_gia                            = $chiTietHoaDon->don_gia_ban;
                    $tien_giam_gia_1_phan               = $chiTietHoaDon->tien_chiet_khau / $chiTietHoaDon->so_luong_ban;
                    $chiTietHoaDon->so_luong_ban       -= $so_luong_chuyen;
                    $tien_chiet_khau                    = $tien_giam_gia_1_phan * $chiTietHoaDon->so_luong_ban;
                    $chiTietHoaDon->thanh_tien          = $chiTietHoaDon->so_luong_ban * $don_gia - $tien_chiet_khau;
                    $chiTietHoaDon->tien_chiet_khau     = $tien_chiet_khau;
                    $chiTietHoaDon->save();
                    $dau_cach = $chiTietHoaDon->ghi_chu ? ": " : '';

                    ChiTietHoaDon::create([
                        'id_hoa_don_ban_hang'       => $id_hoa_don_nhan,
                        'id_mon_an'                 => $chiTietHoaDon->id_mon_an,
                        'ten_mon_an'                => $chiTietHoaDon->ten_mon_an,
                        'so_luong_ban'              => $so_luong_chuyen,
                        'don_gia_ban'               => $chiTietHoaDon->don_gia_ban,
                        'tien_chiet_khau'           => $tien_giam_gia_1_phan * $so_luong_chuyen,
                        'thanh_tien'                => $so_luong_chuyen * $chiTietHoaDon->don_gia_ban - $tien_giam_gia_1_phan * $so_luong_chuyen,
                        'ghi_chu'                   =>  'Chuyển món từ hoá đơn ' . $chiTietHoaDon->id_hoa_don_ban_hang . 'sang' . $dau_cach . $chiTietHoaDon->ghi_chu,
                        'is_che_bien'               => $chiTietHoaDon->is_che_bien,
                        'thoi_gian_che_bien'        =>  $chiTietHoaDon->thoi_gian_che_bien,
                        'is_tiep_thuc'              => $chiTietHoaDon->is_tiep_thuc,
                        'is_in_bep'                 => $chiTietHoaDon->is_in_bep,
                    ]);
                    return response()->json([
                        'status' => 1,
                        'message' => 'Đã Chuyển Món Thành Công'
                    ]);
                } else {
                    return response()->json([
                        'status' => 0,
                        'message' => 'Chưa Chọn Số Lượng Chuyển!'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => 'Hoá Đơn Đã Tính Tiền'
                ]);
            }
        }
    }
}
