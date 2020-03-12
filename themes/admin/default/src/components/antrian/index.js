Vue.component("antrian-component", {
	data: function() {
		return {
			no: 1
		};
	},
	computed: {
		noPlus() {
			this.no++;
		}
	},
	props: ["antrians"],
	template: `
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Nomor Antrian</th>
                        <th>Loket Sementara</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(antrian,index) in antrians" :antrian="antrian">
                            <td class="text-center">{{no}}{{noPlus}}</td>
                            <td>{{ antrian.id}}</td>
                            <td>{{ antrian.counter }}</td>
                            <td>
                                <span v-if="antrian.status==3" class='badge badge-primary'>Belum dipanggil</span>
                                <span v-else="" class='badge badge-danger' data-toggle='tooltip' title='Pengantri tidak ada di tempat saat di panggil'>Sudah dipanggil</span>
                            </td>
                            <td class="td-actions text-right">
                                <button type="button" rel="tooltip" class="btn btn-success" data-original-title="" @click="panggil(antrian.id)" title="Belum di berikan aksi untuk tombol edit">
                                <i class="material-icons">edit</i> Panggil</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>`,
	methods: {
		async panggil(id) {
			try {
				let res = await getData("api/antrian/memanggil/" + id + "/" + idLoket);
				setDataGlobal(res);
			} catch (error) {
				console.log(error);
			}
		}
	}
});

function setDataGlobal(res) {
	let { loket, nextAntri, antrians } = res;
	vLoket.loket = loket[0];
	loket = loket[0];
	vLoket.next = nextAntri;
	vAntrian.antrians = antrians;
}
