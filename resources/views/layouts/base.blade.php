@extends('platform::dashboard')

@section('title', e(__($name)))
@section('description', e(__($description)))
@section('controller', 'base')

@section('navbar')
    <li>
        <div class="form-group mb-0">
            @include('platform::layouts.back-button')
        </div>
    </li>
    @foreach($commandBar as $command)
        <li class="{{ !$loop->first ? 'ms-2' : ''}}">
            {!! $command !!}
        </li>
    @endforeach
@endsection

@section('content')
    <div id="modals-container">
        @stack('modals-container')
    </div>

    <form id="post-form"
          class="mb-md-4 h-100"
          method="post"
          enctype="multipart/form-data"
          data-controller="form"
          data-form-need-prevents-form-abandonment-value="{{ var_export($needPreventsAbandonment) }}"
          data-form-failed-validation-message-value="{{ $formValidateMessage }}"
          data-action="keypress->form#disableKey
                      turbo:before-fetch-request@document->form#confirmCancel
                      beforeunload@window->form#confirmCancel
                      change->form#changed
                      form#submit"
          novalidate
    >
        {!! $layouts !!}
        @csrf
        @include('platform::partials.confirm')
    </form>

    <div data-controller="filter">
        <form id="filters" autocomplete="off"
              data-action="filter#submit"
              data-form-need-prevents-form-abandonment-value="false"
        ></form>
    </div>

    @includeWhen(isset($state), 'platform::partials.state')

    @if ($commandBar)
        <div class="layout v-md-center">
            <nav class="col-xs-12 col-md-auto ms-auto p-0">
                <ul class="nav command-bar justify-content-sm-end justify-content-start d-flex align-items-center">
                    <li>
                        <div class="form-group mb-0">
                            @include('platform::layouts.back-button')
                        </div>
                    </li>
                    @foreach($commandBar as $command)
                        {!! $command !!}
                    @endforeach
                </ul>
            </nav>
        </div>
    @endif
@endsection
