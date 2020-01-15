@component('mail::message')
Kære administrator.

Upload af et bilag er fejlet med følgende meddelelse:

@component('mail::panel')
{{ $exception->getMessage() }}
@endcomponent
<br>
Bilaget har følgende oplysninger:

@component('mail::panel')
    <strong>ID:</strong> {{ $expense->ph_id }}<br>
    <strong>Udlægsholder:</strong> {{ $expense->creditor }}<br>
    <strong>Beløb:</strong> {{ $expense->amount }} kr.<br>
    <strong>Udvalg:</strong> {{ $expense->department }}<br>
    <strong>Aktivitet:</strong> {{ $expense->activity }}<br>
@endcomponent

Med venlig spejderhilsen<br>
{{ config('app.name') }}
@endcomponent
