<?php
/*
    (($id == 0) && (sizeof($expenses) > 0)) ? $id = 1 : $id = $id;
    ($id > sizeof($expenses)) ? $id = 1 : $id = $id;
*/
//dd($errors);
?>

@extends('layouts.base')

@section('page_title', 'Godkend bilag')

@section('content')

    <div class="main bg-gray-100 min-h-screen w-full">

        <div class="w-3/5 mx-auto text-center py-12">

            <div class="sm:text-6xl lg:text-4xl ">
                <a href="/">Godkend bilag</a>
            </div>

            @if ( sizeof($expenses) == 0 )

                <div class="w-1/2 text-2xl mx-auto mt-6 bg-green-200 text-gray-800 p-6 rounded-lg">
                    Der er ingen bilag, der skal godkendes!
                </div>

            @else

                <div class="text-right my-4 mr-4 p-2 px-4 bg-white rounded-lg float-right">
                    1 / {{ sizeof($expenses) }}
                </div>

                <div class="clearfix"></div>

                <form method="POST" action="{{ route('expenses.update', ['expense' => $expenses[0]['id']]) }}" id="form">

                    @csrf
                    @method('PATCH')

                    <div class="w-full">

                        <div class="flex">
                            <!-- Info regarding who registered the expense -->
                            <div class="w-2/5 min-h-full bg-white rounded-lg text-left text-lg mx-4">
                                <div class="p-6">
                                    <div class="pb-4">
                                        <strong>Udlægsholder</strong><br>
                                        {{ $expenses[0]['creditor'] }}
                                    </div>

                                    <div class="pb-4">
                                        <label for="amount"><strong>Beløb</strong></label><br>
                                        <input class="border-2 border-gray-500 px-2 py-1 rounded"
                                               step=".01"
                                               name="amount"
                                               id="amount"
                                               type="number"
                                               value="{{ $expenses[0]['amount'] }}" /> kr.
                                    </div>

                                    <div class="pb-4">
                                        <label for="department"><strong>Udvalg</strong></label><br>
                                        <input class="border-2 border-gray-500 px-2 py-1 rounded"
                                               name="department"
                                               id="department"
                                               type="text"
                                               value="{{ $expenses[0]['department'] }}" />
                                    </div>

                                    <div class="pb-4">
                                        <label for="activity"><strong>Aktivitet</strong></label><br>
                                        <input class="border-2 border-gray-500 px-2 py-1 rounded"
                                               name="activity"
                                               id="activity"
                                               type="text"
                                               value="{{ $expenses[0]['activity'] }}" />
                                    </div>
                                </div>
                            </div>

                            <!-- The photo or pdf itself -->
                            <div class="w-3/5 bg-gray-200 rounded-lg mx-4 p-4">

                                <div class="px-6 overflow-y-auto" style="height: 60vh;">
                                    @if ( File::mimeType(Storage::path('public/' . $expenses[0]['file_path'])) == 'application/pdf')
                                        <embed class="w-full h-full" src="{{ asset('storage/' . $expenses[0]['file_path']) }}" type="application/pdf">
                                    @else
                                        <img class="max-w-full mx-auto" src="{{ asset('storage/' . $expenses[0]['file_path']) }}" alt="bilag">
                                    @endif
                                </div>

                            </div>

                        </div>

                        <div class="w-full">

                            <div class="w-1/2 my-8 mx-auto flex flex-row justify-center">

                                <div class="w-1/3 mr-4">
                                    <button type="submit" id="deny" class="min-w-full py-4 bg-orange-500 text-white rounded-lg font-bold">Afvis</button>
                                </div>
                                <div class="w-1/3 ml-4">
                                    <button type="submit" id="accept" class="min-w-full py-4 bg-green-500 text-white rounded-lg font-bold">Godkend</button>
                                </div>

                            </div>

                        </div>

                    </div>

                </form>

            @endif

        </div>

    </div>

@endsection

@section('js')
<script type="text/javascript">

    let denyBtn = document.getElementById("deny");
    let acceptBtn = document.getElementById("accept");

    denyBtn.addEventListener('click', function (event) {
        event.preventDefault();
        processForm(false);
    });

    acceptBtn.addEventListener('click', function (event) {
        event.preventDefault();
        processForm(true);
    });

    function processForm(is_accepted) {
        let form = document.getElementById("form");
        let element = document.createElement('input');

        element.type = "hidden";
        element.name = "is_accepted";
        element.value = is_accepted;

        form.appendChild(element);

        form.submit();
    }

</script>
@endsection
