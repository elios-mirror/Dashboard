@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if(auth()->user()->confirmed === false)
                            <div class="alert alert-warning">
                                Email not confirmed <a href="{{ url('/email/resend') }}" class="btn btn-info">Resend
                                    Email</a>
                            </div>
                        @endif

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!

                    </div>


                </div>
            </div>
            <div class="col-md-8" style="padding-top: 20px">
                <div class="card">
                    <div class="card-header">Mirrors</div>

                    <div class="card-body">
                        @foreach(auth()->user()->mirrors as $mirror)
                            - {{ $mirror->name }} / model : {{  $mirror->model }} <br>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
