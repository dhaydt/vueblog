<template>
    <div>
    <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0"><Icon type="md-pricetags" /> Assign Role
						<Select v-model="data.id" v-if="isWritePermitted"  placeholder="Select admin type" style="width: 360px" @on-change="changeAdmin">
                            <Option :value="r.id" v-for="(r, i) in roles" :key="i" v-if="roles.length">{{r.roleName}}</Option>

                            <!-- <Option value="Editor" >Editor</Option> -->
                        </Select>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>Resource Name</th>
								<th>Read</th>
								<th>Write</th>
								<th>Update</th>
								<th>Delete</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(r, i) in resources" :key="i" >
								<td>{{r.resourceName}}</td>
								<td><i-Switch v-model="r.read">
                                    <Icon type="md-checkmark" slot="open"></Icon>
                                    <Icon type="md-close" slot="close"></Icon>
                                </i-Switch></td>
                                <td><i-Switch v-model="r.write">
                                    <Icon type="md-checkmark" slot="open"></Icon>
                                    <Icon type="md-close" slot="close"></Icon>
                                </i-Switch></td>
                                <td><i-Switch v-model="r.update">
                                    <Icon type="md-checkmark" slot="open"></Icon>
                                    <Icon type="md-close" slot="close"></Icon>
                                </i-Switch></td>
                                <td><i-Switch v-model="r.delete">
                                    <Icon type="md-checkmark" slot="open"></Icon>
                                    <Icon type="md-close" slot="close"></Icon>
                                </i-Switch></td>
							</tr>
						</table>
                        <div class="center_button">
                            <Button type="primary" :loading="isSending" :disabled="isSending" @click="assignRoles">Assign</Button>
                        </div>
					</div>
				</div>


			</div>
	</div>
    </div>
</template>

<script>
import deleteModal from "../components/deleteModal.vue";
import {mapGetters} from 'vuex'
	export default {
		data() {
			return{
				data 			: {
									id: null
                                },
				isSending		: false,
				roles 			: [],
				resources		: [
                    {resourceName: 'Home', read: false, write: false, update: false, delete: false, icon: 'ios-home', name: '/'},
                    {resourceName: 'Tags', read: false, write: false, update: false, delete: false, icon: 'ios-desktop', name: 'tags'},
                    {resourceName: 'Category', read: false, write: false, update: false, delete: false, icon: 'ios-apps', name: 'category'},
                    {resourceName: 'Create Blog', read: false, write: false, update: false, delete: false, icon: 'ios-apps', name: 'createblog'},
                    {resourceName: 'Admin users', read: false, write: false, update: false, delete: false, icon: 'md-create', name: 'adminusers'},
                    {resourceName: 'Role', read: false, write: false, update: false, delete: false, icon: 'md-lock', name: 'role'},
                    {resourceName: 'Assign Role', read: false, write: false, update: false, delete: false, icon: 'md-contacts', name: 'assignrole'},
                ],
				defaultResourcesPermission: [
                    {resourceName: 'Home', read: false, write: false, update: false, delete: false, icon: 'ios-home', name: '/'},
                    {resourceName: 'Tags', read: false, write: false, update: false, delete: false, icon: 'ios-desktop', name: 'tags'},
                    {resourceName: 'Category', read: false, write: false, update: false, delete: false, icon: 'ios-apps', name: 'category'},
                    {resourceName: 'Create Blog', read: false, write: false, update: false, delete: false, icon: 'md-create', name: 'createblog'},

                    {resourceName: 'Admin users', read: false, write: false, update: false, delete: false, icon: 'ios-people', name: 'adminusers'},
                    {resourceName: 'Role', read: false, write: false, update: false, delete: false, icon: 'md-lock', name: 'role'},
                    {resourceName: 'Assign Role', read: false, write: false, update: false, delete: false, icon: 'md-contacts',  name: 'assignrole'},

                ],

			};
		},


		methods : {
			//mengubah assign
			async assignRoles() {
                let data = JSON.stringify(this.resources)
				const res = await this.callApi('post', 'app/assign_roles', {'permission' : data, id: this.data, })
				if(res.status==200){
                    this.s('Role berhasil didaftarkan!')
                    let index = this.roles.findIndex(role => role.id == this.data.id)
                    this.roles[index].permission = data
				}else{
					this.swr()
                }
                setTimeout(() => window.location.reload(), 500);

			},

			changeAdmin(){
                let index = this.roles.findIndex(role => role.id == this.data.id)
                let permission = this.roles[index].permission
                if(!permission){
                    this.resources = this.defaultResourcesPermission
                }else{
                    this.resources = JSON.parse(permission)
                }

            }
		},

	async created(){
        console.log(this.$route)
        const res = await this.callApi('get', 'app/get_roles')
		if(res.status==200){
            this.roles = res.data
            if(res.data.length){
                this.data.id = res.data[0].id
                if(res.data[0].permission){
                    this.resources = JSON.parse(res.data[0].permission)
                    //this.resources = this.defaultResourcesPermission
                }
            }
		} else {
			this.swr()
		}
	},
};
</script>
