<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? 'Laravel' }}</title>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance

<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<script src="{{ asset('js/flowbite.js') }}"></script>
 @livewireStyles
@stack('head')
<!-- Alpine.js + Focus Plugin (recommended for modals) -->

