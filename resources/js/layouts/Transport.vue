<template>
        <Container :bg="true">
            <div class="container grid px-6 my-1 ">
                <Load />
                <Addresses />
            </div>
        </Container>
</template>

<script>
import Container from '../components/Container.vue';
import Addresses from "../components/Transport/Addresses.vue";
import Load from "../components/Transport/Load.vue";

export default {
    components: {
        Load,
        Addresses,
        Container
    }
};
</script>

<style></style>
