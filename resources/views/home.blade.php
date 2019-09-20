@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Your Applications
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                @foreach($modules as $m)
                                    <div class="col-md-4" style="margin-bottom: 2rem">
                                        <a class="module-link" href="{{ route('display', ['id' => $m->id]) }}">
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
                                        </a>
                                    </div>
                                @endforeach
                                @if(count($modules) <= 0)
                                    <p style="text-align: center; width: 100%; font-size: 1rem;">You have no applications, start uploading one <a
                                                href="{{ route('import') }}">here</a></p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
