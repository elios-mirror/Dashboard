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
                        Edit Module
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

                        <form method="post" action="{{ action('ModuleController@update', $id)}}">
                            @csrf

                            <input name="_method" type="hidden" value="PATCH">

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" name="title" value="{{$module->title}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{$module->name}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description"
                                              rows="3">{{$module->description }}</textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-primary" style="float: right">Edit
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
