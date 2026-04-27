@php
    $errorGroups = [
        'antecedentes' => ['allergies', 'chronic_conditions', 'surgical_history', 'family_history'],
        'informacion-general' => ['blood_type_id', 'observations'],
        'contacto-emergencia' => ['emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship'],
        ];

    $initialTab = 'datos-personales';

    foreach ($errorGroups as $tabName => $fields) {
        if ($errors->hasAny($fields)) {
            $initialTab = $tabName;
            break;
        }
    }
@endphp

<x-admin-layout title="Pacientes | Healthify" :breadcrumbs="[
    [
        'name' => 'Dashboard', 
        'href' => route('admin.dashboard')
    ],
    [
        'name' => 'Pacientes',
        'href' => route('admin.patients.index')
    ],
    [
        'name' => 'Editar'
    ]
]">

    <form action="{{ route('admin.patients.update', $patient) }}" method="POST">
        @csrf
        @method('PUT')
        
        {{-- encabezado con fotos y acciones --}}
        <x-wireui-card class="mb-8">
            <div class="lg:flex lg:justify-between lg:items-center">
                <div class="flex items-center">
                    <img src="{{ $patient->user->profile_photo_url }}" alt="{{ $patient->user->name }}"
                        class="h-20 w-20 rounded-full object-cover object-center">
                    <div class="ml-4">
                        <p class="text-2xl font-bold text-gray-900">{{ $patient->user->name }}</p>
                        <p class="text-sm text-gray-500">ID: {{ $patient->id }}</p>
                    </div>
                </div>

                <div class="flex space-x-3 mt-6 lg:mt-0">
                    <x-wireui-button outline gray href="{{ route('admin.patients.index') }}">
                        <i class="fa-solid fa-arrow-left mr-2"></i>
                        Volver
                    </x-wireui-button>
                    <x-wireui-button type="submit" primary>
                        <i class="fa-solid fa-check mr-2"></i>
                        Guardar cambios
                    </x-wireui-button>
                </div>
            </div>
        </x-wireui-card>

        {{-- tabs de navegacion --}}
        <x-wireui-card>
            <div x-data="{tab: '{{ $initialTab }}'}">
                {{-- menu de pestañas --}}
                <div class="border-b border-gray-200">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
                        {{-- tab 1: datos personales --}}
                        <li class="me-2">
                            <a href="#" @click.prevent="tab = 'datos-personales'"
                                :class="{
                                    'text-blue-600 border-blue-600 active': tab === 'datos-personales',
                                    'border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'datos-personales'
                                }"
                                class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition-colors duration-200">
                                <i class="fa-solid fa-user me-2"></i>
                                Datos personales
                            </a>
                        </li>

                        {{-- tab 2: Antecedentes --}}
                         @php
                                $hasError = $errors->hasAny($errorGroups['antecedentes']);
                        @endphp

                        <li class="me-2">
                            <a href="#" @click.prevent="tab = 'antecedentes'"
                                :class="{
                                    'text-red-600 border-red-600' : {{$hasError ? 'true' : 'false'}} && tab !== 'antecedentes',
                                    'text-blue-600 border-blue-600 active' : tab === 'antecedentes' && !{{$hasError ? 'true' : 'false'}},
                                    'text-red-600 border-red-600 active' : tab === 'antecedentes' && {{$hasError ? 'true' : 'false'}},
                                    'border-transparent hover:text-blue-600 hover:border-gray-300' : tab !== 'antecedentes' && !{{$hasError ? 'true' : 'false'}},
                                }"
                                class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg hover:text-fg-brand group transition-colors duration-200
                                {{ $hasError ? 'text-red-600 border-red-600' : ''}}" 
                                :aria-current="tab === 'antecedentes' ? 'page' : undefined">

                                <i class="fa-solid fa-file-lines me-2"></i>
                                Antecedentes
                                 @if($hasError)
                                        <i class="fa-solid fa-circle-exclamation ms-2 animate-pulse"></i>
                                @endif
                            </a>
                        </li>
                        {{-- tab 3: Informacion general --}}
                         @php
                                $hasError = $errors->hasAny($errorGroups['informacion-general']);
                        @endphp

                        <li class="me-2">
                            <a href="#" @click.prevent="tab = 'informacion-general'"
                                :class="{
                                     'text-red-600 border-red-600' : {{$hasError ? 'true' : 'false'}} && tab !== 'informacion-general',
                                    'text-blue-600 border-blue-600 active' : tab === 'informacion-general' && !{{$hasError ? 'true' : 'false'}},
                                    'text-red-600 border-red-600 active' : tab === 'informacion-general' && {{$hasError ? 'true' : 'false'}},
                                    'border-transparent hover:text-blue-600 hover:border-gray-300' : tab !== 'informacion-general' && !{{$hasError ? 'true' : 'false'}},
                                }"  
                                class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg hover:text-fg-brand group transition-colors duration-200
                                {{ $hasError ? 'text-red-600 border-red-600' : ''}}"  
                                :aria-current="tab === 'informacion-general' ? 'page' : undefined">
                                
                                <i class="fa-solid fa-info me-2"></i>
                                Información general
                                @if($hasError)
                                        <i class="fa-solid fa-circle-exclamation ms-2 animate-pulse"></i>
                                @endif
                            </a>
                        </li>
                        {{-- tab 4: Contacto de emergencia --}}
                        @php
                                $hasError = $errors->hasAny($errorGroups['contacto-emergencia']);
                        @endphp

                        <li class="me-2">
                            <a href="#" @click.prevent="tab = 'contacto-emergencia'"
                                :class="{
                                    'text-red-600 border-red-600' : {{$hasError ? 'true' : 'false'}} && tab !== 'contacto-emergencia',
                                    'text-blue-600 border-blue-600 active' : tab === 'contacto-emergencia' && !{{$hasError ? 'true' : 'false'}},
                                    'text-red-600 border-red-600 active' : tab === 'contacto-emergencia' && {{$hasError ? 'true' : 'false'}},
                                    'border-transparent hover:text-blue-600 hover:border-gray-300' : tab !== 'contacto-emergencia' && !{{$hasError ? 'true' : 'false'}},
                                }"
                                class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg hover:text-fg-brand group transition-colors duration-200
                                {{ $hasError ? 'text-red-600 border-red-600' : ''}}"  
                                :aria-current="tab === 'contacto-emergencia' ? 'page' : undefined">
                                
                                <i class="fa-solid fa-heart me-2"></i>
                                Contacto de emergencia
                                @if($hasError)
                                        <i class="fa-solid fa-circle-exclamation ms-2 animate-pulse"></i>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- contenido de los tabs --}}
                <div class="px-4 mt-6">
                    {{-- TAB 1: DATOS PERSONALES --}}
                    <div x-show="tab === 'datos-personales'">
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg shadow-sm">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <i class="fa-solid fa-user-gear text-blue-500 text-xl mt-1"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-bold text-blue-800">
                                            Edición de cuenta de usuario
                                        </h3>
                                        <div class="mt-1 text-sm text-blue-600">
                                            <p>La <strong>información de acceso</strong> (Nombre, email y contraseña) debe registrarse desde la cuenta de usuario asociada.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <x-wireui-button primary sm href="{{ route('admin.users.edit', $patient->user) }}" target="_blank">
                                        Editar usuario
                                        <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                                    </x-wireui-button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid lg:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <label class="text-gray-500 font-semibold block mb-1">Teléfono:</label>
                                <p class="text-gray-900">{{ $patient->user->phone ?? 'No registrado' }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <label class="text-gray-500 font-semibold block mb-1">Email:</label>
                                <p class="text-gray-900">{{ $patient->user->email }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg lg:col-span-2">
                                <label class="text-gray-500 font-semibold block mb-1">Dirección:</label>
                                <p class="text-gray-900">{{ $patient->user->address ?? 'No registrada' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- TAB 2: ANTECEDENTES (con WireUI) --}}
                    <div x-show="tab === 'antecedentes'" style="display: none;">
                        <div class="grid lg:grid-cols-2 gap-6">
                            <x-wireui-textarea 
                                label="Alergias conocidas"
                                name="allergies"
                                placeholder="Ej: Penicilina, polen, mariscos, etc."
                                :value="old('allergies', $patient->allergies)"
                                rows="4"
                            />
                            
                            <x-wireui-textarea 
                                label="Enfermedades crónicas"
                                name="chronic_conditions"
                                placeholder="Ej: Diabetes, Hipertensión, Asma, etc."
                                :value="old('chronic_conditions', $patient->chronic_conditions)"
                                rows="4"
                            />
                            
                            <x-wireui-textarea 
                                label="Antecedentes quirúrgicos"
                                name="surgical_history"
                                placeholder="Ej: Apendicectomía (2020), Colecistectomía (2018)"
                                :value="old('surgical_history', $patient->surgical_history)"
                                rows="4"
                            />
                            
                            <x-wireui-textarea 
                                label="Antecedentes familiares"
                                name="family_history"
                                placeholder="Ej: Diabetes en padres, Hipertensión en abuelos"
                                :value="old('family_history', $patient->family_history)"
                                rows="4"
                            />
                        </div>
                    </div>

                    {{-- TAB 3: INFORMACION GENERAL (con WireUI) --}}
                    <div x-show="tab === 'informacion-general'" style="display: none;">
                        <div class="space-y-6">
                            <x-wireui-select 
                                label="Tipo de sangre"
                                name="blood_type_id"
                                :options="$bloodTypes"
                                option-label="name"
                                option-value="id"
                                :value="old('blood_type_id', $patient->blood_type_id)"
                                placeholder="Selecciona un tipo de sangre"
                                clearable
                            />
                            
                            <x-wireui-textarea 
                                label="Observaciones generales"
                                name="observations"
                                placeholder="Información adicional relevante sobre el paciente..."
                                :value="old('observations', $patient->observations)"
                                rows="5"
                            />
                        </div>
                    </div>

                    {{-- TAB 4: CONTACTO DE EMERGENCIA (con WireUI) --}}
                    <div x-show="tab === 'contacto-emergencia'" style="display: none;">
                        <div class="grid lg:grid-cols-2 gap-6">
                            <x-wireui-input 
                                label="Nombre completo"
                                name="emergency_contact_name"
                                placeholder="Ej: María González Pérez"
                                :value="old('emergency_contact_name', $patient->emergency_contact_name)"
                                icon="user"
                            />

                            <x-wireui-input 
                                label="Teléfono de contacto"
                                name="emergency_contact_phone"
                                mask="(###) ###-####"
                                placeholder="Ej: (999)999-9999"
                                :value="old('emergency_contact_phone', $patient->emergency_contact_phone)"
                                icon="phone"
                            />

                            <x-wireui-input 
                                label="Parentesco / Relación"
                                name="emergency_contact_relationship"
                                placeholder="Ej: Madre, Padre, Hermano, Esposo/a"
                                :value="old('emergency_contact_relationship', $patient->emergency_contact_relationship)"
                                icon="users"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </x-wireui-card>
    </form>

</x-admin-layout>