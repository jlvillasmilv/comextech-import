<template>
    <div>
        <div class="flex flex-wrap justify-center -mx-5 p-1 w-full">
            <div
                class="flex flex-col flex-shrink-0 flex-grow-0 relative w-6/12 px-6"
            >
                <span class="text-blue-800 text-lg font-medium mb-4">
                    Estados Financieros
                </span>
                <hr />
                <SingleFile
                    :action="`Adjuntar`"
                    :data="`estados_finacieros`"
                ></SingleFile>
                <br />
                <span class="text-blue-800 text-lg font-medium mb-4">
                    Presentacion de Empresa</span
                >
                <hr />
                <SingleFile
                    :action="`Adjuntar`"
                    :data="`presentacion_empresa`"
                ></SingleFile>
                <br />
                <span class="text-blue-800 text-lg font-medium mb-4">
                    Otros
                </span>
                <hr />
                <SingleFile :action="`Adjuntar`" :data="`otros`"></SingleFile>
            </div>
            <div
                class="flex flex-col flex-shrink-0 flex-grow-0 relative w-6/12 px-6"
            >
                <span class="text-blue-800 text-lg font-medium mb-4">
                    Carpetas Tributarias Actualizadas
                </span>
                <hr />
                <SingleFile
                    :action="`Adjuntar`"
                    :data="`carp_tributaria`"
                ></SingleFile>
                <br />
                <span class="text-blue-800 text-lg font-medium mb-4">
                    Última declaracion de Impuesto Renta (SII)
                </span>
                <hr />
                <SingleFile
                    :action="`Adjuntar`"
                    :data="`impuesto_sii`"
                ></SingleFile>
            </div>
        </div>
    </div>
</template>

<script>
import SingleFile from '../components/Factoring/SingleFile';
import DownloadFile from '../components/Factoring/DownloadFile';

export default {
    data() {
        return {
            title: 'Informacion Financiera'
        };
    },
    components: {
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
