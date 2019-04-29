@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a href="{{ url('/home')  }}" style="margin: 1rem;">
                    <button type="button" class="btn btn-secondary"><i class="fas fa-chevron-left"></i> Back</button>
                </a>
                <div class="card">
                    <div class="card-body">
                        <div class="module-display-header">
                            <div class="module-display-header-edit-button">
                                <a href="{{ route('modules-edit', ['id' => $module->id]) }}" style="margin: 1rem;">
                                    <button type="button" class="btn btn-light">
                                        <i class="fas fa-pencil-alt fa-lg"></i>
                                    </button>
                                </a>
                            </div>
                            <div class="module-display-header-logo">
                                <img src="{{ $module->logo_url ? $module->logo_url : '/images/notfound.png' }}"
                                     alt="application logo">
                            </div>
                            <div class="module-display-header-text">
                                <div class="module-display-header-title">
                                    {{$module->title}}
                                </div>
                                <div class="module-display-header-subtitle">
                                    {{$module->repository}}
                                </div>
                                <hr/>
                                <div class="module-display-header-description">
                                    {{$module->description}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
