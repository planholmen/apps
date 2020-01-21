@component('mail::message')
Kære {!! $expense->user->name !!}.

Følgende bilag er blevet afvist:
@component('mail::panel')
    <strong>Udvalg: </strong>{{ $expense->department }}<br>
    <strong>Aktivitet: </strong>{{ $expense->activity }}<br>
    <strong>Beløb: </strong>{{ $expense->amount }} kr.<br>
@endcomponent

Kontakt kasseren for nærmere informationer og upload evt. bilaget igen.

Med venlig spejderhilsen,<br>
{{ config('app.name') }}
@endcomponent
