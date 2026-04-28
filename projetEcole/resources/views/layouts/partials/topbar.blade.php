<header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 sticky top-0 z-20 shadow-sm">
    {{-- Mobile menu --}}
    <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg">
        <span class="material-symbols-outlined">menu</span>
    </button>

    <div class="flex-1"></div>

    <div class="flex items-center gap-4">
        <div class="text-right hidden sm:block">
            <p class="text-sm font-bold text-slate-900 leading-none">{{ Auth::user()->name ?? 'Utilisateur' }}</p>
            <p class="text-[11px] text-slate-500 font-medium capitalize">{{ Auth::user()->role ?? '' }}</p>
        </div>
        <img alt="Avatar"
             class="w-9 h-9 rounded-full border-2 border-blue-100 object-cover"
             src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'U') }}&color=7F9CF5&background=EBF4FF"/>
    </div>
</header>
