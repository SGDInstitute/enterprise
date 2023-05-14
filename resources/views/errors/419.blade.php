<x-app-layout title="Page Expired">
    <x-http-error code="419" title="Page Expired">
        <p>The link or session has expired.</p>

        <p>This error can happen for a few reasons:</p>
        <ul>
            <li>A page was open for too long without interacting with it, please login again.</li>
            <li>The link that was clicked has expired, please request a new link.</li>
        </ul>

        <p>Send us a quick message from the chat in the bottom right corner of this page (or any page of our site) and let us know how we can help you. You can also email use at <a href="mailto:hello@sgdinstitute.org">hello@sgdinstitute.org</a></p>
    </x-http-error>
</x-app-layout>
