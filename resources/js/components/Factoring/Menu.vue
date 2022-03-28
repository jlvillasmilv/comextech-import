<template>
    <tabs>
        <tab name="Cuentas bancarias">
            <div>
                <Bank />
            </div>
        </tab>
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
         <tab name="Usuarios">
            <Users />
        </tab>
    </tabs>
</template>

<script>

import Bank from "../../views/Bank";
import LegalInfo from "../../views/LegalInfo";
import FinancialInfo from "../../views/FinancialInfo";
import Provider from "../../views/Provider"
import Users from "../../views/Users"

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
       Provider,
       Bank,
       Users
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
