<x-admin-layout title="Pacientes | Healthify" :breadcrumbs="[
    [
        'name' => 'Dashboard', 
        'href' => route('admin.dashboard')],

    [
        'name' => 'Pacientes',
        
        
    ],  
]">

@livewire('admin.datatable.patients-table')

</x-admin-layout>