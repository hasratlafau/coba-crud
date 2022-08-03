<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;


class EmployeeController extends Controller
{
    //method untuk memanggil file datapegawai.blade.php yang berada di folder views
    public function index(Request $request){
        if($request->has('search')){
            $data = Employee::where('nama', 'LIKE','%' .$request->search.'%')->paginate(5);
            Session::put('halaman_url', request()->fullUrl());   
            
        }else{
            $data = Employee::paginate(5); //Models Employee 
            
            //session halaman pagination yang sedang berjalan
            Session::put('halaman_url', request()->fullUrl());  
        } 
        
        return view('datapegawai', compact('data'));
    }

    //method untuk memanggil file tambahdata.blade.php yang berada di folder views
    public function tambahpegawai(){
        return view('tambahdata');
    }

    //method menginput data
    public function insertdata(Request $request){
        // dd($request->all()); //untuk mencoba dlu kalo inputan terbaca atau tidak
        //validation in laravel 8
        $this->validate($request, [
            'nama' => 'required|min:3|max:50',
            'notlp' => 'required|min:9|max:13',
            'jenkel' => 'required|in:cowo,cewe',
            'foto' => 'required',
        ]);
        
        $data = Employee::create($request->all());
        if($request->hasFile('foto')){
            $request->file('foto')->move('fotopegawai/', $request->file('foto')->getClientOriginalName());
            $data->foto = $request->file('foto')->getClientOriginalName();
            $data->save();
        }

        return redirect()->route('pegawai')->with('success', ' Data Berhasil Di Tambahkan');
        
    }

    //method menampilkan data
    public function tampildata($id){
        $data = Employee::find($id);
        // dd($data);

        return view('tampildata', compact('data'));
    }

    //method edit/update
    public function updatedata(Request $request, $id){
        $data = Employee::find($id);
        $data -> update($request->all());

        //redirect ke halaman pagination data yang di update
        if(Session('halaman_url')){
            return Redirect(session('halaman_url'))->with('success', ' Data Berhasil Di Update');
        }

        //redirect ke halaman pegawai
        return redirect()->route('pegawai')->with('success', ' Data Berhasil Di Update');
    }

    //method hapus
    public function delete($id){
        $data = Employee::find($id);
        $data->delete();

        //redirect ke halaman pagination data yang di hapus
        if(Session('halaman_url')){
            return Redirect(session('halaman_url'))->with('success', ' Data Berhasil Di Hapus');
        }
        return redirect()->route('pegawai')->with('success', ' Data Berhasil Di Hapus');
    }

    public function exportpdf(){
        $data = Employee::all();

        view()->share('data' , $data);
        $pdf = PDF::loadview('datapegawai-pdf');
        return $pdf->download('data.pdf');        
    }

    public function exportexcel(){
        return Excel::download(new EmployeeExport, 'datapegawai.xlsx');
    }

    public function importexcel(Request $request){
        $data =$request->file('file');

        $namafile = $data->getClientOriginalName();
        $data->move('EmployeeData', $namafile);

        Excel::import(new EmployeeImport, \public_path('/EmployeeData/'.$namafile));
        return \redirect()->back();
    }

}
