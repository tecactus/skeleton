<form class="form-horizontal" v-on:submit.prevent="save">
    <modal v-bind:show="showModal" ok-native-type="submit" :ok-text="isEdit ? 'Actualizar' : 'Guardar'" :ok-type="isEdit ? 'primary' : 'success'" v-on:cancel="cancel" v-bind:loading="formLoading" v-on:ok="save" :title="isEdit ? 'Editar usuario' : 'Nuevo usuario'">
        <div v-loading="formLoading">

            <input-wrapper :errors="errors" model-name="user_type_id" label="Tipo de usuario">
                {{ Form::vueSelect('form.user_type_id', json_table('user_types')) }}
            </input-wrapper>

            <input-wrapper :errors="errors" model-name="name" label="Nombre">
                {{ Form::vueText('form.name') }}
            </input-wrapper>

            <input-wrapper :errors="errors" model-name="email" label="Correo electrónico">
                {{ Form::vueText('form.email', ['type' => 'email']) }}
            </input-wrapper>

            <input-wrapper :errors="errors" model-name="password" label="Contraseña">
                {{ Form::vueText('form.password', ['type' => 'password']) }}
            </input-wrapper>

            <input-wrapper :errors="errors" model-name="password_confirmation" label="Repita contraseña">
                {{ Form::vueText('form.password_confirmation', ['type' => 'password']) }}
            </input-wrapper>
            
        </div>
    </modal>
</form>