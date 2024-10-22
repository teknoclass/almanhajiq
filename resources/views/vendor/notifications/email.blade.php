@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('مرحبا!')
@endif
@endif

{{-- Intro Lines --}}
{{--@foreach ($introLines as $line)--}}
{{--{{ $line }}--}}

{{--@endforeach--}}
يرجى الضغط على الزر بالأسفل للتحقق من البريد الإلكتروني

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{--{{ $actionText }}--}}
    اضغط هنا للتحقق
@endcomponent
@endisset

{{-- Outro Lines --}}
{{--@foreach ($outroLines as $line)--}}
{{--{{ $line }}--}}

{{--@endforeach--}}

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
<br>{{ 'موقع مشاهير' }}
@endif

{{-- Subcopy --}}
{{--@isset($actionText)--}}
{{--@component('mail::subcopy')--}}
{{--@lang(--}}
{{--    "لو كنت تواجه مشكلة في الضغط على  \":actionText\" الزر, قم بنسخ الرابط في متصفحك\n".--}}
{{--    ': [:actionURL](:actionURL)',--}}
{{--    [--}}
{{--        'actionText' => $actionText,--}}
{{--        'actionURL' => $actionUrl,--}}
{{--    ]--}}
{{--)--}}
{{--@endcomponent--}}
{{--@endisset--}}
@endcomponent
