<template>
    <div>
    <div  v-if="$store.state.user">
    <!--========== ADMIN SIDE MENU one ========-->
    <div class="_1side_menu" >
    <div class="_1side_menu_logo">
        <h3 style="text-align:center;"><Icon type="logo-github" />VUE-BLOG-CREATOR</h3>
        <!--<img src="/img/logo.jpg" style="width: 108px;margin-left: 68px;"/>-->
    </div>

    <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
    <div class="_1side_menu_content">
        <div class="_1side_menu_img_name">
        <!-- <img class="_1side_menu_img" src="/pic.png" alt="" title=""> -->
        <p class="_1side_menu_name">Admin</p>
        </div>

        <!--~~~ MENU LIST ~~~~~~-->
        <div class="_1side_menu_list">
        <ul class="_1side_menu_list_ul">
            <li v-for="(menuItem, i) in permission" :key="i" v-if="permission.length && menuItem.read">
            <router-link :to="menuItem.name"><Icon :type="menuItem.icon" /> {{menuItem.resourceName}}</router-link>
            </li>

            <!-- <li><li><router-link to="/"><Icon type="ios-home" /> Dashboard</router-link></li>
            <li><router-link to="tags"><Icon type="ios-desktop" /> Tags</router-link></li>
            <li><router-link to="cat"><Icon type="ios-apps" /> Kategori</router-link></li>
            <li><router-link to="adminusers"><Icon type="ios-people" /> Users</router-link></li>
            <li><router-link to="role"><Icon type="md-lock" /> Role Management</router-link></li>
            <li><router-link to="assignrole"><Icon type="md-contacts" /> Assign Roles</router-link></li> -->


            <li><a href="/logout"><Icon type="md-log-out" /> Logout</a></li>
        </ul>
        </div>
    </div>
    </div>
    <!--========== ADMIN SIDE MENU ========-->

    <!--========= HEADER ==========-->
    <div class="header">
    <div class="_2menu _box_shadow">
        <div class="_2menu_logo">
        <ul class="open_button">
            <li>
            <Icon type="ios-list" />
            </li>
            <!--<li><Icon type="ios-albums" /></li>-->
        </ul>
        </div>
    </div>
    </div>
    <!--========= HEADER ==========-->
    </div>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    props: ['user', 'permission'],

    data() {
        return {
            isLoggedIn : false,
        }
    },
    created(){
        this.$store.commit('setUpdateUser', this.user)
        this.$store.commit('setUserPermission', this.permission)
        //console.log(this.permission)
    }
}
</script>

<style>

</style>
