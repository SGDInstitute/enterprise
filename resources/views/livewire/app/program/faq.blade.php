<div class="prose lg:grid lg:grid-cols-3 lg:gap-8 dark:prose-light">
    <div>
        <h1>Frequently asked questions</h1>
        <p class="mt-4 lead">Can’t find the answer you’re looking for? Reach out to our <a href="{{ route('app.program', [$event, 'contact']) }}" class="font-medium text-green-600 hover:text-green-500">customer support</a> team.</p>
    </div>
    <div class="mt-12 lg:mt-0 lg:col-span-2">
        <dl class="space-y-12">
            @foreach ($event->settings->faq as $faq)
            <div>
                <dt class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">
                    {{ $faq['name'] }}
                </dt>
                <dd class="mt-2 text-base text-gray-500 dark:text-gray-400">
                    {!! markdown($faq['content']) !!}
                </dd>
            </div>
            @endforeach
        </dl>
    </div>
</div>
