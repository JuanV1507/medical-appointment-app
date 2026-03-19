<div class="flex items-center gap-2">
    <x-wire-button href="{{route('admin.users.edit', $user) }}" color="blue" xs>
       
            <i class="fa-solid fa-pen-to-square"></i>
        
    </x-wire-button>

    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
        @csrf
        @method('DELETE')
        <x-wire-button type="submit" color="red" xs>
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    </form>

</div> 