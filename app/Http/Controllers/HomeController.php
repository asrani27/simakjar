<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Soal;
use App\Models\Toko;
use App\Models\Waktu;
use App\Models\Banner;
use App\Models\Produk;
use App\Models\Profil;
use App\Models\Jawaban;
use App\Models\Layanan;
use App\Models\Pegawai;
use App\Models\Peserta;
use App\Models\Kategori;
use App\Models\Pengajuan;
use App\Models\BenarSalah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function user()
    {
        $tp = count(Produk::where('toko_id', Auth::user()->toko->id)->get());
        $pt = Auth::user()->toko->nama_toko;
        $data = Auth::user()->toko;
        return view('user.home',compact('tp','pt','data'));
    }

    public function superadmin()
    {       
        $pu = count(Toko::get());
        $pr = count(Produk::get());
        $kat = count(Kategori::get());
        return view('superadmin.home',compact('pu','pr','kat'));
    }

    public function gantipass()
    {
        return view('superadmin.gantipass.index');
    }

    public function resetpass(Request $req)
    {
        if($req->password1 == $req->password2){
            $u = Auth::user();
            $u->password = bcrypt($req->password1);
            $u->save();
    
            Auth::logout();
            toastr()->success('Berhasil Di Ubah, Login Dengan Password Baru');
            return redirect('/');
        }else{
            toastr()->error('Password Tidak Sama');
            return back();
        }
    }

    public function soal()
    {
        return Soal::get();
    }

    public function pegawai()
    {    
        $page = 'profil';
        $pegawai = Auth::user()->pegawai;
        $layanan = Layanan::get();
        $pengajuan = Pengajuan::where('pegawai_id', $pegawai->id)->get();
        return view('pegawai.home',compact('page','pegawai','layanan','pengajuan'));
    }

    public function welcome()
    {
        $produk = Produk::orderBy('created_at', 'DESC')->paginate(6);
        $banner = Banner::get();
        $kategori = Kategori::get();
        $profil = Profil::first();
        return view('welcome',compact('produk','banner','kategori','profil'));
    }

    public function tentang()
    {
        $kategori = Kategori::get();
        $profil = Profil::first();
        return view('tentang',compact('kategori','profil'));
    }
    
    public function kontak()
    {
        $kategori = Kategori::get();
        $profil = Profil::first();
        return view('kontak',compact('kategori','profil'));
    }

    public function semuaproduk()
    {
        $produk = Produk::orderBy('created_at','DESC')->paginate(24);
        $kategori = Kategori::get();
        $profil = Profil::first();
        return view('semuaproduk',compact('kategori','profil','produk'));
    }
    public function kategoriproduk($id)
    {
        $produk = Produk::where('kategori_id', $id)->orderBy('created_at','DESC')->paginate(24);
        $kategori = Kategori::get();
        $namaKategori = Kategori::find($id);
        $profil = Profil::first();
        return view('kategoriproduk',compact('kategori','profil','produk','namaKategori'));
    }

    public function cariProduk()
    {
        $kategori_id = request()->kategori_id;
        $kategori = Kategori::get();
        $profil = Profil::first();
        $namaKategori = Kategori::find($kategori_id);
        $search = request()->search;

        if($kategori_id == null){
            $produk = Produk::where('nama','LIKE','%'.$search.'%')->orderBy('created_at','DESC')->paginate(24);
        }else{
            $produk = Produk::where('kategori_id', $kategori_id)->where('nama','LIKE','%'.$search.'%')->orderBy('created_at','DESC')->paginate(24);
        }
        
        request()->flash();
        return view('search',compact('kategori','profil','produk','namaKategori','search'));
    }

    public function detailProduk($id)
    {
        $kategori = Kategori::get();
        $profil = Profil::first();
        $produk = Produk::find($id);
        $data = Produk::get();
        return view('detail',compact('profil','kategori','produk','data'));
    }

    public function pengrajin()
    {
        $kategori = Kategori::get();
        $profil = Profil::first();
        $pengrajin = Toko::get();
        return view('pengrajin',compact('profil','kategori','pengrajin'));
    }
}
