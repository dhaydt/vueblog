<template>
	<div>
		<h1 ref="myref">Hooks Pages</h1>
		<h2>My name is {{name}}</h2>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				name: 'dayat'
			}
		},

		beforeCreate() {
			console.log(this.name)
		},

		created() {
			//memanggil initial data darinya..
			console.log('data dan funsi lain tersedia kecuali html', this.name)
		},

		mounted() {
			console.log(this.$refs.myref)
		}
	}
</script>