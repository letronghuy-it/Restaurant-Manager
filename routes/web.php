<?php

use App\Http\Controllers\Admincontroller;
use App\Http\Controllers\BanController;

use App\Http\Controllers\ChiTietHoaDonController;

use App\Http\Controllers\ChiTietHoaDonNhapController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\HoaDonBanHang;
use App\Http\Controllers\HoaDonBanHangController;
use App\Http\Controllers\HoaDonNhapController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\KhuVucController;
use App\Http\Controllers\LoaiKhachHangController;
use App\Http\Controllers\Bep;
use App\Http\Controllers\BepController;
use App\Http\Controllers\ChiTietNhapHangController;
use App\Http\Controllers\HoaDonNhapHangController;
use App\Http\Controllers\HoaDonNhapHangsController;
use App\Http\Controllers\MonAnController;
use App\Http\Controllers\NhaCungCapController;
use App\Http\Controllers\QuyenController;
// use App\Http\Controllers\NhaCungCapController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\TiepThuccontroller;
use App\Models\Ban;
use App\Models\ChiTietHoaDon;
use App\Models\KhachHang;
use App\Models\LoaiKhachHang;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [TestController::class, 'index']);

Route::get('/admin/login', [Admincontroller::class, 'viewlogin']);
Route::post('/admin/login', [Admincontroller::class, 'actionlogin']);

Route::get('/admin/loss-password', [Admincontroller::class, 'viewlosspassword']);
Route::post('/admin/loss-password', [Admincontroller::class, 'actionlosspassword']);

Route::get('/admin/update-password/{hash_reset}', [AdminController::class, 'viewupdatepassword']);
Route::post('/admin/update-password', [AdminController::class, 'actionupdatepassword']);

Route::group(['prefix' => '/admin', 'middleware' => 'CheckAminLogin'], function () {
    Route::get('/logout', [AdminController::class, 'actionlogout']);

    Route::group(['prefix' => '/khu-vuc'], function () {
        Route::get('/', [KhuVucController::class, 'index']);
        Route::get('/data', [KhuVucController::class, 'getData']);
        Route::post('/doi-trang-thai', [KhuVucController::class, 'doiTrangThai']);

        Route::post('/delete', [KhuVucController::class, 'destroy']);
        Route::post('/edit', [KhuVucController::class, 'edit']);
        Route::post('/create', [KhuVucController::class, 'store']);
        Route::post('/check-slug', [KhuVucController::class, 'checkslug']);
        Route::post('/update', [KhuVucController::class, 'update']);
    });

    Route::group(['prefix' => '/ban'], function () {
        Route::get('/', [BanController::class, 'index']);
        Route::get('/data', [BanController::class, 'getData']);
        Route::post('/doi-trang-thai', [BanController::class, 'doiTrangThai']);

        Route::post('/delete', [BanController::class, 'destroy']);
        Route::post('/edit', [BanController::class, 'edit']);
        Route::post('/create', [BanController::class, 'store']);
        Route::post('/check-slug', [BanController::class, 'Checkslug']);
        Route::post('/update', [BanController::class, 'update']);
        Route::post('/search', [BanController::class, 'search']);
        Route::post('/destroyalll', [BanController::class, 'destroyall'])->name('destoyall-ban');
    });

    Route::group(['prefix' => '/danh-muc'], function () {
        Route::get('/', [DanhMucController::class, 'index']);
        Route::get('/data', [DanhMucController::class, 'getData']);

        Route::post('doi-trang-thai', [DanhMucController::class, 'doiTrangThai']);
        Route::post('/delete', [DanhMucController::class, 'destroy']);
        Route::post('/edit', [DanhMucController::class, 'edit']);
        Route::post('/create', [DanhMucController::class, 'store']);
        Route::post('/check-slug', [DanhMucController::class, 'Checkslug']);
        Route::post('/update', [DanhMucController::class, 'update']);
        Route::post('/search', [DanhMucController::class, 'search']);
        Route::post('/destoyall', [DanhMucController::class, 'destoyall'])->name('destroyall-DanhMuc');
    });

    Route::group(['prefix' => '/mon-an'], function () {
        Route::get('/', [MonAnController::class, 'index']);
        Route::get('/vue', [MonAnController::class, 'index_vue']);
        Route::get('/data', [MonAnController::class, 'getData']);

        Route::post('doi-trang-thai', [MonAnController::class, 'doiTrangThai']);
        Route::post('/delete', [MonAnController::class, 'destroy']);
        Route::post('/edit', [MonAnController::class, 'edit']);
        Route::post('/create', [MonAnController::class, 'store']);
        Route::post('/check-slug', [MonAnController::class, 'Checkslug']);
        Route::post('/update', [MonAnController::class, 'update']);
        Route::post('/search', [MonAnController::class, 'search']);
        Route::post('/destroyall', [MonAnController::class, 'destroyall'])->name('destroyall');
    });
    Route::group(['prefix' => '/nha-cung-cap'], function () {
        Route::get('/', [NhaCungCapController::class, 'index']);
        Route::get('/data', [NhaCungCapController::class, 'getData']);

        Route::post('doi-trang-thai', [NhaCungCapController::class, 'doiTrangThai']);
        Route::post('/delete', [NhaCungCapController::class, 'destroy']);
        Route::post('/edit', [NhaCungCapController::class, 'edit']);
        Route::post('/create', [NhaCungCapController::class, 'store']);
        Route::post('/update', [NhaCungCapController::class, 'update']);
        Route::post('/ChecksMasothue', [NhaCungCapController::class, 'ChecksMasothue1']);
    });

    Route::group(['prefix' => '/ban-hang'], function () {
        Route::get('/', [HoaDonBanHangController::class, 'index']);
        Route::post('/tao-hoa-don', [HoaDonBanHangController::class, 'store']);
        Route::post('/find-id-by-idban', [HoaDonBanHangController::class, 'findidbyidban']);
        Route::post('/them-mon-an', [HoaDonBanHangController::class, 'addMonAnChiTietHoaDon']);
        Route::post('/danh-sach-mon-theo-hoa-don', [HoaDonBanHangController::class, 'getDanhSachMonTheoHoaDon']);
        Route::post('/update', [HoaDonBanHangController::class, 'update']);
        Route::post('/in-bep', [HoaDonBanHangController::class, 'inBep']);
        Route::post('/xoa-chi-tiet-ban-hang', [HoaDonBanHangController::class, 'xoachitiet'])->name('xoachitiet');
        Route::post('/Xac-Nhan-Khach', [HoaDonBanHangController::class, 'XacNhanKhach'])->name('5');
        Route::post('/Thanh-Toan', [HoaDonBanHangController::class, 'Thanhtoan'])->name('6');
        Route::get('/in-bill/{id}', [HoaDonBanHangController::class, 'inbill']);
        Route::post('/Up-date-Hoa-Don', [HoaDonBanHangController::class, 'UpdateHoaDon'])->name('updateHoaDon');
        ///Chi Tiết Hoá Đơn
        Route::post('/update-chiet-khau', [ChiTietHoaDonController::class, 'UpdateChiecKhau'])->name('update-chi-tiet-bang-hang');
        Route::post('/destroyall', [ChiTietHoaDonController::class, 'destroyall'])->name('destroyall-chi-tiet-bang-hang');
        Route::post('/chuyen-ban', [ChiTietHoaDonController::class, 'chuyenban'])->name('chuyen-ban');
        Route::post('/LoadDanhSachMonTheoHoaDonBanChuyen', [ChiTietHoaDonController::class, 'LoadDanhSachMonTheoHoaDonBanChuyen'])->name('2');
        Route::post('/ChuyenMonquabankhac', [ChiTietHoaDonController::class, 'ChuyenMonquabankhac'])->name('3');
    });

    Route::group(['prefix' => '/loai-khach-hang'], function () {
        Route::get('/', [LoaiKhachHangController::class, 'index']);
        Route::get('/data', [LoaiKhachHangController::class, 'getData']);

        Route::post('/delete', [LoaiKhachHangController::class, 'destroy']);
        Route::post('/edit', [LoaiKhachHangController::class, 'edit']);
        Route::post('/create', [LoaiKhachHangController::class, 'store']);
        Route::post('/update', [LoaiKhachHangController::class, 'update']);
        Route::post('/ten-loai-khach', [LoaiKhachHangController::class, 'ChecksMasothue1']);
        Route::post('/search', [LoaiKhachHangController::class, 'search']);
        Route::post('/destroyall', [LoaiKhachHangController::class, 'destroyall'])->name('destoyall-loai-khach-hang');
    });

    Route::group(['prefix' => '/khach-hang'], function () {
        Route::get('/', [KhachHangController::class, 'index']);
        Route::get('/data', [KhachHangController::class, 'getData'])->name('loadDaTa');

        Route::post('/delete', [KhachHangController::class, 'destroy']);
        Route::post('/edit', [KhachHangController::class, 'edit']);
        Route::post('/create', [KhachHangController::class, 'store']);
        Route::post('/ChecksMakhachhang', [KhachHangController::class, 'ChecksMakhachhang']);

        Route::post('/update', [KhachHangController::class, 'update']);
        Route::post('/search', [KhachHangController::class, 'search']);
        Route::post('/destroyall', [KhachHangController::class, 'destroyall'])->name('destoyall-khach-hang');
    });
    Route::group(['prefix' => '/bep'], function () {
        Route::get('/', [BepController::class, 'index']);
        Route::get('/data', [BepController::class, 'getData']);
        Route::post('/donemon', [BepController::class, 'donemon']);
        Route::post('/destroyall', [BepController::class, 'doneallmon'])->name('doneallmon-in-bep');
    });
    Route::group(['prefix' => '/tiep-thuc'], function () {
        Route::get('/', [TiepThuccontroller::class, 'indexTT']);
        Route::get('/data', [TiepThuccontroller::class, 'getDataTT']);
        Route::post('/donemonTT', [TiepThuccontroller::class, 'donemonTT']);
        Route::post('/destroyall', [TiepThuccontroller::class, 'doneallmon'])->name('doneallmon-tiep-thi');
    });
    Route::group(['prefix' => 'thong-ke'], function () {
        Route::get('/', [ThongKeController::class, 'index']);
        Route::post('/thong-ke-ban-hang', [ThongKeController::class, 'ThongKeBanHang'])->name('8');
        Route::post('/danh-sach-mon-theo-hoa-don', [HoaDonBanHangController::class, 'getDanhSachMonTheoHoaDonDaThanhToan'])->name('9');


        Route::get('/mon-an-ban', [ThongKeController::class, 'indexmonanban']);
        Route::post('/thong-ke-mon-an-ban-da-thanh-toan', [ThongKeController::class, 'ThongKeMonAnBan'])->name('10');
        Route::post('/danh-sach-mon-theo-mon', [HoaDonBanHangController::class, 'getDanhSachMonTheoHoaDonDatinhtien'])->name('11');

        //thong ke chart
        Route::get('/thong-ke-khach-an-nhieu', [ThongKeController::class, 'chartindex']);
        Route::post('/thong-ke-khach-hang', [ThongKeController::class, 'ThongKeKhach'])->name('Thong-Ke-Khach-Hang');

        Route::get('/Thong-ke-mon-an-ban-nhieu-nhat', [ThongKeController::class, 'indexMonAnNhieu']);
    });

    Route::group(['prefix' => 'nhap-hang'], function () {
        Route::get('/', [HoaDonNhapHangController::class, 'index']);
        Route::get('/data', [HoaDonNhapHangController::class, 'getData']);

        Route::post('/add-san-pham-nhap-hang', [HoaDonNhapHangController::class, 'addSanPhamNhapHang']);
        Route::post('/delete-mon-an', [HoaDonNhapHangController::class, 'deleteMonAnNhapHang']);
        Route::post('/update-chi-tiet-hoa-don-nhap', [HoaDonNhapHangController::class, 'updateChiTietHoaDonNhap']);
        Route::post('/nhap-hang-real', [HoaDonNhapHangController::class, 'nhapHangReal']);
        Route::post('/gui-mail', [HoaDonNhapHangController::class, 'guiMail']);
    });

    Route::group(['prefix' => 'tai-khoan'], function () {
        Route::get('/', [Admincontroller::class, 'viewTaiKhoan']);
        Route::post('/create', [Admincontroller::class, 'store']);
        Route::get('/data', [Admincontroller::class, 'getData']);
        Route::post('/delete', [Admincontroller::class, 'destroy']);
        Route::post('/update', [Admincontroller::class, 'update']);
        Route::post('/change-password', [Admincontroller::class, 'changePassword']);
    });
    Route::group(['prefix' => '/quyen'], function () {
        Route::get('/', [QuyenController::class, 'index']);
        Route::get('/data', [QuyenController::class, 'getData']);
        Route::get('/data-quyen', [QuyenController::class, 'getDataQuyen']);
        Route::post('/delete', [QuyenController::class, 'destroy']);
        Route::post('/create', [QuyenController::class, 'store']);
        Route::post('/update', [QuyenController::class, 'update']);
        Route::post('/search', [QuyenController::class, 'search']);
        Route::post('/delete-all', [QuyenController::class, 'deleteCheckbox']);
        Route::post('/phan-quyen', [QuyenController::class, 'phanQuyen']);
    });
});
