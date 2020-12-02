import { mapGetters } from 'vuex'
export default {
	data() {
		return {

		}
	},
	methods: {
		//akan dipanggil pada tags.vue untuk memanggil data
		async callApi(method, url, dataObj) {
			try{
				return await axios({
				  method: 'post',
				  url: url,
				  data: dataObj
			});
		} catch (e) {
			return e.response
			}
		},

		i(desc, title="Info!!") {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        s(desc, title="Berhasil!!") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        w(desc, title="Hati-Hati!!") {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        e(desc, title="Astagfirullah!!") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
        swr(desc="Sesuatu ada salah!!", title="Wrong!!") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },

        checkUserPermission(key){
            if(!this.userPermission) return true
            let isPermitted = false;
            for(let d of this.userPermission){
                if(this.$route.name==d.name){
                    if(d[key]){
                        isPermitted = true
                        break;
                    }else{
                        break
                    }
                }
            }
            return isPermitted
        }
    },

    computed: {
        ...mapGetters({
            'userPermission' : 'getUserPermission'
        }),
        isReadPermitted(){
            return this.checkUserPermission('read')
        },
        isWritePermitted(){
            return this.checkUserPermission('write')
        },
        isUpdatePermitted(){
            return this.checkUserPermission('update')
        },
        isDeletePermitted(){
            return this.checkUserPermission('delete')
        },
    },
}
