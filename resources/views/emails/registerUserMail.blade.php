@component('mail::message')
#Thanks,{{$user->name}} 
#Username:{{$user->username}}
#Email: {{$user->email}}
Welcome to registered to freeCodeGram

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
