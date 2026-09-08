@props(['id'])

<div x-show="editMode" x-cloak x-transition.opacity class="absolute top-3 right-3 z-50 flex items-center space-x-1 bg-white/95 backdrop-blur-md rounded-xl shadow-md border border-slate-200 p-1">
    <!-- Resize Button -->
    <button @click.prevent.stop="cycleSize('{{ $id }}')" title="Ubah Ukuran" class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors cursor-pointer focus:outline-none">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
    </button>
    <!-- Drag Handle -->
    <div title="Geser (Drag) untuk memindah" class="drag-handle p-1.5 text-slate-400 hover:text-slate-800 hover:bg-slate-100 cursor-grab active:cursor-grabbing rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
    </div>
</div>
