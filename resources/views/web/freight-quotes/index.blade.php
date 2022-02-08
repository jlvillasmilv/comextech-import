<x-guest-layout title="ImportTransport">
    <main id="app" class="h-full overflow-y-auto">
        <freight-quote ip-info='{{ $ip_info_token }}' />

        
    </main>
    <script src="{{ mix('js/app.js') }}"></script>
</x-guest-layout>