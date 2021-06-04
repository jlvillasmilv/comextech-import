<x-app-layout title="Formulario de registro">
	<div class="container grid px-6 mx-auto">
		<h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Solicitudes
        </h2>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        

            <form class="form-horizontal" role="form" method="POST" action="{{ isset($data) ? route('admin.applications.update', $data->id) : route('admin.applications.store') }}"  >
                @csrf
                 @if(isset($data))
		           @method('PUT')
		        @endif

      		</form>

	</div>
</x-app-layout>