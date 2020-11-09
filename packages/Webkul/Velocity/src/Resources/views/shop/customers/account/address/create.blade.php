@extends('shop::customers.account.index')

@section('page_title')
    {{ __('shop::app.customer.account.address.create.page-title') }}
@endsection

@section('page-detail-wrapper')
    <div class="account-head mb-15">
        <span class="back-icon"><a href="{{ route('customer.account.index') }}"><i class="icon icon-menu-back"></i></a></span>
        <span class="account-heading">{{ __('shop::app.customer.account.address.create.title') }}</span>
        <span></span>
    </div>

    {!! view_render_event('bagisto.shop.customers.account.address.create.before') !!}

        <form method="post" action="{{ route('customer.address.store') }}" @submit.prevent="onSubmit">

            <div class="account-table-content">
                @csrf

                {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.before') !!}

                <div class="control-group" :class="[errors.has('company_name') ? 'has-error' : '']">
                    <label for="company_name">{{ __('shop::app.customer.account.address.create.company_name') }}</label>
                    <input type="text" class="control" name="company_name" value="{{ old('company_name') }}" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.company_name') }}&quot;">
                    <span class="control-error" v-if="errors.has('company_name')">@{{ errors.first('company_name') }}</span>
                </div>

                {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.company_name.after') !!}

                <div class="control-group" :class="[errors.has('first_name') ? 'has-error' : '']">
                    <label for="first_name" class="mandatory">{{ __('shop::app.customer.account.address.create.first_name') }}</label>
                    <input type="text" class="control" name="first_name" value="{{ old('first_name') }}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.first_name') }}&quot;">
                    <span class="control-error" v-if="errors.has('first_name')">@{{ errors.first('first_name') }}</span>
                </div>

                {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.first_name.after') !!}

                <div class="control-group" :class="[errors.has('last_name') ? 'has-error' : '']">
                    <label for="last_name" class="mandatory">{{ __('shop::app.customer.account.address.create.last_name') }}</label>
                    <input type="text" class="control" name="last_name" value="{{ old('last_name') }}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.last_name') }}&quot;">
                    <span class="control-error" v-if="errors.has('last_name')">@{{ errors.first('last_name') }}</span>
                </div>

                {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.last_name.after') !!}

                <div class="control-group" :class="[errors.has('vat_id') ? 'has-error' : '']">
                    <label for="vat_id">{{ __('shop::app.customer.account.address.create.vat_id') }}
                        <span class="help-note">{{ __('shop::app.customer.account.address.create.vat_help_note') }}</span>
                    </label>
                    <input type="text" class="control" name="vat_id" value="{{ old('vat_id') }}" v-validate="" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.vat_id') }}&quot;">
                    <span class="control-error" v-if="errors.has('vat_id')">@{{ errors.first('vat_id') }}</span>
                </div>

                {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.vat_id.after') !!}

                @php
                    $addresses = explode(PHP_EOL, (old('address1') ?? ''));
                @endphp

                <div class="control-group" :class="[errors.has('address1[]') ? 'has-error' : '']">
                    <label for="address_0" class="mandatory">{{ __('shop::app.customer.account.address.create.street-address') }}</label>
                    <input type="text" class="control map-input" name="address1[]" id="address_0" value="{{ $addresses[0] ?: '' }}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.street-address') }}&quot;">
                    <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
                    <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
                    <span class="control-error" v-if="errors.has('address1[]')">@{{ errors.first('address1[]') }}</span>
                </div>

                @if (core()->getConfigData('customer.settings.address.street_lines') && core()->getConfigData('customer.settings.address.street_lines') > 1)
                    @for ($i = 1; $i < core()->getConfigData('customer.settings.address.street_lines'); $i++)
                        <div class="control-group" style="margin-top: -25px;">
                            <input type="text" class="control" name="address1[{{ $i }}]" id="address_{{ $i }}" value="{{ $addresses[$i] ?? '' }}">
                        </div>
                    @endfor
                @endif

                {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.street-address.after') !!}

                <div class="control-group" :class="[errors.has('district') ? 'has-error' : '']">
                    <label for="district" class="mandatory">
                        {{ __('shop::app.customer.account.address.create.district') }}
                    </label>
                    <select type="text" v-validate="'required'" class="control styled-select" id="district" name="district" v-model="district" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.district') }}&quot;">
                        <option value=""></option>
                            <option value="Belize">Belize</option>
                            <option value="Orange Walk">Orange Walk</option>
                            <option value="Cayo">Cayo</option>
                            <option value="Corozal">Corozal</option>
                            <option value="Stann Creek">Stan Creek</option>
                            <option value="Toledo">Toledo</option>
                    </select>
                    <div class="select-icon-container">
                        <span class="select-icon rango-arrow-down"></span>
                    </div>
                    <span class="control-error" v-if="errors.has('district')">
                        @{{ errors.first('district') }}
                    </span>
                </div>

                <div class="control-group" :class="[errors.has('city') ? 'has-error' : '']">
                    <label for="city" class="mandatory">{{ __('shop::app.customer.account.address.create.city') }}</label>
                    <input type="text" class="control" name="city" value="{{ old('city') }}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.city') }}&quot;">
                    <span class="control-error" v-if="errors.has('city')">@{{ errors.first('city') }}</span>
                </div>

                {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.city.after') !!}

                <div class="control-group" :class="[errors.has('phone') ? 'has-error' : '']">
                    <label for="phone" class="mandatory">{{ __('shop::app.customer.account.address.create.phone') }}</label>
                    <input type="text" class="control" name="phone" value="{{ old('phone') }}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.phone') }}&quot;">
                    <span class="control-error" v-if="errors.has('phone')">@{{ errors.first('phone') }}</span>
                </div>

                {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.after') !!}

                <div class="control-group">
                    <div id="address-map-container" style="width:100%;height:400px;border:solid 1px #cccccc;">
                        <div style="width: 100%; height: 100%" id="address-map"></div>
                    </div>
                </div>

                <div class="button-group">
                    <button class="theme-btn" type="submit">
                        {{ __('shop::app.customer.account.address.create.submit') }}
                    </button>
                </div>
            </div>
        </form>

    {!! view_render_event('bagisto.shop.customers.account.address.create.after') !!}
@endsection
@push('scripts')
    @parent
    <script src="{{ asset('themes/velocity/assets/js/mapInput.js') }}"></script>
    <script type="text/javascript">
        window.onload = () => {
            initialize()
        }
    </script>
@endpush