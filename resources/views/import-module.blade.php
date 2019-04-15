@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Application Importer</div>

                <div class="card-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ action('ModuleController@store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                      <div class="col-md-4">
                        <label for="moduleVersion">{{ __('Application Title') }}</label>
                        <input type="text" class="form-control" name="applicationTitle" aria-describedby="versionHelp" placeholder="Test Module...">
                      </div>

                      <div class="col-md-4">
                        <label for="moduleVersion">{{ __('Application Name') }}</label>
                        <input type="text" class="form-control" name="applicationName" aria-describedby="versionHelp" placeholder="Weather...">
                      </div>

                      <div class="col-md-4">
                        <label for="moduleCategory">{{ __('Application Category') }}</label>
                        <select class=form-control name="moduleCategory" id="moduleCategory">
                          <option value="Entertainment">Entertainment</option>
                          <option value="Utility">Utility</option>
                          <option value="Games">Games</option>
                          <option value="Productivity">Productivity</option>
                        </select>
                      </div>

                      <div class="col-md-4">
                        <label for="moduleVersion" style="padding-top: 20px">{{ __('Github Repository') }}</label>
                        <input type="text" class="form-control" name="repository" id="repository">
                      </div>

                      <div class="col-md-4">
                        <label for="moduleCommit" style="padding-top: 20px">{{ __('Github Commit') }}</label>
                        <input type="text" class="form-control" name="gitCommit"></textarea>
                      </div>

                        <div class="col-md-4" style="padding-top: 20px">
                            <label for="moduleVersion">{{ __('Application Version') }}</label>
                            <input type="text" class="form-control" name="applicationVersion" aria-describedby="versionHelp" placeholder="Version 1.0.0">
                        </div>

                        <div class="col-md-12">
                            <label for="uploadLogo" style="padding-top: 20px">{{ __('Upload Logo') }}</label>
                            <input type="file" name="logo" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label for="uploadScreenshots" style="padding-top: 20px">{{ __('Upload Screenshots') }}</label>
                            <input type="file" name="screenshots[]" class="form-control" multiple="true">
                        </div>
                    </div>

                  <div class="form-group">
                    <label for="Textarea1" style="padding-top: 20px">{{ __('Discribe your module') }}</label>
                    <textarea class="form-control" name="description" rows="3"></textarea>
                  </div>

                  <button type="submit" class="btn btn-primary">{{ __('Submit Module') }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
