<template>
    <div>
        <tabs :options="{ useUrlFragment: false }">
            <tab name="Cuentas bancarias">
                <Bank />
            </tab>
            <tab name="Información legal">
                <LegalInfo />
            </tab>
            <tab name="Información financiera">
                <FinancialInfo/>
            </tab>
            <tab name="SII">
                <Provider />
            </tab>
            <tab name="Usuarios">
                <Users />
            </tab>
        </tabs>
    </div>
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
