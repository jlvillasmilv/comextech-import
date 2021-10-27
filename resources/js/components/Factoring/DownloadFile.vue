<template>
    <a
        v-if="status"
        class="btn btn-largue btn-secondary btn-icon-split"
        @click="download()"
    >
        <span class="icon">
            <i class="fas fa-download fa-md"></i>
        </span>
        <span class="text"> {{ action }} </span>
    </a>
</template>
<script>
//import Option from "@/config/alert";

export default {
    data() {
        return {
            action: "Descargar",
            status: false
        };
    },
    props: {
        file: {
            type: String
        }
    },
    methods: {
        async download() {
            let response = await axios.get(
                "/download-file-validate/" + this.file
            );
            this.status = response.data.exist;
            if (response.data.status) {
                var path = "/factoring/download-file/" + this.file;
                var a = document.createElement("A");
                a.href = path;
                //a. target  = "_blank"
                a.download = path.substr(path.lastIndexOf("/") + 1);
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            }
        }
    },
    created() {
        this.download();
    }
};
</script>
