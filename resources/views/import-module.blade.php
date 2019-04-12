@extends('layouts.app')

@section('content')
<link href="{{ asset('css/uploadImage.css') }}" rel="stylesheet">
<script src="js/uploadImage.js"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Application Importer</div>

                <div class="card-body">
                  <form method="POST" action="{{ action('ModuleController@store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                      <div class="col-md-4">
                        <label for="moduleVersion">{{ __('Application Version') }}</label>
                        <input type="text" class="form-control" name="mVersion" aria-describedby="versionHelp" placeholder="Version 1.0.0">
                      </div>

                      <div class="col-md-4">
                        <label for="moduleVersion">{{ __('Application Title') }}</label>
                        <input type="text" class="form-control" name="mTitle" aria-describedby="versionHelp" placeholder="Test Module...">
                      </div>

                      <div class="col-md-4">
                        <label for="moduleVersion">{{ __('Application Name') }}</label>
                        <input type="text" class="form-control" name="mName" aria-describedby="versionHelp" placeholder="Weather...">
                      </div>

                      <div class="col-md-4" style="padding-top: 20px">
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
                        <input type="text" class="form-control" name="mCommit"></textarea>
                      </div>

                      <div class="col-md-6">
                        <label for="moduleImage" style="padding-top: 20px">{{ __('Upload Logo') }}</label>
                          <div class="input-group">
                              <span class="input-group-btn">
                                  <span class="btn btn-default btn-file">
                                      Browse… <input type="file" name="imgInp" id="imgInp">
                                  </span>
                              </span>
                              <input type="text" class="form-control" readonly>
                          </div>
                          <img id='img-upload'/>
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
