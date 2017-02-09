@extends('layouts.app')

@section('content')
    <div class="container" id="user-creation-app">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                
                @component('skeleton::components.panel')
                    @slot('heading')
                        {{ $panelTitle or 'Título' }}
                    @endslot
                    @slot('body')
                        @php
                            $formSizes = ['label' => 6, 'input' => 6];
                        @endphp
                        <form class="form-horizontal" v-loading="formLoading" v-on:submit.prevent="save">
                            {{ Form::vueInputOpen('name', 'Nombre') }}
                                {{ Form::vueText('form.name') }}
                            {{ Form::vueInputClose('name') }}

                            {{ Form::vueInputOpen('email', 'Correo electrónico') }}
                                {{ Form::vueText('form.email', ['type' => 'email']) }}
                            {{ Form::vueInputClose('email') }}

                            {{ Form::vueInputOpen('password', 'Contraseña') }}
                                {{ Form::vueText('form.password', ['type' => 'password']) }}
                            {{ Form::vueInputClose('password') }}

                            {{ Form::vueInputOpen('password_confirmation', 'Repita contraseña') }}
                                {{ Form::vueText('form.password_confirmation', ['type' => 'password']) }}
                            {{ Form::vueInputClose('password_confirmation') }}

                            {{ Form::vueInputOpen('user_type_id', 'Tipo de usuario') }}
                                {{ Form::vueSelect('form.user_type_id', json_table('user_types')) }}
                            {{ Form::vueInputClose('user_type_id') }}

                            {{ Form::vueHFButtonOpen() }}
                                {{ Form::vueButton('Registrar', ['type' => 'success', 'native-type' => 'submit']) }}
                                {{ Form::vueButton('Cancelar', ['type' => 'default', '@click' => 'goBack']) }}
                            {{ Form::vueHFButtonClose() }}
                        </form>
                    @endslot
                @endcomponent
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var userCreationApp = new Vue({
            el: '#user-creation-app',
            data: {
                errors: [],
                formLoading: false,
                form: {
                    name: null,
                    email: null,
                    password: null,
                    password_confirmation: null,
                    user_type_id: null,
                }
            },
            methods: {
                cleanForm: function () {
                    this.form = {
                        name: null,
                        email: null,
                        password: null,
                        password_confirmation: null,
                        user_type_id: null,
                    }
                },
                cleanPassword: function () {
                    this.form.password = null;
                    this.form.password_confirmation = null;
                },
                goBack: function () {
                    this.loading = true;
                    window.location = '/usuarios';
                },
                save: function () {
                    this.formLoading = true;
                    this.$http.post('/usuarios', this.form)
                        .then(function (response) {
                            setTimeout(function(){
                                userCreationApp.cleanForm();
                                userCreationApp.formLoading = false;
                            }, 3000);
                            window.elementNotification.success({title: 'Usuario registrado!'});
                        })
                        .catch(function (error) {
                            window.elementNotification.error({title: 'Ups!', 'message': 'no se pudo procesar el registro'});
                            userCreationApp.cleanPassword();
                            userCreationApp.formLoading = false;
                            userCreationApp.errors = error.response.data;
                        })
                }
            }
        })
    </script>
@endpush
