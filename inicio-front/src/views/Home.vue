<template>
	<div>
		<b-row>
			<b-col cols="12">
				<b-card header="Modulos"
		          tag="article"
		          class="m-3 mt-3">
		          <b-row>
								<b-col cols="12" sm="6" lg="3" v-if="aplicaciones.length > 0" v-for="aplicacion in aplicaciones" :key="'apli_' + aplicacion.id">
									<b-card :no-body="true" footer-class="px-3 py-2">
										<b-card-body class="p-3 clearfix">
											<i :class="aplicacion.icono + ' bg-primary p-3 font-2xl mr-3 float-left'"></i>
											<div class="h5 text-primary mb-0 mt-2">{{aplicacion.descripcion}}</div>
											<div class="text-muted text-uppercase font-weight-bold font-xs">{{aplicacion.descripcion}}</div>
										</b-card-body>
										<div slot="footer">
											<b-link class="font-weight-bold font-xs btn-block text-muted" target="_blank" :href="aplicacion.url">Abrir Modulo <i class="fa fa-angle-right float-right font-lg"></i></b-link>
										</div>
									</b-card>
								</b-col>
								<b-col cols="12" sm="6" lg="3" v-else>
									No tiene aplicaciones asiganadas
								</b-col>
							</b-row><!--/.row-->
		  		</b-card>
			</b-col>
		</b-row>
		<b-row>
			<b-col cols="12">
				<b-card header="Información"
		          tag="article"
		          class="m-3 mt-3">
		          <b-row align-v="center" class="text-center">
									
		          	<b-col sm="12" md="3">
		          	  <b-img fluid src="static/img/logo_login.jpg" alt="logo"/>
		          	</b-col>
		          	<b-col class=" texto-pae text-justify">
		          		<p class="card-text">
					      	Restaurante Pinchetas.
									</p>
		          	</b-col>
		          </b-row>
		  		</b-card>
			</b-col>
		</b-row>
	</div>
</template>
<style>
</style>
<script>
export default {
  data () {
    return {
			aplicaciones: []
    }
	},
  methods: {
    listarAplicaciones: function () {
			
			var self = this
			let token_json = window.localStorage.getItem('token')
			let frm = {
				token: token_json
			}
      this.$http.post('ws/aplicacion/listar_por_usuario.php', frm).then(resp => {
				let respuesta = resp.data
				this.aplicaciones = resp.data.aplicaciones
				this.$loader.close()
      }).catch(err => {
        if (err) {
          console.log(err)
					this.$toast.error('error' + err)
					this.$loader.close()
        }
      })
    }
  },
  created: function () {
	},
	mounted: function () {
		this.listarAplicaciones()
		this.$loader.close()
		this.$loader.open({message: 'Cargando modulos ...'})
  }
}
</script>
