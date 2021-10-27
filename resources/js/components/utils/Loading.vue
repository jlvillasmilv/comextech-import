<template>
    <div class="Loading__container">
        <div class="Loading__icon-container ">
            <img
                src="https://c.tenor.com/5o2p0tH5LFQAAAAi/hug.gif"
                alt="Loading..."
                class="Loading__icon-image"
            />
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {};
    },
    props: {}
};
</script>

<style>
.Loading__container {
    width: 100%;
    height: 100%;
    position: fixed;
    left: 0;
    top: 0;
    text-align: center;
    background-color: rgba(255, 255, 255, 0.6);
    z-index: 99999;
}

.Loading__icon-container {
    margin: auto;
    width: 100%;
    height: 100%;
    text-align: center;
    display: flex;
}

.Loading__icon-image {
    max-width: 80px;
    max-height: 80px;
    border: none;
    margin: auto;
}
</style>
