<x-dropdown origin="top-right" hideDown class="relative ml-3" styles="max-w-xs flex items-center text-sm rounded-full text-white focus:outline-none focus:shadow-solid">
    <x-slot name="title">
        <x-avatar search="{{ auth()->user()->email }}" class="w-8 h-8 rounded-full" />
    </x-slot>

    <div class="py-1 bg-gray-800 rounded-md shadow-xs">
        <span class="block px-4 py-2 text-xs text-gray-300">My Settings</span>
        <a href="/my/settings/profile" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-900">Profile</a>
        <a href="/my/settings/devices" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-900">Devices</a>
        <a href="/my/settings/orders-demos" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-900">Orders &
            Demos</a>
        <a href="/my/settings/library" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-900">Library</a>

        @role('manufacturer')
        <div class="my-1 border-t border-gray-700"></div>
        <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-900">Manufacturer
            Dashboard</a>
        <a href=" {{ url('/nebula') }}" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-900">Nebula</a>
        @endrole
        @role('admin')
        <div class="my-1 border-t border-gray-700"></div>
        <a href=" {{ url('/nova') }}" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-900">Nova</a>
        <a href=" {{ url('/galaxy') }}" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-900">Galaxy</a>
        @endrole
        @impersonating
        <a href=" {{ route('impersonation.leave') }}" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-900">Leave
            impersonation</a>
        @endImpersonating
        <div class="my-1 border-t border-gray-700"></div>
        <x-buttons.logout style=" block px-4 py-2 text-sm text-gray-200 hover:bg-gray-900" />
    </div>
</x-dropdown>
