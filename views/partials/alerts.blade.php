@if (session()->has('status'))
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success" role="alert">
                    {{ session()->get('status') }}
                </div>
            </div>
        </div>
    </div>
@elseif (session()->has('error'))
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                	{{ session()->get('error') }}
                </div>
            </div>
        </div>
    </div>
@elseif (session()->has('alert'))
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-{{ session()->get('alert')['type'] }}" role="alert">
                    {{ session()->get('alert')['message'] }}
                </div>
            </div>
        </div>
    </div>
@elseif (Config::get("skeleton.enable_activations", false))
    @if (Auth::check() && !Auth::user()->active)
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info" role="alert">
                            {{ trans('skeleton::activation.alert_message') }} <a href="{{ url('/auth/account/activate/email') }}" class="alert-link"
                                onclick="event.preventDefault();
                                         document.getElementById('activate-email-form').submit();">
                                {{ trans('skeleton::activation.alert_here') }}
                            </a>
                            <form id="activate-email-form" action="{{ route('activation-email') }}" method="POST" style="display: none;">
                                <?php echo e(csrf_field()); ?>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif