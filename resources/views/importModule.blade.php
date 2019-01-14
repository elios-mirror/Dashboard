@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Module Importer</div>

                <div class="card-body">
                  <form method="POST" action="{{ action('ModuleController@store') }}">
                    @csrf

                    <div class="row">
                      <div class="col-md-4">
                        <label for="moduleVersion">{{ __('Your module version') }}</label>
                        <input type="text" class="form-control" name="mVersion" aria-describedby="versionHelp" placeholder="Version 1.0.0">
                      </div>

                      <div class="col-md-4">
                        <label for="moduleVersion">{{ __('Your module Title') }}</label>
                        <input type="text" class="form-control" name="mTitle" aria-describedby="versionHelp" placeholder="Test Module...">
                      </div>

                      <div class="col-md-4">
                        <label for="moduleVersion">{{ __('Your module Name') }}</label>
                        <input type="text" class="form-control" name="mName" aria-describedby="versionHelp" placeholder="Weather...">
                      </div>
                    </div>

                  <div class="form-group">
                    <label for="githubRepository" style="padding-top: 20px">{{ __('Your module repository') }}</label>
                    <input type="text" class="form-control" name="repository" aria-describedby="githubHelp" placeholder="ex: https://github.com/xxxxx/xxx">
                    <small id="gitHelp" class="form-text text-muted">Be sure to verify your information.</small>

                    <label for="Textarea1" style="padding-top: 20px">{{ __('Discribe your module') }}</label>
                    <textarea class="form-control" name="description" rows="3"></textarea>
                  </div>

                  <button type="submit" class="btn btn-primary">{{ __('Submit Module') }}</div>
            </div>

        </div>
    </div>
</div>
@endsection
