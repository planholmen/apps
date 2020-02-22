@component('mail::message')
Kære {!! $user->name !!}.

Der er {{ $count }} bilag, der venter på at blive godkendt.
Godkend dem her: <a href="{!! route('expenses.approve') !!}">{!! route('expenses.approve') !!}</a>.

Med venlig spejderhilsen,<br>
{{ config('app.name') }}
@endcomponent
