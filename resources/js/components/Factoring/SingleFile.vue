<template>
    <div class="row ">
        <div class="col mb-2">
            <div class=" btn-group btn-group-toggle ">
                <div
                    class="file-select"
                    id="src-file1"
                    v-on:change="submitFile()"
                >
                    <input type="file" id="file" ref="file" />
                </div>
                <label class="btn btn-info">
                    <i class="fas fa-upload fa-md"> </i>
                </label>
            </div>
        </div>
        <div class="col ">
            <a
                v-if="status"
                class="btn btn-largue btn-secondary btn-icon-split"
                @click="download()"
            >
                <span class="icon">
                    <i class="fas fa-download fa-md"></i>
                </span>
                <span class="text"> Descargar </span>
            </a>
            <h6 v-else class="h6 text-dark mb-4">
                No posee un archivo cargado.
            </h6>
        </div>
    </div>
</template>

<script>
import Option from "../../config/alert";
export default {
    data() {
        return {
            title: "Informacion Legal",
            file: "",
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
                Option("info", "Almacenando tu archivo, un momento!")
            );
            this.file = this.$refs.file.files[0];
            let formData = new FormData();
            formData.append("file", this.file);
            formData.append("type", this.data);
            let header = {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            };
            try {
                await axios.post("factoring/single-file", formData, header);
                this.status = true;
                this.$swal.fire(
                    Option("success", "Archivo almacenado exitosamente!")
                );
            } catch (e) {
                this.$swal.fire(
                    Option("error", "Ah ocurrido un error intente nuevamente!")
                );
            }
        },
        download() {
            var path = "/download-file/" + this.data;
            var a = document.createElement("A");
            a.href = path;
            a.download = path.substr(path.lastIndexOf("/") + 1);
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            this.$swal.fire(
                Option(
                    "success",
                    "En un momento su archivo se descargara en su ordenador!"
                )
            );
        },
        async validated() {
            let response = await axios.get(
                "/download-file-validate/" + this.data
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
}

.file-select::before {
    background-color: #6dc5d3;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 3px;
    content: "Seleccionar"; /* testo por defecto */
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

.file-select input[type="file"] {
    opacity: 0;
    width: 150px;
    height: 40px;
    display: inline-block;
}

#src-file1::before {
    content: "Seleccionar Archivo";
}
</style>
