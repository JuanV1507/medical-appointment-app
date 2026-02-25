@php
  //ARREGLO DE INCONOS
  $links = [
    [
      'name' => 'Dashboard',
      'icon' => 'fa-solid fa-gauge',
      'href' => route('admin.dashboard'),
      'active' => request()->routeIs('admin.dashboard'),
    ],  
    [
      'header' => 'Administración',

    ],
     [
      'name' => 'Tienda en linea',
      'icon' => 'fa-solid fa-user-group',
      'href' => route('admin.dashboard'),
      'active' => request()->routeIs('admin.dashboard'),
      'submenu' => [
         [
            'name' => 'Productos',
            'href' => '#',
            'active' => false,
         ],
         [
            'name' => 'Categorias',
            'href' => '#',
            'active' => false,
         ],
         [
            'name' => 'Pedidos',
            'href' => '#',
            'active' => false,
         ]
    ], 
  ]
  ];

@endphp

<aside id="top-bar-sidebar" class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
   <div class="h-full px-3 py-4 overflow-y-auto bg-neutral-primary-soft border-e border-default">
      <a href="/" class="flex items-center ps-2.5 mb-5">
         <img src="{{ asset ('images/logo.jpg') }}" class="h-6 me-3" alt="Flowbite Logo" />
         <span class="self-center text-lg text-heading font-semibold whitespace-nowrap">Healthify</span>
      </a>
      <ul class="space-y-2 font-medium">
         @foreach ($links ?? [] as $link)
<li>

    {{-- HEADER --}}
    @if(isset($link['header']))
        <div class="px-2 py-2 text-xs font-semibold text-gray-500 uppercase">
            {{$link['header']}}
        </div>

    {{-- LINK CON SUBMENU --}}
    @elseif(isset($link['submenu']))

        <button type="button"
            class="flex items-center w-full justify-between px-2 py-2 hover:bg-gray-100"
            data-collapse-toggle="dropdown-{{$loop->index}}">

            <div class="flex items-center">
                <span class="w-6 h-6 inline-flex items-center justify-center text-gray-500">
                    <i class="{{$link['icon']}} w-5 h-5"></i>
                </span>
                <span class="ms-3">{{$link['name']}}</span>
            </div>

            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-width="2" d="m19 9-7 7-7-7"/>
            </svg>
        </button>

        <ul id="dropdown-{{$loop->index}}" class="hidden py-2 space-y-2">
            @foreach ($link['submenu'] as $item)
                <li>
                    <a href="{{$item['href']}}"
                       class="pl-10 block py-2 hover:bg-gray-100">
                        {{$item['name']}}
                    </a>
                </li>
            @endforeach
        </ul>

    {{-- LINK NORMAL --}}
    @else

        <a href="{{$link['href']}}"
           class="flex items-center px-2 py-2 hover:bg-gray-100 {{$link['active'] ? 'bg-gray-100' : ''}}">
            
            <span class="w-6 h-6 inline-flex items-center justify-center text-gray-500">
                <i class="{{$link['icon']}} w-5 h-5"></i>
            </span>

            <span class="ms-3">{{$link['name']}}</span>
        </a>

    @endif

</li>
@endforeach

      </ul>
   </div>
</aside> 