@php
	$url = request()->segments()[0];
@endphp

<script>
	window.{{ $jsAsyncApp }} = new Vue({
	    el: '#datatable-creation-app',
	    data: {
	        showModal: false,
	        errors: {},
	        formLoading: false,
	        form: {
	            name: null,
	        }
	    },
	    computed: {
	        isEdit: function () {
	            return this.form.id ? true : false;
	        }
	    },
	    methods: {
	        displayModal: function () {
	            this.showModal = true;
	        },
	        cleanForm: function () {
	            this.errors = {};
	            this.form = {
	                name: null,
	            }
	        },
	        cancel: function () {
	            this.cleanForm();
	            this.showModal = false;
	        },
	        save: function () {
	            this.formLoading = true;

	            var method = this.isEdit ? 'put' : 'post';
	            var url = this.isEdit ? '/{{ $url }}/' + this.form.id : '/{{ $url }}';

	            axios[method](url, this.form)
	                .then(function (response) {
	                    window.elementNotification.success({title: 'Registro completado!'});
	                    window.Skeleton.reloadDatatable();
	                    {{ $jsAsyncApp }}.cleanForm();
	                    {{ $jsAsyncApp }}.showModal = false;
	                    {{ $jsAsyncApp }}.formLoading = false;
	                })
	                .catch(function (error) {
	                    window.elementNotification.error({title: 'Ups!', 'message': 'no se pudo procesar el registro'});
	                    {{ $jsAsyncApp }}.formLoading = false;
	                    {{ $jsAsyncApp }}.errors = error.response.data;
	                })
	        },
	        loadRecord: function (userId) {
	            this.formLoading = true;
	            axios.get('/{{ $url }}/' + userId)
	                .then(function (response) {
	                    {{ $jsAsyncApp }}.form = response.data;
	                    {{ $jsAsyncApp }}.formLoading = false;
	                    {{ $jsAsyncApp }}.showModal = true;
	                })
	                .catch(function (error) {
	                    window.elementNotification.error({title: 'Ups!', 'message': 'no se pudo cargar el registro'});
	                    {{ $jsAsyncApp }}.formLoading = false;
	                })
	        }
	    }
	});
</script>