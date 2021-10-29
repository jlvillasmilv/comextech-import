<template>
    <div class="col-lg text-center ">
        <router-link :to="{ name: path }">
            <i :class="`fa fa-${icon} fa-fw`" aria-hidden="true"></i>&nbsp;
            {{ title }}
        </router-link>
        <hr class="hr" />
    </div>
</template>

<script>
export default {
    props: ["title", "path", "icon"]
};
</script>

<style></style>
