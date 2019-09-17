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

                        <form method="post" action="{{ action('ModuleUpdateController@update', $id)}}">
                            @csrf

                            <input name="_method" type="hidden" value="PATCH">

                            <git-checker></git-checker>

                            <div class="row">
                                <div class="form-group col-md-12" style="padding-top: 20px">
                                    <label for="changelog">Changelog</label>
                                    <textarea class="form-control" name="changelog" rows="3">{{$module_version->changelog }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="screen">Screenshots</label>
                                    <img src="{{$module_screenshots->screen_url}}" alt="Responsive image" class="img-thumbnail">
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
