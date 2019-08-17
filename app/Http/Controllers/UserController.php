<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Kelas;
use App\TahunAjaran;
use App\KelasUser;
use App\Spp;
use App\JenistUser;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role', 'Siswa')->get();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::orderBy('nama', 'asc')->get();
        $tahun_ajaran = TahunAjaran::orderBy('tahun', 'desc')->get();

        return view('user.create', compact('kelas', 'tahun_ajaran'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'image|max:1999',
            'password' => 'same:password1',
            'username' => 'unique:users,username',
            'email' => 'unique:users,email'
        ],
        [
            'avatar.image' => 'Avatar harus berupa gambar',
            'avatar.max' => 'Ukuran maksimal gambar adalah 2 MB',
            'same' => 'Konfirmasi Password Tidak Sesuai',
            'username.unique' => 'Username Sudah Digunakan',
            'email.unique' => 'Email Sudah Digunakan'
        ]);

        $user = new User;
        $user->no_induk = $request->input('no_induk');
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->no_hp = $request->input('no_hp');
        $user->alamat = $request->input('alamat');
        $user->password = Hash::make($request->input('password'));
        
        if($request->hasFile('avatar')){
            $filenameWithExt = $request->file('avatar')->getClientOriginalName();
            $filename = pathInfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $FileNameToStore = $filename.'_'.time().'_.'.$extension;    
            $path = public_path('/img/avatar/');
            $request->file('avatar')->move($path, $FileNameToStore);

            $user->avatar = $FileNameToStore;
        }
        if($request->hasFile('ttd')){
            $filenameWithExt = $request->file('ttd')->getClientOriginalName();
            $filename = pathInfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('ttd')->getClientOriginalExtension();
            $FileNameToStore = $filename.'_'.time().'_.'.$extension;    
            $path = public_path('/img/ttd/');
            $request->file('ttd')->move($path, $FileNameToStore);

            $user->ttd = $FileNameToStore;
        }

        $user->nama_ayah = $request->input('nama_ayah');
        $user->pekerjaan_ayah = $request->input('pekerjaan_ayah');
        $user->nama_ibu = $request->input('nama_ibu');
        $user->pekerjaan_ibu = $request->input('pekerjaan_ibu');
        $user->nama_wali = $request->input('nama_wali');
        $user->pekerjaan_wali = $request->input('pekerjaan_wali');
        $user->alamat_wali = $request->input('alamat_wali');

        $user->save();

        $lastuser = User::orderBy('id', 'desc')->first();
        
        $kelas_user = new KelasUser;
        $kelas_user->user_id = $lastuser->id;
        $kelas_user->kelas_id = $request->input('kelas_id');
        $kelas_user->tahun_id = $request->input('tahun_id');
        $kelas_user->save();

        return redirect('/user')->with('success', 'Akun Siswa Telah Dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        if((auth()->user()->role == 'Admin') || (auth()->user()->id == $user->id)) {
            if($user->role == 'Siswa') {
                return view('user.siswa.show', compact('user'));
            } else {
                return view('user.staff.show', compact('user'));
            }
        } else {
            return redirect('/');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        if((auth()->user()->role == 'Admin') || (auth()->user()->id == $user->id)) {
            if($user->role == 'Siswa') {
                $kelas = Kelas::orderBy('nama', 'asc')->get();
                $tahun_ajaran = TahunAjaran::orderBy('tahun', 'desc')->get();
                return view('user.siswa.edit', compact('user', 'kelas', 'tahun_ajaran'));
            } else {
                return view('user.staff.edit', compact('user'));
            }
        } else {
            return redirect('/');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'avatar' => 'image|max:1999'
        ],
        [
            'avatar.image' => 'Avatar harus berupa gambar',
            'avatar.max' => 'Ukuran maksimal gambar adalah 2 MB'
        ]);

        $user = User::findOrFail($id);
        $user->no_induk = $request->input('no_induk');
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->no_hp = $request->input('no_hp');
        $user->alamat = $request->input('alamat');
        
        if($request->hasFile('avatar')){
            $filenameWithExt = $request->file('avatar')->getClientOriginalName();
            $filename = pathInfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $FileNameToStore = $filename.'_'.time().'_.'.$extension;    
            $path = public_path('/img/avatar/');
            $request->file('avatar')->move($path, $FileNameToStore);
            
            if ($user->avatar !== 'no_avatar.png') {
                $file = public_path('/img/avatar/'.$user->avatar);
                unlink($file);
            }
            $user->avatar = $FileNameToStore;
        }

        if($request->hasFile('ttd')){
            $filenameWithExt = $request->file('ttd')->getClientOriginalName();
            $filename = pathInfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('ttd')->getClientOriginalExtension();
            $FileNameToStore = $filename.'_'.time().'_.'.$extension;    
            $path = public_path('/img/ttd/');
            $request->file('ttd')->move($path, $FileNameToStore);
            
            if ($user->ttd !== 'no_image.png') {
                $file = public_path('/img/ttd/'.$user->ttd);
                unlink($file);
            }
            $user->ttd = $FileNameToStore;
        }

        if($user->role == 'Siswa') {
            $user->nama_ayah = $request->input('nama_ayah');
            $user->pekerjaan_ayah = $request->input('pekerjaan_ayah');
            $user->nama_ibu = $request->input('nama_ibu');
            $user->pekerjaan_ibu = $request->input('pekerjaan_ibu');
            $user->nama_wali = $request->input('nama_wali');
            $user->pekerjaan_wali = $request->input('pekerjaan_wali');
            $user->alamat_wali = $request->input('alamat_wali');
        }

        $user->save();

        return redirect('/user/'.$id)->with('success', 'Profil telah diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $kelas_user = KelasUser::where('user_id', $id)->get();
        if(count($kelas_user) > 0) {
            foreach($kelas_user as $ku) {
                $ku->delete();
            }
        }
        $tagihanuser = JenistUser::where('user_id', $id)->get();
        if(count($tagihanuser) > 0) {
            foreach($tagihanuser as $tu) {
                $uang = Uang::orderBy('id', 'asc')->first();
                $uang->masuk = $uang->masuk - $tu->nominal;
                $uang->save();
                $tu->delete();
            }
        }
        $sppuser = Spp::where('user_id', $id)->get();
        if(count($sppuser) > 0) {
            foreach($sppuser as $su) {
                $uang = Uang::orderBy('id', 'asc')->first();
                $uang->masuk = $uang->masuk - $su->dibayar;
                $uang->save();
                $su->delete();
            }
        }

        if ($user->avatar !== 'no_avatar.png') {
            $file = public_path('/img/avatar/'.$user->avatar);
            unlink($file);
        }
        
        $user->delete();

        return redirect('/user')->with('success', 'Akun siswa telah berhasil dihapus.');
    }

    //Edit Password
    public function editpassword($id) {
        if(auth()->user()->id == $id) {
            $user = User::findOrFail($id);
            return view('user.editpassword', compact('user'));

        } else {
            return redirect('/')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
        }

    }

    public function editpassword1(Request $request, $id) {

        $this->validate($request, [
            'password' => 'same:password1'
            ],
            [
                'same' => 'Konfirmasi Password Baru Tidak Sesuai'
            ]);
        $oldpassword = $request->input('oldpassword');
        $user = User::findOrFail($id);
        if (Hash::check($oldpassword, $user->password)) {
            $user->password = Hash::make($request->input('password1'));
            $user->save();

            return redirect('/user/'.$id)->with('success', 'Password Berhasil Diperbaharui.');
        } else {
            return redirect('/editpassword/'.$id.'/user')->with('error', 'Password Lama Tidak Sesuai.');
        }
    }
}
