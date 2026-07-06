<x-layout>
    @isset($header)
        {{ $header }}
    @endisset

    {{ $slot }}
</x-layout>