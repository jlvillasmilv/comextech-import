<template>
    <tabs>
        <tab name="Informacion Legal">
            <div>
                <LegalInfo />
            </div>
        </tab>
        <tab name="Informacion Financiera">
            <div>
                <FinancialInfo/>
            </div>
        </tab>
        <tab name="SII y Previred">
            <div>
                <Provider />
            </div>
        </tab>
    </tabs>
</template>

<script>

import LegalInfo from "../../views/LegalInfo";
import FinancialInfo from "../../views/FinancialInfo";
import Provider from "../../views/Provider"

export default {
    name: "Menu",
    data: function() {
        return {
            data: {}
        };
    },
    components: {
       LegalInfo,
       FinancialInfo,
       Provider
    },
    computed: {},
    methods: {},
    created() {
        let user = JSON.parse(
            document.head.querySelector('meta[name="user"]').content
        );
    },
};
</script>
