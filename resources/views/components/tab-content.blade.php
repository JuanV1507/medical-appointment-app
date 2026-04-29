{{--
    Este componente se encarga de mostrar el contenido de una pestaña específica.
    Recibe una propiedad 'tab' que indica a qué pestaña corresponde el contenido.
    Utiliza Alpine.js para mostrar u ocultar el contenido según la pestaña seleccionada. --}}
    
@props(['tab'])

<div x-show="tab === '{{ $tab }}'" style="display: none;">
    {{ $slot }}
</div>