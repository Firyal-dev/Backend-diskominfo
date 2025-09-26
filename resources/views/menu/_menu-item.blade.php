{{-- resources/views/menu/_menu-item.blade.php --}}

<tr>
    <td>
        {{-- This adds indentation to show the parent-child relationship --}}
        <span style="padding-left: {{ $level * 25 }}px;">
           {{-- Add a symbol for child items to make it clearer --}}
           @if($level > 0) └─ @endif {{ $menu->nama }}
        </span>
    </td>
<td>
        {{-- Display the category with a nice badge --}}
        <span class="badge bg-secondary">{{ Str::ucfirst(str_replace('-', ' ', $menu->kategori)) }}</span>
    </td>
    <td>
        {{-- Tampilkan hanya jika kategori bukan statis --}}
        @if($menu->kategori !== 'statis')
            <span class="badge bg-info">{{ Str::ucfirst($menu->tipe_tampilan) }}</span>
        @else
            -
        @endif
    </td>

    <td>{{ $menu->urutan }}</td>
    <td>
        {{-- Action Buttons --}}
        <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this menu? Deleting a parent will also delete all its children.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
        </form>
    </td>
</tr>

{{-- This is the recursive part: if the current menu has children, --}}
{{-- call this same file again for each child, increasing the indentation level. --}}
@if ($menu->children->isNotEmpty())
    @foreach ($menu->children as $child)
        @include('menu._menu-item', ['menu' => $child, 'level' => $level + 1])
    @endforeach
@endif
