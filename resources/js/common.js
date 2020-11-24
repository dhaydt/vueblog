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
        }
	},
}
