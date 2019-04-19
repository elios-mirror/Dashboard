@extends('layouts.app')

@section('content')
<div class="container">
      <h2>Update Module</h2><br  />
        <form method="post" action="{{action('ModuleController@update', $id)}}">
        @csrf

        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" value="{{$module->name}}">
          </div>
        </div>

        <div class="row">
          <div class="col-md-4"></div>
            <div class="form-group col-md-4">
              <label for="email">Title</label>
              <input type="text" class="form-control" name="title" value="{{$module->title}}">
            </div>
          </div>

      <div class="row">
        <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="number">Repository:</label>
            <input type="text" class="form-control" name="repository" value="{{$module->repository}}">
          </div>
        </div>

          <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
              <label for="number">Git Commit:</label>
              <input type="text" class="form-control" name="commit" value="{{$module_version->commit}}">
            </div>
          </div>

          <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
              <label for="number">Version:</label>
              <input type="text" class="form-control" name="version" value="{{$module_version->version}}">
            </div>
          </div>

          <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
              <label for="description">Description</label>
              <textarea class="form-control" name="description" rows="3" value="{{$module->description }}"></textarea>
            </div>
          </div>

        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4" style="margin-top:60px">
            <button type="submit" class="btn btn-success" style="margin-left:38px">Update</button>
          </div>
        </div>
      </form>
    </div>
@endsection
