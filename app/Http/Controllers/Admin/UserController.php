<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'id_number' => 'required|string|min:5|max:20|regex:/^[A-Za-z0-9]+$/|unique:users',
            'phone' => 'required|digits_between:7,15',
            'address' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::create($data);
        $user->roles()->attach($data['role_id']);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario creado exitosamente.',
            'text' => 'El usuario ha sido creado correctamente.'
        ]);

        //si el usuario creado es un paciente, redirigir a la creación del paciente
        if($user->role('Paciente')){
            //CREAR EL REGISTRO DE UN PACIENTE
            $patient = $user->patient()->create([]);

            return redirect()->route('admin.patients.edit', $patient);
        
        }
        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'id_number' => 'required|string|min:5|max:20|regex:/^[A-Za-z0-9]+$/|unique:users,id_number,' . $user->id,
            'phone' => 'required|digits_between:7,15',
            'address' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user->update($data);
        //si el usuario quiere editar la contrase;a que lo guarde

        if($request->filled('password')){
           $user->password = bycrypt($request->password);
              $user->save();
        }



        $user->roles()->sync($data['role_id']);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario actualizado.',
            'text' => 'El usuario ha sido actualizado correctamente.'
        ]);
        return redirect()->route('admin.users.edit', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {

    //no permitir que un usuario se elimine a si mismo
        if(auth()->id() == $user->id){
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Acción no permitida.',
                'text' => 'No puedes eliminar a ti mismo.'
            ]);
            abort(403, 'No puedes eliminar tu propio usuario.');
            return redirect()->route('admin.users.index');
        }
        //eliminar roles asociados al usuario
        $user->roles()->detach();
        $user->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario eliminado.',
            'text' => 'El usuario ha sido eliminado correctamente.'
        ]);
        return redirect()->route('admin.users.index');
    }
}
