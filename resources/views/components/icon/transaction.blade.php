@props(['stroke' => '#647887', 'fill' => '#90A1AD', 'width' => 15, 'height' => 15])

<svg xmlns="http://www.w3.org/2000/svg" width="{{ 21 }}" height="20" viewBox="0 0 21 20" fill="none">
    <path d="M13.9502 11.25L16.4502 13.75L13.9502 16.25" fill="{{ $fill }}" />
    <path d="M13.9502 11.25L16.4502 13.75L13.9502 16.25" stroke="{{ $stroke }}" stroke-width="1.5" stroke-linecap="round"
        stroke-linejoin="round" />
    <path d="M3.9502 13.75H16.4502" stroke="{{ $stroke }}" stroke-width="1.5" stroke-linecap="round"
        stroke-linejoin="round" />
    <path d="M6.4502 8.75L3.9502 6.25L6.4502 3.75" stroke="{{ $stroke }}" stroke-width="1.5" stroke-linecap="round"
        stroke-linejoin="round" />
    <path d="M16.4502 6.25H3.9502" stroke="{{ $stroke }}" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
</svg>
