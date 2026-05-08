<div>
    <x-slot name="header">
        <div class="flex items-center text-sm text-gray-500 mb-1">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="text-gray-700 font-medium">Horarios</span>
        </div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Horarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <h3 class="text-xl font-medium text-gray-900">Gestor de horarios</h3>
                    <button wire:click="save" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 px-6 rounded-lg shadow-sm transition-colors">
                        Guardar horario
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="text-gray-500 text-sm tracking-wider text-left border-b">
                                <th class="py-3 px-4 font-semibold uppercase">DÍA/HORA</th>
                                @foreach($days as $day)
                                    <th class="py-3 px-4 font-semibold uppercase">{{ $day }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($hours as $hour)
                                <tr class="border-b last:border-b-0">
                                    <td class="py-4 px-4 align-top font-medium text-gray-700">
                                        <div class="flex items-center h-6">
                                            <input type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 rounded border-gray-300">
                                            <span class="ml-3 text-base font-bold">{{ $hour }}:00</span>
                                        </div>
                                    </td>
                                    
                                    @foreach($days as $day)
                                        <td class="py-4 px-4 align-top {{ !$loop->first ? 'border-l border-gray-100' : '' }}">
                                            <div class="flex flex-col space-y-3">
                                                <label class="inline-flex items-center text-gray-700 font-medium">
                                                    <input type="checkbox" wire:model.live="selectAll.{{ $day }}.{{ $hour }}" wire:change="toggleAll('{{ $day }}', '{{ $hour }}')" class="form-checkbox h-4 w-4 text-indigo-600 rounded border-gray-300">
                                                    <span class="ml-2">Todos</span>
                                                </label>
                                                
                                                @for($i = 0; $i < 4; $i++)
                                                    @php
                                                        $start = \Carbon\Carbon::parse($hour)->addMinutes($i * 15)->format('H:i');
                                                        $end = \Carbon\Carbon::parse($hour)->addMinutes(($i + 1) * 15)->format('H:i');
                                                    @endphp
                                                    <label class="inline-flex items-center text-gray-600 hover:text-gray-900 cursor-pointer">
                                                        <input type="checkbox" wire:model.live="selectedSlots.{{ $day }}.{{ $hour }}.{{ $start }}" class="form-checkbox h-4 w-4 text-indigo-600 rounded border-gray-300">
                                                        <span class="ml-2">{{ $start }} - {{ $end }}</span>
                                                    </label>
                                                @endfor
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
