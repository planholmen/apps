@component('mail::message')
Kære {!! $user->name !!}.

Følgende af dine fakturaer er blevet godkendt:

@foreach($expenses as $expense)

@component('mail::panel')
    <strong>ID: </strong>{{ $expense->ph_id }}<br>
    <strong>Udvalg: </strong>{{ $expense->department }}<br>
    <strong>Aktivitet: </strong>{{ $expense->activity }}<br>
    <strong>Beløb: </strong>{{ $expense->amount }} kr.<br>
@endcomponent

@endforeach

Med venlig spejderhilsen,<br>
{{ config('app.name') }}
@endcomponent
