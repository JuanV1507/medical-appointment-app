<x-admin-layout title="Roles" :breadcrumbs="[
    ['name' => 'Dashboard','route' => route('admin.dashboard')],
    ['name' => 'Roles','route' => route('admin.roles.index')],
    ['name' => 'Crear'],
]">

<x-wireui-card>
    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf

        <x-wireui-input 
            label="Nombre" 
            name="name" 
            placeholder="Nombre del rol" 
            :value="old('name')" 
        />

        <div class="flex justify-end mt-4">
            <x-wireui-button type="submit" primary>
                Guardar
            </x-wireui-button>
        </div>
    </form>
</x-wireui-card>

</x-admin-layout>