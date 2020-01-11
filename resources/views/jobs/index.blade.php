@extends('layouts.base')

@section('page_title', 'See pending jobs')

@section('content')

    <div class="main bg-gray-100 min-h-screen w-full">

        <div class="sm:w-full lg:w-1/2 mx-auto text-center sm:text-6xl lg:text-4xl py-12">
            <div>
                <a href="/">See pending jobs</a>
            </div>

        </div>
        <div class="w-1/2 mx-auto p-6 bg-white rounded-lg">

            <table class="w-full text-left">
                    <tr>
                        <th>ID</th>
                        <th>Queue</th>
                        <th>Attempts</th>
                        <th>Created at</th>
                    </tr>

                @foreach($jobs as $job)

                    <tr>
                        <td>{{ $job->id }}</td>
                        <td>{{ $job->queue }}</td>
                        <td>{{ $job->attempts }}</td>
                        <td>{{ \Carbon\Carbon::parse($job->created_at)->format('d/m/Y H:i') }}</td>
                    </tr>

                @endforeach
            </table>

        </div>

        </div>

    </div>

@endsection
