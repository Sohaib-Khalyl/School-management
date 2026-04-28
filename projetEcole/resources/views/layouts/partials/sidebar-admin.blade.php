<aside id="sidebar" class="fixed left-0 top-0 h-screen w-[260px] flex flex-col bg-white border-r border-slate-200 z-40 transition-transform duration-300 -translate-x-full lg:translate-x-0">
    <div class="p-6 flex flex-col gap-1 border-b border-slate-100">
        <span class="text-lg font-black text-blue-600 tracking-tight">GestionEcole</span>
        <span class="text-[12px] font-medium text-slate-500 uppercase tracking-widest">Administration Scolaire</span>
    </div>

    <nav class="flex-1 px-4 py-4 flex flex-col gap-1 overflow-y-auto">
        <x-nav-link-school :active="request()->routeIs('admin.dashboard')" icon="dashboard" :href="route('admin.dashboard')">
            Tableau de bord
        </x-nav-link-school>

        <x-nav-link-school :active="request()->routeIs('admin.users')" icon="group" :href="route('admin.users')">
            Utilisateurs
        </x-nav-link-school>

        <x-nav-link-school :active="request()->routeIs('admin.classes')" icon="meeting_room" :href="route('admin.classes')">
            Classes
        </x-nav-link-school>

        <x-nav-link-school :active="request()->routeIs('admin.notes')" icon="grade" :href="route('admin.notes')">
            Notes
        </x-nav-link-school>

        <x-nav-link-school :active="request()->routeIs('admin.matieres.*')" icon="menu_book" :href="route('admin.matieres.index')">
            Matières
        </x-nav-link-school>
    </nav>

    <div class="mt-auto p-4 border-t border-slate-100">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-red-500 hover:bg-red-50 transition-colors">
                <span class="material-symbols-outlined text-[22px]">logout</span>
                <span class="font-medium text-[14px]">Déconnexion</span>
            </button>
        </form>
    </div>
</aside>
