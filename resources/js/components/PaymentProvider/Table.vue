<template>
    
</template>

<script>
export default {
    props: {
        data: {
            default: () => {
                return [];
            },
            type: Array,
            required: true
        },
        amount: {
            required: true
        },
        currencies: {
            required: true
        }
    },
    methods: {
        deleteRow(item) {
            this.$emit("deleteRow", item);
        }
    },
    computed: {
        dataPays() {
            return this.data;
        }
    },
    created() {
        console.log(this.amount);
    }
};
</script>

<style></style>
