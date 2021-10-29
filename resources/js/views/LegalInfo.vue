<template>
    <div class="row justify-content-center">
        <partners> </partners>
        <div class="col-lg-4">
            <br />
            <span class="h5 text-primary mb-4"> Contrato de Marco </span>
            <hr />

            <SingleFile
                :action="`Adjuntar`"
                :data="`contrato_marco`"
            ></SingleFile>
        </div>
    </div>
</template>

<script>
import SingleFile from "../components/SingleFile";
import DownloadFile from "../components/DownloadFile";

import Partners from "../components/Partners";
export default {
    data() {
        return {
            title: "Informacion Legal"
        };
    },
    components: {
        partners: Partners,
        SingleFile,
        DownloadFile
    },
    computed: {
        upPower() {
            console.log("aqui");
        }
    }
};
</script>
