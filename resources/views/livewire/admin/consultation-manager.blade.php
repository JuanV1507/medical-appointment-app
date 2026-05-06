<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Atender Cita Médica') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Encabezado del Paciente y Botón de Historial -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6 p-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">
                        Paciente: {{ $appointment->patient->user->name ?? 'N/A' }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        Fecha de la cita: {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}
                    </p>
                </div>
                <div>
                    <button wire:click="$set('showHistoryModal', true)" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                        Consultas Anteriores
                    </button>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- Tabs Navigation -->
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex" aria-label="Tabs">
                        <button wire:click="setTab('consulta')" class="{{ $activeTab === 'consulta' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm">
                            Consulta
                        </button>
                        <button wire:click="setTab('receta')" class="{{ $activeTab === 'receta' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm">
                            Receta
                        </button>
                    </nav>
                </div>

                <div class="p-6">
                    @if($activeTab === 'consulta')
                        <!-- Tab: Consulta -->
                        <div class="space-y-6">
                            <div>
                                <label for="diagnosis" class="block text-sm font-medium text-gray-700">Diagnóstico</label>
                                <textarea wire:model="diagnosis" id="diagnosis" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                @error('diagnosis') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="treatment" class="block text-sm font-medium text-gray-700">Tratamiento</label>
                                <textarea wire:model="treatment" id="treatment" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                @error('treatment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notas Adicionales</label>
                                <textarea wire:model="notes" id="notes" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @endif

                    @if($activeTab === 'receta')
                        <!-- Tab: Receta -->
                        <div class="space-y-6">
                            <h4 class="font-medium text-gray-900">Añadir Medicamento</h4>
                            <div class="flex gap-4 items-end">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700">Medicamento</label>
                                    <input wire:model="newMedication.name" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div class="w-1/4">
                                    <label class="block text-sm font-medium text-gray-700">Dosis</label>
                                    <input wire:model="newMedication.dose" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div class="w-1/4">
                                    <label class="block text-sm font-medium text-gray-700">Frecuencia / Duración</label>
                                    <input wire:model="newMedication.frequency" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <button wire:click="addMedication" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow">
                                        + Añadir
                                    </button>
                                </div>
                            </div>
                            <!-- Show errors for new medication -->
                            @error('newMedication.name') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                            @error('newMedication.dose') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                            @error('newMedication.frequency') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror

                            <!-- Lista de Medicamentos Añadidos -->
                            @if(count($medications) > 0)
                                <div class="mt-6">
                                    <h4 class="font-medium text-gray-900 mb-2">Medicamentos Prescritos</h4>
                                    <ul class="divide-y divide-gray-200 border border-gray-200 rounded-md">
                                        @foreach($medications as $index => $med)
                                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                                <div class="w-0 flex-1 flex items-center">
                                                    <span class="ml-2 flex-1 w-0 truncate">
                                                        <span class="font-bold">{{ $med['name'] }}</span> - {{ $med['dose'] }} ({{ $med['frequency'] }})
                                                    </span>
                                                </div>
                                                <div class="ml-4 flex-shrink-0">
                                                    <button wire:click="removeMedication({{ $index }})" class="font-medium text-red-600 hover:text-red-500">Eliminar</button>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="mt-8 flex justify-end">
                        <button wire:click="saveConsultation" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow text-lg">
                            Finalizar y Guardar Consulta
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Historial Clínico -->
    @if($showHistoryModal)
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="$set('showHistoryModal', false)"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                    Consultas Anteriores - {{ $appointment->patient->user->name ?? 'N/A' }}
                                </h3>
                                
                                <div class="mt-2 max-h-96 overflow-y-auto">
                                    @forelse($pastConsultations as $past)
                                        <div class="mb-4 p-4 border border-gray-200 rounded-md bg-gray-50">
                                            <p class="text-sm text-gray-700 font-bold mb-1">
                                                Fecha: {{ \Carbon\Carbon::parse($past->date)->format('d/m/Y') }} | Doctor: {{ $past->doctor->user->name ?? 'N/A' }}
                                            </p>
                                            <p class="text-sm text-gray-600"><strong>Motivo original:</strong> {{ $past->reason ?: 'No especificado' }}</p>
                                            <!-- Como estamos simulando, podríamos mostrar los datos si estuvieran en DB -->
                                            <p class="text-sm text-gray-600 italic mt-2">Detalles de diagnóstico y tratamiento aparecerían aquí...</p>
                                        </div>
                                    @empty
                                        <p class="text-sm text-gray-500">No hay consultas anteriores registradas para este paciente.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="$set('showHistoryModal', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
