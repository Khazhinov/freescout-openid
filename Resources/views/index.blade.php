<form class="form-horizontal margin-top margin-bottom" method="POST" action="" id="openid_form">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('settings.openid.active') ? ' has-error' : '' }} margin-bottom-10">
        <label for="openid.active" class="col-sm-2 control-label">{{ __('Active') }}</label>

        <div class="col-sm-6">
            <input id="openid.active" type="checkbox" class=""
                   name="settings[openid.active]"
                   @if (old('settings[openid.active]', $settings['openid.active']) == 'on') checked="checked" @endif
            />
        </div>
    </div>

    <div class="form-group{{ $errors->has('settings.openid.client_id') ? ' has-error' : '' }} margin-bottom-10">
        <label for="openid.client_id" class="col-sm-2 control-label">{{ __('Client ID') }}</label>

        <div class="col-sm-6">
            <input id="openid.client_id" type="text" class="form-control input-sized-lg"
                   name="settings[openid.client_id]" value="{{ old('settings.openid.client_id', $settings['openid.client_id']) }}">
            @include('partials/field_error', ['field'=>'settings.openid.client_id'])
        </div>
    </div>
    <div class="form-group{{ $errors->has('settings.openid.client_secret') ? ' has-error' : '' }} margin-bottom-10">
        <label for="openid.client_secret" class="col-sm-2 control-label">{{ __('Client Secret') }}</label>

        <div class="col-sm-6">
            <input id="openid.client_secret" type="text" class="form-control input-sized-lg"
                   name="settings[openid.client_secret]" value="{{ old('settings.openid.client_secret', $settings['openid.client_secret']) }}">
        </div>
    </div>
    <div class="form-group{{ $errors->has('settings.openid.auth_url') ? ' has-error' : '' }} margin-bottom-10">
        <label for="openid.auth_url" class="col-sm-2 control-label">{{ __('Authorization Endpoint URL') }}</label>

        <div class="col-sm-6">
            <input id="openid.auth_url" type="text" class="form-control input-sized-lg"
                   name="settings[openid.auth_url]" value="{{ old('settings.openid.auth_url', $settings['openid.auth_url']) }}">
        </div>
    </div>
    <div class="form-group{{ $errors->has('settings.openid.token_url') ? ' has-error' : '' }} margin-bottom-10">
        <label for="openid.token_url" class="col-sm-2 control-label">{{ __('Token Endpoint URL') }}</label>

        <div class="col-sm-6">
            <input id="openid.token_url" type="text" class="form-control input-sized-lg"
                   name="settings[openid.token_url]" value="{{ old('settings.openid.token_url', $settings['openid.token_url']) }}">
        </div>
    </div>
    <div class="form-group{{ $errors->has('settings.openid.user_url') ? ' has-error' : '' }} margin-bottom-10">
        <label for="openid.user_url" class="col-sm-2 control-label">{{ __('User Info Endpoint URL') }}</label>

        <div class="col-sm-6">
            <input id="openid.user_url" type="text" class="form-control input-sized-lg"
                   name="settings[openid.user_url]" value="{{ old('settings.openid.user_url', $settings['openid.user_url']) }}">
        </div>
    </div>
    <div class="form-group{{ $errors->has('settings.openid.scope') ? ' has-error' : '' }} margin-bottom-10">
        <label for="openid.scope" class="col-sm-2 control-label">{{ __('Scope') }}</label>

        <div class="col-sm-6">
            <input id="openid.scope" type="text" class="form-control input-sized-lg"
                   name="settings[openid.scope]" value="{{ old('settings.openid.scope', $settings['openid.scope']) }}">
        </div>
    </div>
    <div class="form-group{{ $errors->has('settings.openid.mailbox_ids') ? ' has-error' : '' }} margin-bottom-10">
        <label for="openid.mailbox_ids" class="col-sm-2 control-label">{{ __('Default mailbox IDs for linking users') }}</label>

        <div class="col-sm-6">
            <input id="openid.mailbox_ids" type="text" class="form-control input-sized-lg"
                   name="settings[openid.mailbox_ids]" value="{{ old('settings.openid.mailbox_ids', $settings['openid.mailbox_ids']) }}">
        </div>
    </div>

    <div class="form-group">
        <label for="openid.user_url" class="col-sm-2 control-label">{{ __('OpenID callback URL') }}</label>
        <a href="{{ route('openid_callback')  }}">{{ route('openid_callback')  }}</a>
    </div>

    <div class="form-group margin-top margin-bottom">
        <div class="col-sm-6 col-sm-offset-2">
            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>
        </div>
    </div>
</form>