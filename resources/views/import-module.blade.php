@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
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

                        <form method="POST" action="{{ action('ModuleController@store') }}"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-4">
                                    <label for="applicationTitle">{{ __('Application Title') }}</label>
                                    <input type="text" class="form-control" name="applicationTitle"
                                           id="applicationTitle"
                                           placeholder="Traffic" value="{{ old('applicationTitle') }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="applicationName">{{ __('Application Name') }}</label>
                                    <input type="text" class="form-control" name="applicationName" id="applicationName"
                                           placeholder="Traffic" value="{{ old('applicationName') }}">
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
                                    <label for="gitRepository"
                                           style="padding-top: 20px">{{ __('Git Repository') }}</label>
                                    <input type="text" class="form-control" name="repository" id="repository"
                                           placeholder="MrDarkSkil/module-test" value="{{ old('repository') }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="gitCommit" style="padding-top: 20px">{{ __('Github Commit') }}</label>
                                    <input type="text" class="form-control" name="gitCommit" id="gitCommit"
                                           placeholder="2b3e7a4b44df26fdcd39785"
                                           value="{{ old('gitCommit') }}"></textarea>
                                </div>

                                <div class="col-md-4" style="padding-top: 20px">
                                    <label for="applicationVersion">{{ __('Application Version') }}</label>
                                    <input type="text" class="form-control" name="applicationVersion"
                                           id="applicationVersion"
                                           placeholder="1.0.0" value="{{ old('applicationVersion') }}">
                                </div>

                                <div class="col-md-12" style="padding-top: 20px">
                                    <div class="custom-file">
                                        <input type="file" name="logo" id="logo" class="custom-file-input">
                                        <label for="uploadLogo"
                                               class="custom-file-label">{{ __('Upload Logo') }}</label>
                                    </div>
                                    <small class="form-text text-muted">Should be an image .jpeg, .jpg, .png < 2048kb</small>
                                </div>

                                <div class="col-md-12" style="padding-top: 20px">
                                    <div class="custom-file">
                                        <input type="file" name="screenshots[]" class="custom-file-input"
                                               multiple="true">
                                        <label for="uploadScreenshots"
                                               class="custom-file-label">{{ __('Upload Screenshots') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="applicationDescription"
                                       style="padding-top: 20px">{{ __('Description') }}</label>
                                <textarea class="form-control" name="description" id="description"
                                          rows="3">{{ old('description') }}</textarea>
                                <small class="form-text text-muted">Minimum 40 characters and maximum 1 000 characters.</small>
                            </div>

                            <button type="submit" class="btn btn-primary" style="float: right">{{ __('Submit') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
