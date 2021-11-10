<template>
    <div class="flex flex-wrap justify-center">
        <div class="relative max-w-full px-2 py-2">
            <div class="relative inline-flex align-middle">
                <div
                    class="file-select"
                    id="src-file1 "
                    v-on:change="submitFile()"
                >
                    <input type="file" id="file" ref="file" />
                </div>

                <label
                    class="-ml-1 px-2 py-1.5 font-normal text-base text-white text-center align-middle border border-solid border-transparent rounded bg-blue-800 border-gray-500 p-0 overflow-hidden inline-flex items-stretch justify-center hover:bg-blue-900"
                >
                    <i class="px-1 fas fa-cloud-upload-alt fa-2x"></i>
                </label>
            </div>
        </div>
        <div class="items-center relative inline-flex px-2 py-2.5">
            <a
                v-if="status"
                class="-mt-2 font-normal text-base text-white text-center align-middle border border-solid border-transparent rounded bg-gray-500 border-gray-500 p-0 overflow-hidden inline-flex items-stretch justify-center hover:bg-gray-600"
                @click="download()"
            >
                <span
                    class="inline-block px-3 py-3 bg-gray-600 hover:bg-gray-700"
                >
                    <i>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </i>
                </span>
                <span class="inline-block px-3 py-1.5"> Descargar </span>
            </a>
            <h6 v-else class="text-base font-medium mt-1 mb-4">
                No posee un archivo cargado.
            </h6>
        </div>
    </div>
</template>

<script>
import Option from '../../config/alert';
export default {
    data() {
        return {
            title: 'Informacion Legal',
            file: '',
            status: false
        };
    },
    props: {
        data: {
            type: String
        },
        action: {
            type: String
        }
    },
    methods: {
        handleFileUpload() {},
        async submitFile() {
            this.$swal.fire(
                Option('info', 'Almacenando tu archivo, un momento!')
            );
            this.file = this.$refs.file.files[0];
            let formData = new FormData();
            formData.append('file', this.file);
            formData.append('type', this.data);
            let header = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            };
            try {
                await axios.post('/factoring/single-file', formData, header);
                this.status = true;
                this.$swal.fire(
                    Option('success', 'Archivo almacenado exitosamente!')
                );
            } catch (e) {
                this.$swal.fire(
                    Option('error', 'Ah ocurrido un error intente nuevamente!')
                );
            }
        },
        download() {
            var path = '/factoring/download-file/' + this.data;
            var a = document.createElement('A');
            a.href = path;
            a.download = path.substr(path.lastIndexOf('/') + 1);
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            this.$swal.fire(
                Option(
                    'success',
                    'En un momento su archivo se descargara en su ordenador!'
                )
            );
        },
        async validated() {
            let response = await axios.get(
                '/factoring/download-file-validate/' + this.data
            );
            this.status = response.data.status.length > 0 ? true : false;
        }
    },
    async created() {
        this.validated();
    }
};
</script>
<style scoped>
.file-select {
    position: relative;
    display: inline-block;
    padding-left: 10px;
}
.file-select::before {
    background-color: #1e429f;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 3px;
    content: 'Seleccionar Archivo'; /* texto por defecto */
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
}
.team {
    position: relative;
    display: inline-block; /* the default for span */
}
.file-select input[type='file'] {
    opacity: 0;
    width: 150px;
    height: 40px;
    display: inline-block;
}
#src-file1::before {
    content: 'Seleccionar Archivo';
}
</style>
