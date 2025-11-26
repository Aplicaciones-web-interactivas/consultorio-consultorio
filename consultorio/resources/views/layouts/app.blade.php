@php
    /**
     * Layout shim: wraps the existing Blade component at
     * resources/views/components/layouts/app.blade.php so older
     * views that call @extends('layouts.app') keep working.
     */
@endphp

<x-layouts.app>
    @yield('content')
</x-layouts.app>
