<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('query');
        if (!empty($query)) {
            $pengguna = User::where("name", "like", "%" . $query . '%')->latest()->paginate(10);;
        } else {
            $pengguna = User::latest()->paginate(10);
        }
        return view("admin.user.index")->with(['users' => $pengguna,'q'=>$query]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create', ['users' => User::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:8',
            // 'roles' => 'required|in:admin,owner_umkm',
            // 'status' => 'required|in:active,disable',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = new User();
        $alias = $user->getAlias($validated['name']);
        $validated['alias'] = $alias;
        User::create($validated);

        return redirect('admin/user')->with('success', 'User Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.user.edit', ['users' => User::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            // 'roles' => 'required|in:admin,owner_umkm',
        ]);
        $user = User::findOrFail($id);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if (!empty($request->password)) {
            $request->validate([
                'password' => 'min:8',
            ]);
            $user->password = Hash::make($request->password);
        }
        if ($user->name != $validated['name']) {
            $user->alias = $this->getAlias($validated['name']);
        }
        // $user->roles = $validated['roles'];
        $user->save();
        return redirect('admin/user')->with('success', 'User berhasil diperbarui');
    }

    public function updateStatus($id)
    {
        $user = User::where('id', $id)->first();
        if ($user->status == 'active') {
            User::where('id', $id)->update([
                'status' => 'disable',
            ]);
        } else {
            User::where('id', $id)->update([
                'status' => 'active',
            ]);
        }
        return redirect('admin/user')->with('warning', 'Status user berhasil di Update');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
        return redirect('admin/user')->with('danger', 'User berhasil dihapus');
    }
}
