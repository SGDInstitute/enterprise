<nav x-data="{open: false}" class="fixed z-50 w-full bg-gray-100 dark:bg-gray-900">
  <div class="px-2 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <div class="relative flex items-center justify-between h-16">
      <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
        <!-- Mobile menu button-->
        <button type="button" @click="open = !open" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <x-heroicon-o-menu x-show="!open" class="w-6 h-6" />
          <x-heroicon-o-x x-show="open" x-cloak class="w-6 h-6" />
        </button>
      </div>
      <div class="flex items-center justify-center flex-1 sm:items-stretch sm:justify-start">
        <div class="flex items-center flex-shrink-0">
          <span class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $title }}</span>
        </div>
        <div class="hidden sm:block sm:ml-6">
          <div class="flex space-x-4">
            <a href="{{ route('app.program', [$event, 'bulletin-board']) }}"  class="px-3 py-2 text-sm font-medium text-gray-700 rounded-md dark:text-gray-200 hover:bg-gray-700 hover:text-white">Bulletin Board</a>

            <a href="{{ route('app.program', [$event, 'schedule']) }}"  class="px-3 py-2 text-sm font-medium text-gray-700 rounded-md dark:text-gray-200 hover:bg-gray-700 hover:text-white">In-person Schedule</a>

            <a href="{{ route('app.program', [$event, 'virtual-schedule']) }}"  class="px-3 py-2 text-sm font-medium text-gray-700 rounded-md dark:text-gray-200 hover:bg-gray-700 hover:text-white">Virtual Schedule</a>

            <a href="{{ route('app.program', [$event, 'my-schedule']) }}" class="px-3 py-2 text-sm font-medium text-gray-700 rounded-md dark:text-gray-200 hover:bg-gray-700 hover:text-white">My Schedule</a>

            <a href="{{ route('app.program', [$event, 'badge']) }}" class="px-3 py-2 text-sm font-medium text-gray-700 rounded-md dark:text-gray-200 hover:bg-gray-700 hover:text-white">Virtual Badge</a>

            <a href="{{ route('app.program', [$event, 'contact']) }}" class="px-3 py-2 text-sm font-medium text-gray-700 rounded-md dark:text-gray-200 hover:bg-gray-700 hover:text-white">Contact</a>
        </div>
        </div>
      </div>
      <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
        <x-auth.user-settings />
      </div>
    </div>
  </div>

  <!-- Mobile menu, show/hide based on menu state. -->
  <div class="sm:hidden" x-show="open" x-cloak id="mobile-menu">
    <div class="px-2 pt-2 pb-3 space-y-1">
      <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
      <!-- <a href="{{ route('app.program', [$event, 'bulletin-board']) }}" class="block px-3 py-2 text-base font-medium text-white bg-gray-800 rounded-md" aria-current="page">Bulletin Board</a> -->
      <a href="{{ route('app.program', [$event, 'bulletin-board']) }}" class="block px-3 py-2 text-base font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">Bulletin Board</a>

      <a href="{{ route('app.program', [$event, 'schedule']) }}" class="block px-3 py-2 text-base font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">Schedule</a>

      <a href="{{ route('app.program', [$event, 'my-schedule']) }}" class="block px-3 py-2 text-base font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">My Schedule</a>

      <a href="{{ route('app.program', [$event, 'badge']) }}" class="block px-3 py-2 text-base font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">Virtual Badge</a>

      <a href="{{ route('app.program', [$event, 'contact']) }}" class="block px-3 py-2 text-base font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">Contact</a>
    </div>
  </div>
</nav>
<div style="height:64px"></div>
