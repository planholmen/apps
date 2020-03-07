@extends('layouts.base')

@section('page_title', 'Opret nyt bilag')

@section('headers')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
@endsection

@section('content')

    <div class="main bg-gray-100 min-h-screen w-full">

        <div class="sm:w-full lg:w-1/2 mx-auto text-center sm:text-6xl lg:text-4xl py-12">

            <div>
                <a href="/">Opret nyt bilag</a>
            </div>

            @if(session('success'))
                <div id="js-success-message" class="sm:w-full lg:w-3/5 mx-auto text-center text-xl bg-green-200 text-green-800 p-6 my-8 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form action="/expense/store" method="post" enctype="multipart/form-data">
                @csrf
                <div class="text-2xl mt-6 text-left w-10/12 mx-auto bg-white p-4 px-8 rounded-lg">

                    <div class="my-8 py-4">
                        <label for="department">Udvalg</label>
                        <input class="w-full border-solid border-gray-400 border-2 rounded-lg" type="text" name="department" required>
                        @error('department')
                            <div class="text-red-600 text-lg">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="my-8 py-4">
                        <label for="activity">Aktivitet</label>
                        <input class="w-full border-solid border-gray-400 border-2 rounded-lg" type="text" name="activity" required>
                        @error('activity')
                            <div class="text-red-600 text-lg">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="my-8 py-4">
                        <label for="amount">Beløb</label>
                        <input class="w-full border-solid border-gray-400 border-2 rounded-lg" type="number" min="0" step="any" name="amount" required>
                        @error('amount')
                            <div class="text-red-600 text-lg">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="my-8 py-4">
                        <input class="block mx-auto border-solid border-gray-400 border-2 rounded-lg" type="file" name="file" required>
                        @error('file')
                            <div class="text-red-600 text-center text-lg">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="my-8 py-4">
                        <input class="block mx-auto px-12 py-4 bg-green-500 text-white rounded-lg cursor-pointer" type="submit" name="submit" value="Upload!">
                    </div>

                </div>

            </form>

        </div>

    </div>

    <script type="text/javascript">

        let successMessage = $('#js-success-message');

        $(document).ready(function () {
            if ( ! successMessage.hasClass('hidden')) {
                setTimeout(function () {
                    successMessage.addClass('hidden');
                }, 5000);
            }
        });

    </script>

@endsection
