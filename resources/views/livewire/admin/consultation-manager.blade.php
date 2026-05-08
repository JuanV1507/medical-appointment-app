<div>
    <!-- Encabezado del Paciente y Botones -->
    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $appointment->patient->user->name ?? 'Paciente N/A' }}</h2>
            <p class="text-sm text-gray-500 mt-1">DNI: {{ $appointment->patient->user->id_number ?? 'No registrado' }}</p>
        </div>
        <div class="mt-4 md:mt-0 flex gap-3">
            <a href="{{ route('admin.patients.edit', $appointment->patient_id) }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-2 px-4 rounded-lg shadow-sm flex items-center text-sm transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                Ver Historia
            </a>
            <button wire:click="$set('showPastConsultationsModal', true)" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-2 px-4 rounded-lg shadow-sm flex items-center text-sm transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Consultas Anteriores
            </button>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
        <!-- Tabs Navigation -->
        <div class="border-b border-gray-200 px-6 pt-4">
            <nav class="flex gap-6" aria-label="Tabs">
                <button wire:click="setTab('consulta')" class="{{ $activeTab === 'consulta' ? 'border-indigo-600 text-indigo-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} flex items-center py-3 border-b-2 text-sm transition-colors outline-none focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    Consulta
                </button>
                <button wire:click="setTab('receta')" class="{{ $activeTab === 'receta' ? 'border-indigo-600 text-indigo-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium' }} flex items-center py-3 border-b-2 text-sm transition-colors outline-none focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    Receta
                </button>
            </nav>
        </div>

        <div class="p-6">
            @if($activeTab === 'consulta')
                <!-- Tab: Consulta -->
                <div class="space-y-6">
                    <div>
                        <label for="diagnosis" class="block text-sm font-medium text-gray-700 mb-2">Diagnóstico</label>
                        <textarea wire:model="diagnosis" id="diagnosis" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Describa el diagnóstico del paciente aquí..."></textarea>
                        @error('diagnosis') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="treatment" class="block text-sm font-medium text-gray-700 mb-2">Tratamiento</label>
                        <textarea wire:model="treatment" id="treatment" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Describa el tratamiento recomendado aquí..."></textarea>
                        @error('treatment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notas</label>
                        <textarea wire:model="notes" id="notes" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Agregue notas adicionales sobre la consulta..."></textarea>
                        @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            @endif

            @if($activeTab === 'receta')
                <!-- Tab: Receta -->
                <div class="space-y-4">
                    <!-- Iterar sobre medicamentos añadidos (o el input actual si no hay ninguno o si queremos mostrar uno por defecto) -->
                    @foreach($medications as $index => $med)
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 flex gap-4 items-center">
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Medicamento</label>
                                <input type="text" readonly value="{{ $med['name'] }}" class="w-full border-gray-300 rounded-md shadow-sm bg-white sm:text-sm text-gray-900">
                            </div>
                            <div class="w-1/4">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Dosis</label>
                                <input type="text" readonly value="{{ $med['dose'] }}" class="w-full border-gray-300 rounded-md shadow-sm bg-white sm:text-sm text-gray-900">
                            </div>
                            <div class="w-1/3">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Frecuencia / Duración</label>
                                <input type="text" readonly value="{{ $med['frequency'] }}" class="w-full border-gray-300 rounded-md shadow-sm bg-white sm:text-sm text-gray-900">
                            </div>
                            <div class="pt-5">
                                <button wire:click="removeMedication({{ $index }})" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-md transition-colors flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach

                    <!-- Fila para añadir nuevo medicamento -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 flex gap-4 items-center">
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Medicamento</label>
                            <input wire:model="newMedication.name" type="text" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ej: Amoxicilina 500mg">
                        </div>
                        <div class="w-1/4">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Dosis</label>
                            <input wire:model="newMedication.dose" type="text" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ej: 1 pastilla">
                        </div>
                        <div class="w-1/3">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Frecuencia / Duración</label>
                            <input wire:model="newMedication.frequency" type="text" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ej: cada 8 horas por 7 días">
                        </div>
                        <div class="pt-5 opacity-0 pointer-events-none">
                            <button class="bg-red-500 p-2 rounded-md"><svg class="w-5 h-5"></svg></button>
                        </div>
                    </div>

                    @error('newMedication.name') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                    @error('newMedication.dose') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                    @error('newMedication.frequency') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror

                    <button wire:click="addMedication" class="mt-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-md shadow-sm flex items-center text-sm transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Añadir Medicamento
                    </button>
                </div>
            @endif

            <div class="mt-8 flex flex-col items-end gap-3">
                @if($errors->has('diagnosis') || $errors->has('treatment') || $errors->has('notes'))
                    <span class="text-red-500 text-sm font-medium">Por favor, complete todos los campos obligatorios en la pestaña "Consulta" antes de guardar.</span>
                @endif
                <button wire:click="saveConsultation" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2.5 px-6 rounded-lg shadow-sm flex items-center transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 mr-2">
                        <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                    </svg>
                    Guardar Consulta
                </button>
            </div>
        </div>
    </div>

    <!-- Modal de Historial Clínico (Ver Historia - Image 5) -->
    @if($showHistoryModal)
        <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity" aria-hidden="true" wire:click="$set('showHistoryModal', false)"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-6 pt-5 pb-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold text-gray-900" id="modal-title">
                                Historia médica del paciente
                            </h3>
                            <button wire:click="$set('showHistoryModal', false)" class="text-gray-400 hover:text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Tipo de sangre:</p>
                                <p class="font-bold text-gray-900">{{ $appointment->patient->bloodType->name ?? 'No registrado' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Alergias:</p>
                                <p class="font-bold text-gray-900">{{ $appointment->patient->allergies ?: 'No registradas' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Enfermedades crónicas:</p>
                                <p class="font-bold text-gray-900">{{ $appointment->patient->chronic_conditions ?: 'No registradas' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Antecedentes quirúrgicos:</p>
                                <p class="font-bold text-gray-900">{{ $appointment->patient->surgical_history ?: 'No registradas' }}</p>
                            </div>
                        </div>

                        <div class="flex justify-end border-t border-gray-100 pt-4">
                            <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">Ver / Editar Historia Médica</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de Consultas Anteriores -->
    @if($showPastConsultationsModal)
        <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="$set('showPastConsultationsModal', false)"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-gray-50 rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white px-6 pt-5 pb-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-bold text-gray-900" id="modal-title">
                                Consultas Anteriores
                            </h3>
                            <button wire:click="$set('showPastConsultationsModal', false)" class="text-gray-400 hover:text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6 overflow-y-auto max-h-[70vh]">
                        @forelse($pastConsultations as $past)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 mb-4 relative">
                                <div class="absolute top-5 right-5">
                                    <button class="bg-indigo-50 text-indigo-700 hover:bg-indigo-100 font-medium py-1.5 px-3 rounded text-xs transition-colors flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        Consultar detalle
                                    </button>
                                </div>
                                <div class="flex flex-wrap gap-x-6 gap-y-2 mb-4 pr-32">
                                    <div class="flex items-center text-sm text-gray-600 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1.5 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($past->date)->format('d/m/Y') }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1.5 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($past->start_time)->format('H:i') }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1.5 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                        Dr(a). {{ $past->doctor->user->name ?? 'N/A' }}
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    <div class="bg-gray-50 p-3 rounded border border-gray-100">
                                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Diagnóstico</p>
                                        <p class="text-sm text-gray-800">{{ $past->diagnosis ?? 'No registrado' }}</p>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded border border-gray-100">
                                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tratamiento</p>
                                        <p class="text-sm text-gray-800">{{ $past->treatment ?? 'No registrado' }}</p>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded border border-gray-100 md:col-span-2">
                                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Notas</p>
                                        <p class="text-sm text-gray-800">{{ $past->notes ?? 'No registrado' }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 bg-white border border-gray-200 rounded-lg shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto text-gray-300 mb-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                                <p class="text-gray-500 font-medium">No hay consultas anteriores registradas.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
