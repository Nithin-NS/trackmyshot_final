@component('mail::message')
# Vaccine Slots are Available

Hi, 

@foreach ($data as $d)

Vaccine slots are available at {{ $d['name'] }}, {{ $d['address'] }}.<br>

@endforeach

Click to know more detail - <a href="https://trackmyshot.com/" target="_blank">trackmyshot.com</a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent