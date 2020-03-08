let loading = false;
Vue.component("loket-component", {
	props: { loket: "loket", next: "next" },
	template: `
        <div style="padding-top:20px;padding-bottom:20px;">
            <h1>Loket {{ loket.id }}</h1>
            <statusLoket-component v-bind:statusL="loket.status" v-bind:statusA="loket.statusAntrian" v-bind:client="loket.client"></statusLoket-component>

            
            <div class="container">
                <a v-if="loket.status==2&&next!='kosong'" class="btn btn-primary" @click="memanggilNext(next.id,loket.id)">Panggil Selanjtnya</a>
                <panggilUlang-component v-if="loket.status==1&&loket.statusAntrian==2" v-bind:idClient="loket.client" v-bind:idLoket="loket.id"></panggilUlang-component>
                <a v-if="next!='kosong'&&loket.status==1&&loket.statusAntrian==2" class="btn btn-danger">Lewati</a>
                <a v-if="loket.status==1&&loket.statusAntrian==1" class="btn btn-success" @click="selesai(loket.client,loket.id)">Selesai</a>
                <a v-if="loket.status==1&&loket.statusAntrian==1" class="btn btn-success" @click="selesai(loket.client,loket.id)">Selesai</a>
            </div>
            <div class="loket-close" v-if="loket.status!=0">
                <closeLoket-component v-bind:load="this.$parent.loading" v-bind:idLoket="loket.id"></closeLoket-component>
            </div>
        </div>`,
	methods: {
		memanggil: () => {
			dataGlobal.statusAntrian = 1;
		},

		selesai: async (client, idLoket) => {
			if (!loading) {
				try {
					loket.state.loading = true;
					let url = "api/antrian/selesai/" + client + "/" + idLoket;
					let resp = await getData(url);
					setDataGlobal(resp);
				} catch (error) {
					console.error(error);
				}
			}
		},
		memanggilNext: async (idAntr, idLoket) => {
			if (!loading) {
				try {
					loket.state.loading = true;
					let url = "api/antrian/memanggil/" + idAntr + "/" + idLoket;
					let resp = await getData(url);
					setDataGlobal(resp);
					console.log(dataGlobal);
				} catch (error) {
					console.error(error);
				}
			}
		}
	}
});
Vue.component("panggilUlang-component", {
	props: ["idClient", "idLoket"],
	template: `
        <div>
            <a class="btn btn-warning" v-on:click="callAgain">Panggil Ulang</a>
            <v-btn class="btn btn-success" color="primary" dark v-on:click="success(idClient,idLoket)">Accept
                <v-icon dark right>mdi-checkbox-marked-circle</v-icon>
            </v-btn>
        </div>`,
	methods: {
		callAgain: async () => {
			if (!loading) {
				try {
					await getData("api/push/playing");
				} catch (error) {
					console.error("Memanggil error", error);
				}
			}
		},
		success: async (id, idL) => {
			try {
				let resp = await getData(
					"api/antrian/antrianStagged/" + id + "/" + idL
				);
				dataGlobal = resp;
				dataGlobal.loket = resp.loket[0];
			} catch (error) {
				console.error("Memanggil error", error);
			}
		}
	}
});
Vue.component("statusLoket-component", {
	props: { statusL: "statusL", statusA: "statusA", client: "client" },
	template: `
    <div class="status-loket-antrian">
        <transition
        name="custom-classes-transition"
        enter-active-class="animated tada"
        leave-active-class="animated bounceOutRight">
            <statusAntrian-component v-if="statusL==1" v-bind:client="client" v-bind:status="statusA"></statusAntrian-component>            
        </transition>
        
        <transition
        name="custom-classes-transition"
        enter-active-class="animated tada"
        leave-active-class="animated bounceOutRight">
            <button v-if="statusL==0" class='btn btn-light btn-lg' type='button'><span class='fa fa-university'>&nbsp;</span> TUTUP</button>
        </transition>
        <transition
        name="custom-classes-transition"
        enter-active-class="animated tada"
        leave-active-class="animated bounceOutRight">
            <button v-if="statusL==2" class='btn btn-warning btn-lg' type='button'><span class='fa fa-university'>&nbsp;</span>OPEN</button>
        </transition>
    </div>
    `
});
Vue.component("closeLoket-component", {
	props: { load: "load", idL: "idLoket" },
	template: `
        <v-btn v-bind:loading="load" color="'error'" @click="closeIt(idL)" large>Tutup</v-btn>`,
	methods: {
		closeIt: async idL => {
			loket.loading = true;
			try {
				let url = "api/antrian/loketclose/" + idL;
				let resp = await getData(url);
				loket.loading = false;
				setDataGlobal(resp);
			} catch (error) {
				console.error(error);
			}
		}
	}
});
Vue.component("statusAntrian-component", {
	props: { client: "client", status: "status" },
	template: `
    <div class="antrian-active">
        <transition
        name="custom-classes-transition"
        enter-active-class="animated tada"
        leave-active-class="animated bounceOutRight">
            <button v-if="status==2" class='btn btn-warning btn-lg' type='button'><span class='fa fa-university'>&nbsp;</span> Antrian ke {{ client }} Dipanggil ..! </button>
        </transition>
        <transition
        name="custom-classes-transition"
        enter-active-class="animated tada"
        leave-active-class="animated bounceOutRight">
            <button v-if="status==1" class='btn btn-primary btn-lg' type='button'><span class='fa fa-university'>&nbsp;</span> Antrian {{ client }} </button>
        </transition>
     </div>
    `
});
function setDataGlobal(response) {
	let next = response.nextAntry;
	let lkt = response.loket[0];
	dataGlobal.loket = lkt;
	dataGlobal.nextAntri = next;
}
