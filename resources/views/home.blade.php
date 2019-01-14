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

            <div class="col-md-8" style="padding-top: 20px">
                <div class="card">
                    <div class="card-header">Module Status</div>

                    <div class="card-body">
                      @foreach($modules as $m)
                        @if(auth()->user()->id === $m->publisher_id)
                          <table class="table">
                             <tr>
                               <th>Title</th>
                               <th>Name</th>
                               <th>Repository</th>
                               <th>Description</th>
                             </tr>
                             <tr>
                               <td>{{ $m->title }}</td>
                               <td>{{ $m->name }}</td>
                               <td>{{ $m->repository }}</td>
                               <td>{{ $m->description }}</td>
                             </tr>
                          </table>
                        @endif
                      @endforeach
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
