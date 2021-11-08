<template>
    <div class="flex flex-wrap items-center -mx-4">
        <div class="relative -mx-4 flex-grow mb-2 max-w-full">
            <div class="relative inline-flex align-middle">
                <div class="" id="src-file1">
                    <!-- w-64 flex flex-colitems-center px-4 py-6 bg-whiterounded-md shadow-md tracking-wide uppercase border bg-blue-800 cursor-pointer hover:bg-purple-600 hover:text-whitetext-purple-600 ease-linear transition-all duration-150 -->
                    <label
                        class="font-normal text-base text-white text-center align-middle border border-solid border-transparent rounded bg-blue-800 border-gray-500 p-0 overflow-hidden inline-flex items-stretch justify-center"
                    >
                        <span class="px-2 py-1 mt-2 text-base leading-normal"
                            >Seleccionar Archivo</span
                        >
                        <input
                            type="file"
                            id="file"
                            ref="file"
                            class="hidden"
                        />
                        <button
                            v-on:change="submitFile()"
                            class="px-1 fas fa-cloud-upload-alt fa-2x"
                        ></button>
                    </label>
                </div>
                <!-- <label
                    class="-ml-px border border-solid border-transparent px-3 py-1.5 rounded text-base bg-blue-400"
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
                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </i>
                </label> -->
            </div>
        </div>
        <div class="flex flex-grow max-w-full relative px-4">
            <a
                v-if="status"
                class="font-normal text-base text-white text-center align-middle border border-solid border-transparent rounded bg-gray-500 border-gray-500 p-0 overflow-hidden inline-flex items-stretch justify-center"
                @click="download()"
            >
                <span class="inline-block px-3 py-3 bg-gray-700 ">
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
                await axios.post('factoring/single-file', formData, header);
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
            var path = '/download-file/' + this.data;
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
                '/download-file-validate/' + this.data
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
/* .file-select {
    position: relative;
    display: inline-block;
} */

/* .file-select::before {
    background-color: #6dc5d3;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 3px;
    content: 'Seleccionar'; 
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
} */
/* .team {
    position: relative;
    display: inline-block; 
} */

/* .file-select input[type='file'] {
    opacity: 0;
    width: 150px;
    height: 40px;
    display: inline-block;
}

#src-file1::before {
    content: 'Seleccionar Archivo';
} */
</style>
