@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" style="padding-top: 20px">
                <div class="card">
                    <div class="card-header">Your Applications</div>

                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                @foreach($modules as $m)
                                    @if(auth()->user()->id === $m->publisher_id)
                                        <div class="col-md-3">
                                            <div class="application-logo text-center">
                                                <img src="{{ $m->logo_url ? $m->logo_url : '/images/notfound.png' }}"
                                                     alt="application logo">
                                            </div>
                                            <div class="application-title text-center">
                                                {{ $m->title }}
                                            </div>
                                            <div class="application-repository text-center">
                                                <div class="text-center application-repository-content">
                                                    {{ $m->repository }}
                                                </div>
                                            </div>
                                        </div>
                                        {{--<table class="table">
                                            <tr>
                                                <th>Title</th>
                                                <th>Name</th>
                                                <th>Repository</th>
                                                <th>Description</th>
                                                <th>Logo</th>
                                            </tr>
                                            <tr>
                                                <td>{{ $m->title }}</td>
                                                <td>{{ $m->name }}</td>
                                                <td>{{ $m->repository }}</td>
                                                <td>{{ $m->description }}</td>
                                                <td><img src="{{ $m->logo_url }}" width="50" height="50"></td>
                                            </tr>
                                        </table>--}}
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
