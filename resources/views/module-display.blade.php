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
                                <a href="#" onclick="event.preventDefault();
                                                   document.getElementById('delete-form').submit();">
                                    <button type="button" class="btn btn-light">
                                        <i class="fas fa-trash-alt fa-lg"></i>
                                    </button>
                                </a>

                                <form id="delete-form" action="{{ route('modules-delete', ['id' => $module->id]) }}"
                                      method="POST" style="display: none;">
                                    <input type="hidden" name="_method" value="delete" />
                                    @csrf
                                </form>
                            </div>
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <div class="module-display-header-logo">
                                        <img src="{{ $module->logo_url ? $module->logo_url : '/images/notfound.png' }}"
                                             alt="application logo">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="module-display-header-text">
                                        <div class="module-display-header-title">
                                            {{ $module->title }}
                                        </div>
                                        <div class="module-display-header-subtitle">
                                            {{ $module->repository }}
                                        </div>
                                        <hr/>
                                        <div class="module-display-header-description">
                                            {{ $module->description }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr style="margin: 1.5rem 0"/>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="module-display-body">
                                        <div class="module-display-body-screenshots">
                                            <div class="module-display-body-screenshots-title">
                                                Screenshots
                                            </div>
                                            <div class="row">
                                                @foreach($module_screenshots as $screenshot)
                                                    <div class="col-md-4">
                                                        <img src="{{ $screenshot->screen_url }}" alt="screens">
                                                    </div>
                                                @endforeach
                                                @if(!count($module_screenshots))
                                                    <p class="text-center" style="width: 100%; color: grey;">No
                                                        screenshots</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
