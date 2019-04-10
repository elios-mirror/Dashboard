@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('My module') }}</div>

                <div class="card-body">
                  <form method="POST" action="{{ action('ModuleController@update', ['id' => auth()->user()->module_id]) }}">
                    @csrf

                    <div class="row">
                      <div class="col-md-4">
                        <label for="moduleRepository">{{ __('Select module to update') }}</label>
                        <select class=form-control name="module" id="module">
                          @foreach($modules as $module)
                              <option value="{{ $module->id }}">{{ $module->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-4" style="padding-top: 20px">
                        <label for="moduleVersion">{{ __('Module version') }}</label>
                        <input type="text" class="form-control" name="mVersion" aria-describedby="versionHelp" placeholder="Version 1.0.0">
                      </div>

                      <div class="col-md-4" style="padding-top: 20px">
                        <label for="moduleVersion">{{ __('Module Title') }}</label>
                        <input type="text" class="form-control" name="mTitle" aria-describedby="versionHelp" placeholder="Test Module...">
                      </div>

                      <div class="col-md-4" style="padding-top: 20px">
                        <label for="moduleVersion">{{ __('Module Name') }}</label>
                        <input type="text" class="form-control" name="mName" aria-describedby="versionHelp" placeholder="Weather...">
                      </div>

                      <div class="col-md-4">
                        <label for="moduleCommit" style="padding-top: 20px">{{ __('Github Commit') }}</label>
                        <input type="text" class="form-control" name="mCommit"></textarea>
                      </div>

                      <div class="col-md-6">
                        <label for="moduleImage" style="padding-top: 20px">{{ __('Upload Image') }}</label>
                          <div class="input-group">
                              <span class="input-group-btn">
                                  <span class="btn btn-default btn-file">
                                      Browse… <input type="file" id="imgInp">
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

                  <button type="submit" class="btn btn-primary">{{ __('Update Module') }}
             </div>

        </div>
    </div>
  </div>
</div>
@endsection
