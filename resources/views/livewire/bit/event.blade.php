<div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
    <div class="flex-shrink-0">
        <img class="object-cover w-full h-48" src="https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-1.2.1&ixqx=XXsw1IsVEB&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80" alt="">
    </div>
    <div class="flex flex-col justify-between flex-1 p-6 bg-white">
        <div class="flex-1">
            <a href="#" class="block mt-2 text-xl font-semibold leading-7 text-gray-900">
                {{ $event->name }}
            </a>
        </div>
        <div class="flex items-center mt-6">
            <div class="flex text-sm leading-5 text-gray-500">
                <time datetime="2020-03-16">
                    {{ $event->formattedStart }}
                </time>
                <span class="mx-1">
                    &middot;
                </span>
                <span>
                    {{ $event->formattedEnd }}
                </span>
            </div>
        </div>
    </div>
</div>
