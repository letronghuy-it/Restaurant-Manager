<?php

namespace App\Http\Controllers;

use App\Http\Requests\HoaDon\AddMonAnVaoHoaDonRequest;
use App\Http\Requests\HoaDon\CheckIdHoaDonBanHangRequest;
use App\Http\Requests\HoaDon\GetDanhSachMonTheoHoaDonRequest;
use App\Http\Requests\HoaDon\UpdateChiTietHoaDonrequest;
use App\Models\Ban;
use App\Models\ChiTietHoaDon;
use App\Models\HoaDonBanHang;
use App\Models\MonAn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PHPViet\NumberToWords\Transformer;

class HoaDonBanHangController extends Controller
{
    public function getDanhSachMonTheoHoaDonDatinhtien(Request $request)
    {
        $hoadon = HoaDonBanHang::find($request->id);

        $data = ChiTietHoaDon::join('hoa_don_ban_hangs', 'chi_tiet_hoa_dons.id_hoa_don_ban_hang', 'hoa_don_ban_hangs.id')
            ->join('mon_ans', 'chi_tiet_hoa_dons.id_mon_an', 'mon_ans.id')
            ->join('danh_mucs', 'mon_ans.id_danh_muc', 'danh_mucs.id')
            ->join('bans', 'hoa_don_ban_hangs.id_ban', 'bans.id')
            ->select('mon_ans.ten_mon_an', 'hoa_don_ban_hangs.id', 'danh_mucs.ten_danh_muc', 'bans.ten_ban', 'hoa_don_ban_hangs.ngay_thanh_toan', 'chi_tiet_hoa_dons.so_luong_ban', 'chi_tiet_hoa_dons.don_gia_ban', 'chi_tiet_hoa_dons.tien_chiet_khau', DB::raw('SUM(chi_tiet_hoa_dons.so_luong_ban*chi_tiet_hoa_dons.don_gia_ban) as thanh_tien'))
            ->where('hoa_don_ban_hangs.trang_thai', 1)
            ->where('mon_ans.id', $request->id)
            ->groupBy('mon_ans.ten_mon_an', 'hoa_don_ban_hangs.id', 'danh_mucs.ten_danh_muc', 'bans.ten_ban', 'hoa_don_ban_hangs.ngay_thanh_toan', 'chi_tiet_hoa_dons.so_luong_ban', 'chi_tiet_hoa_dons.don_gia_ban', 'chi_tiet_hoa_dons.tien_chiet_khau')
            ->get();


        $tong_tien = 0;
        foreach ($data as $value) {
            $tong_tien += $value->thanh_tien;
        }
        return response()->json([
            'status'    => 1,
            'message'   => 'Đã Lấy Dữ Liệu Thành Công',
            'data'      => $data,
            'tong_tien' => $tong_tien,


        ]);
    }

    public function getDanhSachMonTheoHoaDonDaThanhToan(Request $request)
    {
        $hoadon = HoaDonBanHang::find($request->id);

        if ($hoadon->trang_thai == 0) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Hoá Đơn này Chưa Tính Tiền',
            ]);
        } else {
            $data = ChiTietHoaDon::where('id_hoa_don_ban_hang', $request->id)->get();
            $tong_tien = 0;
            foreach ($data as $key => $value) {
                $tong_tien = $tong_tien + $value->thanh_tien;
            }
            $giam_gia = $hoadon->giam_gia;
            $thanh_tien = $tong_tien - $giam_gia;

            $transformer = new Transformer();
            return response()->json([
                'status'        => 1,
                'data'          => $data,
                'tong_tien'     => $tong_tien,
                'tien_chu'      => $transformer->toCurrency($tong_tien),
                'thanh_tien'    => $thanh_tien,
                'tt_chu'        => $transformer->toCurrency($thanh_tien),
            ]);
        }
    }

    public function getDanhSachMonTheoHoaDon(GetDanhSachMonTheoHoaDonRequest $request)
    {
        $hoadon = HoaDonBanHang::find($request->id_hoa_don_ban_hang);

        if ($hoadon->trang_thai) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Hoá Đơn Đã Tính Tiền',
            ]);
        } else {
            $data = ChiTietHoaDon::where('id_hoa_don_ban_hang', $request->id_hoa_don_ban_hang)->get();
            $tong_tien = 0;
            foreach ($data as $key => $value) {
                $tong_tien = $tong_tien + $value->thanh_tien;
            }
            $giam_gia = $hoadon->giam_gia;
            $thanh_tien = $tong_tien - $giam_gia;

            $transformer = new Transformer();
            return response()->json([
                'status'        => 1,
                'data'          => $data,
                'tong_tien'     => $tong_tien,
                'tien_chu'      => $transformer->toCurrency($tong_tien),
                'thanh_tien'    => $thanh_tien,
                'tt_chu'        => $transformer->toCurrency($thanh_tien),
            ]);
        }
    }

    public function addMonAnChiTietHoaDon(AddMonAnVaoHoaDonRequest $request)
    {
        $hoadon = HoaDonBanHang::find($request->id_hoa_don_ban_hang);
        if ($hoadon->trang_thai) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Hoá Đơn ĐÃ Tính Tiền',

            ]);
        } else {
            $monAn = MonAn::find($request->id_mon);
            $check = ChiTietHoaDon::where('id_hoa_don_ban_hang', $request->id_hoa_don_ban_hang)
                ->where('id_mon_an', $request->id_mon)
                ->first();
            if ($check && $check->is_in_bep == 0) {
                $check->so_luong_ban    = $check->so_luong_ban + 1;
                $check->thanh_tien      = $check->so_luong_ban * $check->don_gia_ban - $check->tien_chiet_khau;
                $check->save();
            } else {
                ChiTietHoaDon::create([
                    'id_hoa_don_ban_hang'       => $request->id_hoa_don_ban_hang,
                    'id_mon_an'                 => $request->id_mon,
                    'ten_mon_an'                => $monAn->ten_mon_an,
                    'so_luong_ban'              => 1,
                    'don_gia_ban'               => $monAn->gia_ban,
                    'tien_chiet_khau'           => 0,
                    'thanh_tien'                => $monAn->gia_ban,

                ]);
            }
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã Thêm Món Thành Công ',
            ]);
        }
    }

    public function findidbyidban(Request $request)
    {
        $hoadon = HoaDonBanHang::where('id_ban', $request->id_ban)
            ->where('trang_thai', 0)
            ->first();
        if ($hoadon) {
            return response()->json([
                'status'       => true,
                'id_hoa_don'   => $hoadon->id,
                'hoa_don'      => $hoadon,
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 0,
            ]);
        }
    }

    public function index()
    {   $x          = $this->checkRule(40);
        if ($x) {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }
        return view('admin.page.Hoa_Don.index');
    }

    public function store(Request $request)
    {

        $ban = Ban::find($request->id_ban);
        if ($ban && $ban->tinh_trang == 1 && $ban->trang_thai == 0) {
            // Có Cái Bàn Tình Trạng Đang Hoạt Động Trạng Thái Không Có Người Dùng
            $ban->trang_thai = 1; // lên màu xanh
            $ban->save();
            // Lưu Cái Bàn Lại
            $hoadon =  HoaDonBanHang::create([
                'ma_hoa_don_ban_hang' => Str::uuid(),
                'id_ban'              => $request->id_ban,

            ]);
            return response()->json([
                'status'    => true,
                'message'   => 'Đã Mở B',

            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Bàn Không Thể Mở',
            ]);
        }
    }


    public function update(UpdateChiTietHoaDonrequest $request)
    {
        $chiTietHoaDon = ChiTietHoaDon::find($request->id);
        $hoadonBanHang = HoaDonBanHang::find($request->id_hoa_don_ban_hang);
        if ($hoadonBanHang &&  $hoadonBanHang->trang_thai == 0 && $chiTietHoaDon->is_in_bep == 0) {
            $chiTietHoaDon->so_luong_ban     =   $request->so_luong_ban;
            $chiTietHoaDon->thanh_tien       =   $chiTietHoaDon->so_luong_ban *   $request->don_gia_ban;
            $chiTietHoaDon->ghi_chu          =   $request->ghi_chu;
            $chiTietHoaDon->tien_chiet_khau  =   $request->tien_chiet_khau;
            if ($chiTietHoaDon->tien_chiet_khau > $chiTietHoaDon->thanh_tien) {
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Tiền Chiếc Khấu Chỉ được tối đa:' . number_format($chiTietHoaDon->thanh_tien, 0, '.', '.') . 'đ',
                ]);
            } else {
                $chiTietHoaDon->thanh_tien  = $chiTietHoaDon->thanh_tien - $request->tien_chiet_khau;
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

    public function inBep(CheckIdHoaDonBanHangRequest $request)
    {
        $hoadonBanHang = HoaDonBanHang::find($request->id_hoa_don_ban_hang);

        if ($hoadonBanHang &&  $hoadonBanHang->trang_thai == 0) {
            ChiTietHoaDon::where('id_hoa_don_ban_hang', $request->id_hoa_don_ban_hang)
                ->update([
                    'is_in_bep' => 1,
                ]);
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã In Bếp Thành Công',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Hoá Dơn Này Đã Tình Tiền',
            ]);
        }
    }

    public function xoachitiet(UpdateChiTietHoaDonrequest $request)
    {
        $chiTietHoaDon = ChiTietHoaDon::find($request->id);
        $hoadonBanHang = HoaDonBanHang::find($request->id_hoa_don_ban_hang);
        if ($hoadonBanHang &&  $hoadonBanHang->trang_thai == 0 && $chiTietHoaDon->is_in_bep == 0) {

            $chiTietHoaDon->delete();
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã Xoá Sản Phẩm ',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Có Lỗi Không Mong Muốn',
            ]);
        }
    }

    public function XacNhanKhach(Request $request)
    {
        $hoadonBanHang = HoaDonBanHang::find($request->id);
        if ($hoadonBanHang &&  $hoadonBanHang->trang_thai == 0) {
            if ($hoadonBanHang->is_xac_nhan ==   0) {
                $hoadonBanHang->id_khach_hang   = $request->id_khach_hang;
                $hoadonBanHang->is_xac_nhan     = 1;
                $hoadonBanHang->save();
            }
            return response()->json([
                'status'    => 1,
                'message'   => 'Xác Nhận Khách Thành Công!',
                'data'      => $hoadonBanHang,
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Hoá Dơn Này Đã Tình Tiền',
            ]);
        }
    }

    public function inbill($id)
    {
        $chiTiet = ChiTietHoaDon::where('id_hoa_don_ban_hang', $id)->get();
        $tong_tien  = 0;
        foreach ($chiTiet as $key => $value) {
            $tong_tien += $value->thanh_tien;
        }
        $transformer = new Transformer();
        $hoaDon      = HoaDonBanHang::find($id);

        $giam_gia    = $hoaDon->giam_gia;
        $thanh_tien  = $tong_tien - $giam_gia;
        $tt_chu      = $transformer->toCurrency($thanh_tien);
        $ngay        = $hoaDon->ngay_thanh_toan ? Carbon::parse($hoaDon->ngay_thanh_toan)->format('H:i d/m/Y')  : 'Hóa đơn tạm tính';
        return view('admin.page.Hoa_Don.inbill', compact('chiTiet', 'tong_tien', 'giam_gia', 'thanh_tien', 'tt_chu', 'ngay'));
    }

    public function Thanhtoan(Request $request)
    {
        $hoaDonBanHang = HoaDonBanHang::find($request->id_hoa_don_ban_hang);
        if ($hoaDonBanHang && $hoaDonBanHang->trang_thai == 0) {
            $data = ChiTietHoaDon::where('id_hoa_don_ban_hang', $request->id_hoa_don_ban_hang)->get();
            $tong_tien  = 0;
            foreach ($data as $key => $value) {
                $tong_tien += $value->thanh_tien;
            }

            ChiTietHoaDon::where('id_hoa_don_ban_hang', $request->id_hoa_don_ban_hang)
                ->update([
                    'is_che_bien'    =>  1,
                    'is_tiep_thuc'   =>  1,
                    'is_in_bep'      =>  1,
                ]);

            $hoaDonBanHang->trang_thai = 1;
            $hoaDonBanHang->ngay_thanh_toan = Carbon::now();
            $hoaDonBanHang->tong_tien       = $tong_tien;
            $hoaDonBanHang->save();

            $ban                =   Ban::find($request->id_ban);
            $ban->trang_thai    =   0;
            $ban->save();

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã thanh toán thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Hóa đơn này đã tính tiền!',
            ]);
        }
    }

    public function UpdateHoaDon(Request $request)
    {
        $hoadonBanHang = HoaDonBanHang::find($request->id);
        if ($hoadonBanHang &&  $hoadonBanHang->trang_thai == 0) {
            if ($request->giam_gia == "") {
                $hoadonBanHang->giam_gia = 0;
            } else {
                $hoadonBanHang->giam_gia = $request->giam_gia;
            }
            $hoadonBanHang->save();
            return response()->json([
                'status'    => 1,
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Hoá Dơn Này Đã Tình Tiền',
            ]);
        }
    }
}
