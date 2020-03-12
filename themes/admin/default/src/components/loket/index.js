let loading = false;
Vue.component("loket-component", {
	data: function() {
		return {
			loading: loading
		};
	},
	props: { loket: "loket", next: "next" },
	template: `
		<div>
			<h1>Loket {{ loket.id }}</h1>
            <statusLoket-component v-bind:statusL="loket.status" v-bind:statusA="loket.statusAntrian" v-bind:client="loket.client"></statusLoket-component>
            
			<div class="container">
				<loading-component v-if="this.$parent.playing"></loading-component>
				<a v-else-if="loket.status==2&&next.id!=null&&!this.$parent.playing" class="btn btn-primary" @click="memanggilNext(next.id,loket.id)">Panggil Selanjutnya</a>
				<panggilUlang-component v-if="loket.status==1&&loket.statusAntrian==2&&!this.$parent.playing" :playing="this.$parent.playing" v-bind:idClient="loket.client" v-bind:idLoket="loket.id"></panggilUlang-component>
                <a v-if="next.id!=null&&loket.status==1&&loket.statusAntrian==2&&!this.$parent.playing" class="btn btn-danger" @click="lewati(loket.client,loket.id)">Lewati</a>
                <a v-if="loket.status==1&&loket.statusAntrian==1&&!this.$parent.playing" class="btn btn-success" @click="selesai(loket.client,loket.id)">Selesai</a>
            </div>
            <div class="loket-status">
                <closeLoket-component v-bind:lId="loket.id" :next="next" :aStatus="loket.statusAntrian" :lStatus="loket.status"></closeLoket-component>
            </div>
        </div>`,
	methods: {
		memanggil: () => {
			dataGlobal.statusAntrian = 1;
		},

		selesai: async (client, idLoket) => {
			vLoket.playing = true;
			try {
				let url = "api/antrian/selesai/" + client + "/" + idLoket;

				let resp = await getData(url);
				vLoket.playing = false;
				setDataGlobal(resp);
			} catch (error) {
				vLoket.playing = false;
				console.error(error);
			}
		},
		async memanggilNext(idAntr, idLoket) {
			vLoket.playing = true;
			try {
				let url = "api/antrian/memanggil/" + idAntr + "/" + idLoket;
				let resp = await getData(url);
				vLoket.playing = false;
				setDataGlobal(resp);
			} catch (error) {
				console.error(error);
				vLoket.playing = false;
			}
		},
		async lewati(an, loket) {
			vLoket.playing = true;
			console.log(an, loket);

			try {
				let url = "api/antrian/lewati/" + an + "/" + loket;
				let resp = await getData(url);

				vLoket.playing = false;
				setDataGlobal(resp);
			} catch (error) {
				console.error(error);
				vLoket.playing = false;
			}
		}
	}
});
Vue.component("panggilUlang-component", {
	data: function() {
		return { loading: false };
	},
	props: ["idClient", "idLoket", "playing"],
	template: `
			<div >
				<button v-on:click="callAgain" class="btn btn-warning">Panggil Ulang</button>
				<button v-on:click="success(idClient,idLoket,playing)" class="btn btn-success"><i class="material-icons">
				check_box
				</i> Success</button>
			</div>`,
	methods: {
		async callAgain() {
			vLoket.playing = true;
			try {
				await getData("api/push/playing");
				this.loading = loading;
			} catch (error) {
				this.loading = loading;
				console.error("Memanggil error", error);
			}
		},
		async success(id, idL, loading) {
			vLoket.playing = true;
			try {
				let resp = await getData(
					"api/antrian/antrianStagged/" + id + "/" + idL
				);
				setDataGlobal(resp);
				vLoket.playing = false;
			} catch (error) {
				console.error("Memanggil error", error);
				vLoket.playing = false;
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
	data: function() {
		return {
			loading: false
		};
	},
	props: ["lId", "lStatus", "aStatus", "next"],
	template: `
		<button v-if="loading" class="btn btn-warning"><i class="fa fa-circle-o-notch fa-spin"></i>Loading</button>
		<button v-else-if="(lStatus==2&&next.id==null)||(lStatus==1&&aStatus==1)" class="btn btn-danger" @click="closeIt(lId)">Tutup</button> 
		<button v-else-if="lStatus==0" class="btn btn-primary" @click="openIt(lId)">Open</button>`,
	methods: {
		async closeIt(idL) {
			this.loading = true;
			try {
				let url = "api/antrian/loketclose/" + idL;
				let resp = await getData(url);
				this.loading = false;
				setDataGlobal(resp);
			} catch (error) {
				console.error(error);
			}
		},
		async openIt(idL) {
			this.loading = true;
			try {
				let url = "api/antrian/loketopen/" + idL;
				let resp = await getData(url);
				this.loading = false;
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
Vue.component("loading-component", {
	template: `<button class="btn btn-warning btn-loading"><i class="fa fa-circle-o-notch fa-spin"></i>Loading..</button>`
});
function setDataGlobal(response) {
	let { loket, nextAntri } = response;
	vLoket.loket = loket[0];
	vLoket.next = nextAntri;
}
