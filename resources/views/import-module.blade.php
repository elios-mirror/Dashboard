@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a href="{{ url('home')  }}" style="margin: 1rem;">
                    <button type="button" class="btn btn-secondary"><i class="fas fa-chevron-left"></i> Back</button>
                </a>
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
                                    <label for="applicationTitle">{{ __('Application Name') }}</label>
                                    <input type="text" class="form-control" name="applicationTitle"
                                           id="applicationTitle"
                                           placeholder="Traffic" value="{{ old('applicationTitle') }}">
                                    <small class="form-text text-muted">This is the public name of your app. It will be
                                        displayed on the Elios Store.
                                    </small>
                                </div>

                                <div class="col-md-4">
                                    <label for="applicationName">{{ __('Application ID') }}</label>
                                    <input type="text" class="form-control" name="applicationName" id="applicationName"
                                           placeholder="Traffic" value="{{ old('applicationName') }}">
                                    <small class="form-text text-muted">This is a unique ID to your app. It won't be
                                        seen on the Elios Store.
                                    </small>
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
                                        <input type="file" name="logo" id="logo" class="custom-file-input"
                                               onchange="getFileDataLogo(this);">
                                        <label for="uploadLogo"
                                               class="custom-file-label"
                                               id="choose_logo">{{ __('Upload Logo') }}</label>
                                    </div>
                                    <small class="form-text text-muted">Should be an image .jpeg, .jpg, .png < 2048kb
                                    </small>
                                </div>

                                <div class="col-md-12" style="padding-top: 20px">
                                    <div class="custom-file">
                                        <input type="file" name="screenshots[]" class="custom-file-input"
                                               multiple="true" onchange="getFileDataScreens(this);">
                                        <label for="uploadScreenshots"
                                               class="custom-file-label"
                                               id="choose_screens">{{ __('Upload Screenshots') }}</label>
                                        <small class="form-text text-muted">Should be an image .jpeg, .jpg, .png <
                                            2048kb, max 6 files
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="applicationDescription"
                                       style="padding-top: 20px">{{ __('Description') }}</label>
                                <textarea class="form-control" name="description" id="description"
                                          rows="3">{{ old('description') }}</textarea>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="form-text text-muted">Minimum 40 characters
                                            and maximum 1 000 characters.
                                        </small>
                                    </div>
                                    <div class="col-md-6">
                                        <small style="text-align: right;" class="form-text text-muted"
                                               id="count">0 characters
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary" style="float: right">{{ __('Submit') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        document.getElementById('description').onkeyup = function () {
            document.getElementById('count').innerHTML = this.value.length + " characters.";
        };

        function getFileDataLogo(myFile) {
            const file = myFile.files[0];
            const filename = file.name;
            document.getElementById('choose_logo').innerHTML = filename;
        }

        function getFileDataScreens(myFile) {
            let count = 0;
            Array.from(myFile.files).forEach(file => {
                count++
            });
            document.getElementById('choose_screens').innerHTML = count + ' files uploaded';
        }
    </script>
@endsection
