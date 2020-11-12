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

		i(desc, title="hey") {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        s(desc, title="berhasil") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        w(desc, title="awas") {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        e(desc, title="Astagfirullah") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
        swr(desc="Sesuatu ada salah!!", title="wrong") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        }
	},
}