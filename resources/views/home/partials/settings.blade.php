<div class="bg-white rounded shadow overflow-hidden">
    <nav class="bg-mint-200 flex px-8 pt-2 border-b border-mint-300">
        <h1 class="no-underline text-mint-600 border-b-2 border-mint-600 uppercase tracking-wide font-bold text-xs py-3 mr-8">My Settings</h1>
    </nav>
    <div class="p-6">
        <div class="flex border-b pb-4 mb-4">
            <div class="w-1/3">
                <p class="text-lg text-gray-600 uppercase tracking-wide">Profile</p>
            </div>
            <div class="w-2/3">
                <edit-profile class="mt-4" :user="{{ auth()->user() }}" :profile="{{ auth()->user()->profile }}"></edit-profile>
            </div>
        </div>
        <div class="flex pt-4">
            <div class="w-1/3">
                <p class="text-lg text-gray-600 uppercase tracking-wide">Password</p>
            </div>
            <div class="w-2/3">
                <edit-password class="mt-4"></edit-password>
            </div>
        </div>
    </div>
</div>