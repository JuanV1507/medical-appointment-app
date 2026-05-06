<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Horarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <h3 class="text-xl font-medium text-gray-900">Gestor de horarios</h3>
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
                        Guardar horario
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="text-gray-500 text-sm uppercase tracking-wider text-center border-b">
                                <th class="py-3 px-4 text-left font-medium">DÍA/HORA</th>
                                <th class="py-3 px-4 font-medium">LUNES</th>
                                <th class="py-3 px-4 font-medium">MARTES</th>
                                <th class="py-3 px-4 font-medium">MIÉRCOLES</th>
                                <th class="py-3 px-4 font-medium">JUEVES</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <!-- 08:00:00 Row -->
                            <tr class="border-b">
                                <td class="py-4 px-4 align-top font-medium text-gray-700">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="form-checkbox text-indigo-600 rounded">
                                        <span class="ml-2 text-lg">08:00:00</span>
                                    </label>
                                </td>
                                
                                @foreach(['LUNES', 'MARTES', 'MIÉRCOLES', 'JUEVES'] as $day)
                                    <td class="py-4 px-4 align-top border-l border-gray-100 pl-8">
                                        <div class="flex flex-col space-y-2">
                                            <label class="inline-flex items-center text-gray-600">
                                                <input type="checkbox" class="form-checkbox text-indigo-600 rounded">
                                                <span class="ml-2">Todos</span>
                                            </label>
                                            <label class="inline-flex items-center text-gray-600">
                                                <input type="checkbox" class="form-checkbox text-indigo-600 rounded" checked>
                                                <span class="ml-2">08:00 - 08:15</span>
                                            </label>
                                            <label class="inline-flex items-center text-gray-600">
                                                <input type="checkbox" class="form-checkbox text-indigo-600 rounded">
                                                <span class="ml-2">08:15 - 08:30</span>
                                            </label>
                                            <label class="inline-flex items-center text-gray-600">
                                                <input type="checkbox" class="form-checkbox text-indigo-600 rounded">
                                                <span class="ml-2">08:30 - 08:45</span>
                                            </label>
                                            <label class="inline-flex items-center text-gray-600">
                                                <input type="checkbox" class="form-checkbox text-indigo-600 rounded">
                                                <span class="ml-2">08:45 - 09:00</span>
                                            </label>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>

                            <!-- 09:00:00 Row -->
                            <tr class="border-b">
                                <td class="py-4 px-4 align-top font-medium text-gray-700">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="form-checkbox text-indigo-600 rounded">
                                        <span class="ml-2 text-lg">09:00:00</span>
                                    </label>
                                </td>
                                
                                @foreach(['LUNES', 'MARTES', 'MIÉRCOLES', 'JUEVES'] as $day)
                                    <td class="py-4 px-4 align-top border-l border-gray-100 pl-8">
                                        <div class="flex flex-col space-y-2">
                                            <label class="inline-flex items-center text-gray-600">
                                                <input type="checkbox" class="form-checkbox text-indigo-600 rounded">
                                                <span class="ml-2">Todos</span>
                                            </label>
                                            <label class="inline-flex items-center text-gray-600">
                                                <input type="checkbox" class="form-checkbox text-indigo-600 rounded">
                                                <span class="ml-2">09:00 - 09:15</span>
                                            </label>
                                            <label class="inline-flex items-center text-gray-600">
                                                <input type="checkbox" class="form-checkbox text-indigo-600 rounded">
                                                <span class="ml-2">09:15 - 09:30</span>
                                            </label>
                                            <label class="inline-flex items-center text-gray-600">
                                                <input type="checkbox" class="form-checkbox text-indigo-600 rounded">
                                                <span class="ml-2">09:30 - 09:45</span>
                                            </label>
                                            <label class="inline-flex items-center text-gray-600">
                                                <input type="checkbox" class="form-checkbox text-indigo-600 rounded">
                                                <span class="ml-2">09:45 - 10:00</span>
                                            </label>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
