@extends('layouts.app')

@section('content')
  <table class="table table-striped">
    <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Title</th>
      <th>Repository</th>
      <th>Description</th>
      <th colspan="2">Action</th>
    </tr>
    </thead>
    <tbody>

    @foreach(auth()->user()->modules()->get() as $module)
        <tr>
          <td>{{$module->id}}</td>
          <td>{{$module->name}}</td>
          <td>{{$module->title}}</td>
          <td>{{$module->repository}}</td>
          <td>{{$module->description}}</td>

          <td><a href="{{ action('ModuleController@edit', $module->id)}}" class="btn btn-warning">Edit</a>
          </td>
          <td>
            <form action="{{ action('ModuleController@destroy', $module->id)}}" method="post">
              @csrf

              <input name="_method" type="hidden" value="DELETE">
              <button class="btn btn-danger" type="submit">Delete</button>
            </form>
          </td>
        </tr>
    @endforeach
    </tbody>
  </table>
@endsection
