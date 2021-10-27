<template>
    <tabs>
        <tab name="Facturas(SII)">
            <div>
                <invoceStore></invoceStore>
            </div>
        </tab>
        <tab name="Subir factura (XML)">
            <div>
                <form_xml></form_xml>
            </div>
        </tab>
        <!-- <tab name="Pronto Pago">
            Third tab content
        </tab> -->
    </tabs>
</template>

<script>
import vue2Dropzone from "vue2-dropzone";
import Invoice from "../components/Factoring/Invoices";
import FormXml from "../components/Factoring/FormXml";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
 
const moment = require("moment");

export default {
    name: "Quote",
    data: function() {
        return {
            data: {}
        };
    },
    components: {
        vueDropzone: vue2Dropzone,
        invoceStore: Invoice,
        form_xml: FormXml
    },
    computed: {},
    methods: {},
    created() {
        let user = JSON.parse(
            document.head.querySelector('meta[name="user"]').content
        );
    },
    beforeMount() {}
};
</script>
