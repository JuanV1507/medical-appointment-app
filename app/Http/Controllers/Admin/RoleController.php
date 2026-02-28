<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validar que se cree bien
        $request->validate([
            'name' => 'required|unique:roles,name'
        ]);
        //Crear el rol si pasa

        Role::create([
            'name' => $request->name
        ]);

        //confirmacion de que se creo el rol{}'Rol creado correctamente');
        session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Rol creado correctamente',
            'text' => 'El rol se ha creado exitosamente',
            ]
            );

            //Redireccionar a la tabla principal
            return redirect()->route('admin.roles.index')->with('success', 'Rol created successfully');
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
    public function edit(Role $role)
    {
        
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        // Validar que se cree bien y que excluya la fila que se esta editando
        $request->validate([
            'name' => 'required|unique:roles,name,'. $role->id,
        ]);

        // Actualizar el rol si pasa
        $role->update([
            'name' => $request->name,
        ]);

        // Confirmacion de que se actualizo el rol
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol actualizado correctamente',
            'text' => 'El rol se ha actualizado exitosamente',
        ]);

        // Redireccionar a la misma vista de editar
        return redirect(route('admin.roles.edit', $role));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //Borrar el rol
        
        $role->delete();

        // Confirmacion de que se borro el rol
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol eliminado correctamente',
            'text' => 'El rol se ha eliminado exitosamente',
        ]);

        // Redireccionar a la tabla principal
        return redirect()->route('admin.roles.index');
        
    }
}
