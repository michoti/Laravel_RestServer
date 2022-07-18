@component('mail::message')

@component('mail::button', ['url' => ''])
    Message
@endcomponent
    
# welcome!! {{ $name}}    

Thanks,<br>
Livepost

@endcomponent
