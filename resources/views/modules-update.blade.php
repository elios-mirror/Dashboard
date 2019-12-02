@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <a href="{{ url()->previous() }}" style="margin: 1rem;">
                    <button type="button" class="btn btn-secondary"><i class="fas fa-chevron-left"></i> Back</button>
                </a>
                <div class="card">
                    <div class="card-header">
                        Update Module
                    </div>
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

                        <form method="post" action="{{ action('ModuleUpdateController@update', $id)}}"
                                enctype="multipart/form-data">
                            @csrf

                            <input name="_method" type="hidden" value="PATCH">

                            <div class="form-group">
                                <label for="form_configuration"
                                       style="padding-top: 20px">{{ __('JSON Config') }}</label>
                                <textarea readonly class="form-control" name="form_configuration" id="form_configuration" rows="3">{{ Request::get('json') }}</textarea>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12" style="padding-top: 20px">
                                    <label for="changelog">New Version</label>
                                    <input readonly type="text" class="form-control" name="version" value="{{ Request::get('version') }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12" style="padding-top: 20px">
                                    <label for="changelog">Changelog</label>
                                    <textarea class="form-control" name="changelog" rows="3">{{"Second Version"}}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" style="padding-top: 20px">
                                    <label for="logo">{{ __('Update Logo') }}</label>
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
                            </div>

                            <div class="row">
                                <div class="col-md-12" style="padding-top: 20px">
                                    <label for="new_screenshots">{{ __('Update Screenshots') }}</label>
                                    <div class="custom-file">
                                        <input type="file" name="new_screenshots[]" id="new_screenshots" class="custom-file-input"
                                               multiple="true" onchange="getFileDataScreens(this);">
                                        <label for="uploadScreenshots"
                                               class="custom-file-label"
                                               id="choose_screens">{{ __('Upload Screenshots') }}</label>
                                    </div>
                                    <small class="form-text text-muted">Should be an image .jpeg, .jpg, .png <
                                        2048kb, max 6 files
                                    </small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-primary" style="float: right">Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
