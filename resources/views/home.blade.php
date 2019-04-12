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
                    <div class="card-header">GitHub Account</div>

                      <div class="card-body">
                          <div class="col-md-4">
                            <label for="GitHubLogin">{{ __('Loggin') }}</label>
                            <input type="text" class="form-control" name="gitLogin" aria-describedby="versionHelp" placeholder="vladislav.zobov@epitech.eu">
                          </div>

                          <div class="col-md-4" style="padding-top: 20px">
                            <label for="GitHubPassword">{{ __('Password') }}</label>
                            <input type="text" class="form-control" name="gitPassword" aria-describedby="versionHelp" placeholder="*******">
                          </div>

                          <div class="col-md-4" style="padding-top: 20px">
                            <button type="submit" class="btn btn-primary">{{ __('Sign-In') }}
                          </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8" style="padding-top: 20px">
                <div class="card">
                    <div class="card-header">Application Status</div>

                    <div class="card-body">
                      @foreach($modules as $m)
                        @if(auth()->user()->id === $m->publisher_id)
                          <table class="table">
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
                               <td><img src="{{asset($m->logo)}}"/ width="50" height="50"></td>
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
