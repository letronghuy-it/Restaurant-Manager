<?php

namespace App\Http\Controllers;

use App\Http\Requests\adminBoos\Changepasswordadminrequest as AdminBoosChangepasswordadminrequest;
use App\Http\Requests\adminBoos\CreateAdminrequest as AdminBoosCreateAdminrequest;
use App\Http\Requests\adminBoos\CreateAdminreuqest;
use App\Http\Requests\adminBoos\Deleteadminrequest as AdminBoosDeleteadminrequest;
use App\Http\Requests\adminBoos\Updateadminrequest as AdminBoosUpdateadminrequest;
use App\Http\Requests\AdminThemmoirequest;
use App\Http\Requests\ChangePassWordAdminRequest;
use App\Http\Requests\CreateAdMinRequest;
use App\Http\Requests\DeleteAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Mail\QuenMatKhau;
use App\Models\Admin;
use App\Models\Quyen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Admincontroller extends Controller
{
    public function viewupdatepassword($hash_reset)
    {
        $taikhoan = Admin::where('hash_reset', $hash_reset)->first();
        if ($taikhoan) {
            return view('admin.page.login.updatepassword', compact('hash_reset'));
        } else {
            toastr()->error("Mật Khẩu Không Tồn Tại");
            return redirect('/admin/login');
        }
    }
    public function actionupdatepassword(Request $request)
    {
        if ($request->password != $request->re_password) {
            toastr()->error("Mật KhẨU Không Trùng Nhau");
            return redirect()->back();
        }
        $taikhoan = Admin::where('hash_reset', $request->hash_reset)->first();
        if (!$taikhoan) {
            toastr()->error("Mật KhẨU Không Tồn Tại");
            return redirect()->back();
        } else {
            $taikhoan->password   = bcrypt($request->password);
            $taikhoan->hash_reset = NULL;
            $taikhoan->save();
            toastr()->error("Đổi mật khẩu thành công");
            return redirect('/admin/login');
        }
    }

    public function actionlogout()
    {
        Auth::guard('admin')->logout();
        toastr()->error("Đã Đăng Xuất Thành Công!");
        return redirect('/admin/login');
    }
    public function viewlosspassword()
    {
        return view('admin.page.login.losspassword');
    }
    public function actionlosspassword(Request $request)
    {
        $taikhoan = Admin::where('email', $request->email)->first();
        if ($taikhoan) {
            $now  = Carbon::now();
            $time = $now->diffInMinutes($taikhoan->updated_at);

            if (!$taikhoan->hash_reset || $time > 15) {
                $taikhoan->hash_reset = Str::uuid();
                $taikhoan->save();

                $link = env('APP_URL') . '/admin/update-password' . $taikhoan->hash_reset;

                Mail::to($taikhoan->email)->send(new QuenMatKhau($link));
            }
            toastr()->success("Vui lòng kiểm tra email để đặt lại mật khẩu!");
            return redirect('/admin/login');
        }
        toastr()->error("Đăng nhập không thành công!");
        return redirect('/admin/loss-password');
    }
    public function viewlogin()
    {
        return view('admin.page.login.login');
    }
    public function actionlogin(Request $request)
    {
        $check = Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);
        if ($check) {
            toastr()->success("Đã Đăng Nhập Thành Công !");
            return redirect('/');
        } else {
            toastr()->error("Đăng Nhập Không Thành Công !");
            return redirect('/admin/login');
        }
    }

    public function viewTaiKhoan()

    {
        $x = $this->checkRule(6);

        if ($x) {
            toastr()->error("Bạn Không Đủ Quyền Truy Cập !");
            return redirect('/');
        }
        $Quyen = Quyen::get();
        return view('admin.page.Tai_Khoan.index', compact('Quyen'));
    }
    public function store(AdminBoosCreateAdminrequest $request)
    {
        $x = $this->checkRule(1);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $data = $request->all();
        $data['password'] =  bcrypt($request->password);
        Admin::create($data);

        return response()->json([
            'status'    => true,
            'message'   => 'Đã tạo tài khoản thành công!'
        ]);
    }
    public function getData()
    {
        $x = $this->checkRule(2);

        if ($x) {
            toastr()->error("Bạn Không Đủ Quyền Truy Cập !");
            return redirect('/');
        }
        $list = Admin::join('quyens', 'admins.id_quyen', 'quyens.id')
            ->select('admins.*', 'quyens.ten_quyen')
            ->get();

        return response()->json([
            'list'  => $list
        ]);
    }
    public function destroy(AdminBoosDeleteadminrequest $request)
    {
        $x = $this->checkRule(5);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $admin = Admin::where('id', $request->id)->first();
        $admin->delete();
        return response()->json([
            'status'    => true,
            'message'   => 'Đã xóa thành công!',
        ]);
    }
    public function update(AdminBoosUpdateadminrequest $request)
    {

        $x = $this->checkRule(4);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $data    = $request->all();
        $admin = Admin::find($request->id);
        $admin->update($data);

        return response()->json([
            'status'    => true,
            'message'   => 'Đã cập nhật thành công!',
        ]);
    }
    public function changePassword(AdminBoosChangepasswordadminrequest $request)
    {
        $x = $this->checkRule(3);

        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn Không Đủ Quyền Truy Cập!',
            ]);
        }
        $data = $request->all();
        if (isset($request->password)) {
            $admin = Admin::find($request->id);
            $data['password'] = bcrypt($data['password_new']);
            $admin->password = $data['password'];
            $admin->save();
        }
        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật mật khẩu thành công!',
        ]);
    }
}
