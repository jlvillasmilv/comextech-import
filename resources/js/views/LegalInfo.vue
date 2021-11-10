<template>
    <div class="flex flex-wrap justify-center">
        <partners> </partners>
        <div class="sm:w-4/12">
            <br />
            <span class="text-blue-800 text-base font-medium mb-4">
                Contrato de Marco
            </span>
            <hr class="mt-4 mb-4 border-solid border-t-2" />

            <SingleFile
                :action="`Adjuntar`"
                :data="`contrato_marco`"
            ></SingleFile>
        </div>
    </div>
</template>

<script>
import SingleFile from '../components/Factoring/SingleFile';
import DownloadFile from '../components/Factoring/DownloadFile';

import Partners from '../components/Factoring/Partners';
export default {
    data() {
        return {
            title: 'Informacion Legal'
        };
    },
    components: {
        partners: Partners,
        SingleFile,
        DownloadFile
    },
    computed: {
        upPower() {
            console.log('aqui');
        }
    }
};
</script>
