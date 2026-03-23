<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="{{ config('config.assets.icon') }}" class="logo" alt="{{ config('config.general.app_name') }}">
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
