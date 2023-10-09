<div class="profile-container d-flex align-items-stretch p-3 rounded lh-sm position-relative overflow-hidden">

    <a href="{{ route(config('platform.profile', 'platform.profile')) }}" class="col-10 d-flex align-items-center me-3">
        @if($image = Auth::user()->presenter()->image())
            <img src="{{$image}}"  alt="{{ Auth::user()->presenter()->title()}}" class="thumb-sm avatar b me-3" type="image/*">
        @endif

        <small class="d-flex flex-column" style="line-height: 16px;">
            <span class="text-ellipsis text-white">{{Auth::user()->presenter()->title()}}</span>
            <span class="text-ellipsis text-muted">{{Auth::user()->presenter()->subTitle()}}</span>
        </small>
    </a>
    <a href="#" class="nav-link p-0 d-flex align-items-center" data-bs-toggle="dropdown">
        @if($image = Auth::user()->presenter()->image())
            <span class="thumb-sm avatar me-3">
                    <img src="{{$image}}" class="b">
            </span>
        @endif
        <span class="d-block small">
            <span class="text-ellipsis text-white" style="max-width: 12em;">{{Auth::user()->presenter()->title()}}</span>
            <span class="text-muted d-block text-ellipsis">{{Auth::user()->presenter()->subTitle()}}</span>
        </span>
    </a>

    <x-orchid-notification/>

</div>
