<x-admin-layout title="Usuarios" :breadcrumbs="[
    ['name' => 'Dashboard','route' => route('admin.dashboard')],
    ['name' => 'Usuarios','route' => route('admin.users.index')],
    ['name' => 'Crear'],
]">

<x-wireui-card>
    <x-validation-errors class="mb-4" />
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div class="grid lg:grid-cols-2 gap-4">
        <x-wireui-input 
            label="Nombre" 
            name="name" 
            placeholder="Nombre del usuario" required
            :value="old('name')" 
        ></x-wireui-input>

        <x-wireui-input 
            label="Correo electronico" 
            name="email" 
            type="email"
            placeholder="Correo electronico del usuario" required
            autocomplete="email"
            :value="old('email')" 
        ></x-wireui-input>

         <x-wireui-input 
            label="Contraseña" 
            name="password" 
            type="password"
            placeholder="Minimo 8 caracteres" required
            aria-autocomplete="new-password" 
        ></x-wireui-input>
        
         <x-wireui-input 
            label="Confirmar contraseña" 
            name="password_confirmation" 
            type="password"
            placeholder="Repita la contraseña" required
            aria-autocomplete="new-password" >
         </x-wireui-input>

        <x-wireui-input 
            label="Numero de id" 
            name="id_number" 
            placeholder="Ej: 555-555-5555" autocomplete="off" required
            inputmode="numeric"
            :value="old('id_number')">
        </x-wireui-input>

         <x-wireui-input
            label="Telefono" 
            name="phone" 
            placeholder="Ej: 555-555-5555" autocomplete="tel" required
            inputmode="tel"
            :value="old('phone')">
         </x-wireui-input>

    </div>

            <x-wireui-input  
                name="address" 
                label="Direcccion" required :value="old('address')"
                placeholder="Ej. Calle 90 293" autocomplete="street-address"
                >
            </x-wireui-input>

            <div class="space-y-1">
                <x-wireui-native-select name="role_id" label="Rol" required>
                    <option value="">Seleccione un rol</option>
                
                @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected (old('role_id') == $role->id) >
                            {{ $role->name }}
                        </option>
                    @endforeach
                </x-wireui-native-select>
                <p class="text-sm text-gray-500">
                    Define los permisos y accesos del usuario
                </p>
            </div>

        <div class="flex justify-end">
            <x-wireui-button type="submit" primary>
                Guardar
            </x-wireui-button>
        </div>
    </div>
    </form>
</x-wireui-card>

</x-admin-layout>