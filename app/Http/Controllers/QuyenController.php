<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quyen\DelQuyenrequest;
use App\Models\DanhSachChucNang;
use App\Models\Quyen;
use Illuminate\Http\Request;

class QuyenController extends Controller
{
    public function index()
    {
        $x          = $this->checkRule(7);
        if($x)  {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }
        return view('admin.page.quyen.index');
    }

    public function getData()
    {   $x          = $this->checkRule(8);
        if($x)  {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect('/');
        }
        $list = Quyen::get();

        $chucNang = DanhSachChucNang::get();

        return response()->json([
            'list'      => $list,
            'chuc_nang' => $chucNang
        ]);
    }

    public function getDataQuyen()
    {
        $chucNang = DanhSachChucNang::get();

        return response()->json([
            'data' => $chucNang
        ]);
    }

    public function store(Request $request)
    {
        $x          = $this->checkRule(9);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        $data = $request->all();
        Quyen::create($data);

        return response()->json([
            'status'    => true,
            'message'   => 'Đã tạo mới thành công!',
        ]);
    }

    public function update(Request $request)
    {   $x          = $this->checkRule(11);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        $quyen = Quyen::where('id', $request->id)->first();

        $data = $request->all();

        $quyen->update($data);

        return response()->json([
            'status'    => true,
            'message'   => 'Đã cập nhật được thông tin!',
        ]);
    }

    public function destroy(Request $request)
    {
        $x          = $this->checkRule(10);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        if($request->id == 1){
            return response()->json([
                'status'    => false,
                'message'   => 'Không thể xóa quyền ADMIN!'
            ]);
        }
        Quyen::find($request->id)->delete();

        return response()->json([
            'status'    => true,
            'message'   => 'Đã xóa quyền thành công!'
        ]);
    }

    public function search(Request $request)
    {
        $list = Quyen::select('quyens.*')
                     ->where('ten_quyen', 'like', '%' . $request->key_search . '%')
                     ->get();

        return response()->json([
            'list'  => $list
        ]);
    }

    public function deleteCheckbox(Request $request)
    {
        $x          = $this->checkRule(11);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        $data = $request->all();
        $str = "";
        foreach ($data as $key => $value) {
            if(isset($value['check'])){
                if($value['id'] == 1 && $value['check'] == true){
                    return response()->json([
                        'status'    => false,
                        'message'   => 'Vui lòng không chọn ADMIN để xóa thành công!',
                    ]);
                }
            }
            if(isset($value['check'])) {
                $str .= $value['id'] . ",";
            }

            $data_id = explode("," , rtrim($str, ","));

            foreach ($data_id as $k => $v) {
                $quyen = Quyen::where('id', $v);

                if($quyen) {
                    $quyen->delete();
                } else {
                    return response()->json([
                        'status'    => false,
                        'message'   => 'Đã có lỗi sự cố!',
                    ]);
                }
            }
        }

        return response()->json([
            'status'    => true,
            'message'   => 'Đã xóa thành công!',
        ]);
    }

    public function phanQuyen(Request $request)
    {
        $quyen      =  Quyen::find($request->id_quyen);
        $list_id_quyen =  implode(",", $request->list_phan_quyen);
        // dd($list_id_quyen);
        $quyen->update([
            'list_id_quyen' => $list_id_quyen
        ]);

        return response()->json([
            'status'  => true,
            'message' => "Cập nhập phân quyền cho Quyền " . $quyen->ten_quyen . " thành công!",
        ]);
    }
}
