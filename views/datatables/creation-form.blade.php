<form class="form-horizontal" v-on:submit.prevent="save">
    <modal v-bind:show="showModal" ok-native-type="submit" :ok-text="isEdit ? 'Actualizar' : 'Guardar'" :ok-type="isEdit ? 'primary' : 'success'" v-on:cancel="cancel" v-bind:loading="formLoading" v-on:ok="save" :title="isEdit ? 'Editar registro' : 'Nuevo registro'">
        <div v-loading="formLoading">

            {{ Form::vueInputOpen('name', 'Nombre') }}
                {{ Form::vueText('form.name') }}
            {{ Form::vueInputClose('name') }}
            
        </div>
    </modal>
</form>