<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Citas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                @if (session()->has('message'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                @endif

                @if($isCreating)
                    <!-- Create Form (Two Column Layout like Image 2) -->
                    <div>
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Nuevo</h3>
                            <button wire:click="cancel" class="text-gray-500 hover:text-gray-700">
                                Volver a la lista
                            </button>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Left Panel: Buscar disponibilidad -->
                            <div class="lg:col-span-2 space-y-6">
                                <div class="bg-white p-6 rounded-lg border shadow-sm">
                                    <h4 class="text-lg font-bold text-gray-900 mb-2">Buscar disponibilidad</h4>
                                    <p class="text-sm text-gray-500 mb-4">Encuentra el horario perfecto para tu cita.</p>
                                    
                                    <form wire:submit.prevent="searchAvailability" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                                            <input wire:model="searchDate" type="date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            @error('searchDate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="md:col-span-1">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Hora inicio</label>
                                            <input wire:model="searchStartTime" type="time" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            @error('searchStartTime') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="md:col-span-1">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Especialidad (opcional)</label>
                                            <select wire:model="searchSpecialty" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option value="">Todas</option>
                                                @foreach($specialties as $specialty)
                                                    <option value="{{ $specialty }}">{{ $specialty }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded">
                                                Buscar disponibilidad
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Available Doctors List -->
                                @if(!empty($availableDoctors))
                                    <div class="space-y-4">
                                        @foreach($availableDoctors as $item)
                                            <div class="bg-white p-6 rounded-lg border shadow-sm flex flex-col md:flex-row gap-6">
                                                <!-- Avatar/Info -->
                                                <div class="flex items-center gap-4 min-w-[250px]">
                                                    <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xl">
                                                        {{ strtoupper(substr($item['doctor']->user->name ?? 'D', 0, 2)) }}
                                                    </div>
                                                    <div>
                                                        <h5 class="text-lg font-bold text-gray-900">{{ $item['doctor']->user->name ?? 'Doctor' }}</h5>
                                                        <p class="text-indigo-600 text-sm">{{ $item['doctor']->specialty }}</p>
                                                    </div>
                                                </div>
                                                
                                                <!-- Slots -->
                                                <div class="flex-1 border-t md:border-t-0 md:border-l pt-4 md:pt-0 md:pl-6 border-gray-200">
                                                    <p class="text-sm font-medium text-gray-700 mb-3">Horarios disponibles:</p>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach($item['slots'] as $slot)
                                                            <button wire:click="selectTimeSlot({{ $item['doctor']->id }}, '{{ $item['doctor']->user->name ?? 'Doctor' }}', '{{ $slot }}')" 
                                                                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors
                                                                    {{ $selectedDoctorId == $item['doctor']->id && $selectedStartTime == $slot ? 'bg-indigo-600 text-white' : 'bg-indigo-100 text-indigo-700 hover:bg-indigo-200' }}">
                                                                {{ $slot }}
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <!-- Right Panel: Resumen de la cita -->
                            <div class="lg:col-span-1">
                                <div class="bg-gray-50 p-6 rounded-lg border">
                                    <h4 class="text-lg font-bold text-gray-900 mb-4">Resumen de la cita</h4>
                                    
                                    <div class="space-y-3 mb-6 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Doctor:</span>
                                            <span class="font-medium text-gray-900">{{ $selectedDoctorName ?? '-' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Fecha:</span>
                                            <span class="font-medium text-gray-900">{{ $selectedDate ? \Carbon\Carbon::parse($selectedDate)->format('Y-m-d') : '-' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Horario:</span>
                                            <span class="font-medium text-gray-900">
                                                @if($selectedStartTime)
                                                    {{ $selectedStartTime }} - {{ $selectedEndTime }}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Duración:</span>
                                            <span class="font-medium text-gray-900">15 minutos</span>
                                        </div>
                                    </div>

                                    <form wire:submit.prevent="save">
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Paciente</label>
                                                <select wire:model="patient_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                    <option value="">Seleccione un paciente</option>
                                                    @foreach($patients as $patient)
                                                        <option value="{{ $patient->id }}">{{ $patient->user->name ?? 'Paciente ' . $patient->id }}</option>
                                                    @endforeach
                                                </select>
                                                @error('patient_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Motivo de la cita</label>
                                                <textarea wire:model="reason" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Ej. Chequeo de rutina..."></textarea>
                                                @error('reason') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>

                                            @if($selectedDoctorId)
                                                <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-3 px-4 rounded mt-4">
                                                    Confirmar cita
                                                </button>
                                            @else
                                                <button type="button" disabled class="w-full bg-gray-300 text-gray-500 font-bold py-3 px-4 rounded mt-4 cursor-not-allowed">
                                                    Seleccione un horario
                                                </button>
                                            @endif
                                            
                                            @if($errors->any() && !$selectedDoctorId)
                                                <p class="text-red-500 text-xs mt-2 text-center">Asegúrese de seleccionar un horario antes de guardar.</p>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                @else
                    <!-- List Table -->
                    <div>
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold text-gray-900">Listado de Citas</h3>
                            <button wire:click="create" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded shadow">
                                Nueva Cita
                            </button>
                        </div>

                        <div class="overflow-x-auto shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Paciente</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Doctor</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Fecha</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Hora Inicio</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Estatus</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Acciones</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @forelse($appointments as $appointment)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $appointment->patient->user->name ?? 'N/A' }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $appointment->doctor->user->name ?? 'N/A' }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                @if($appointment->status == 1)
                                                    <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Pendiente</span>
                                                @else
                                                    <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">Atendida</span>
                                                @endif
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <a href="{{ route('admin.appointments.consultation', $appointment->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Atender Cita">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay citas registradas.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
