<template>
    <div class="p-1">
        <div class="row justify-content-center">
            <ItemMenu title="Perfil" path="profile" icon="user"></ItemMenu>
            <ItemMenu
                title="Cuentas Corrientes"
                path="bank"
                icon="landmark"
            ></ItemMenu>
            <ItemMenu
                title="Informacion Legal"
                path="legalInfo"
                icon="balance-scale"
            ></ItemMenu>
            <ItemMenu
                title="Informacion Financiera"
                path="finacialInfo"
                icon="file-invoice-dollar"
            ></ItemMenu>
            <ItemMenu
                title="SII y Previred"
                path="providers"
                icon="file-building"
            ></ItemMenu>
        </div>
        <div class="row justify-content-center">
            <div
                class="col-12 bg-white border p-3 border-bottom-primary"
                style="width:auto;"
            >
                <keep-alive>
                    <router-view></router-view>
                </keep-alive>
            </div>
        </div>
    </div>
</template>

<script>
import ItemMenu from "./ItemMenu";

export default {
    components: {
        ItemMenu: ItemMenu
    }
};
</script>
