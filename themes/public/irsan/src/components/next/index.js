Vue.component("next-component", {
	props: ["antrian", "id_antri"],
	template: `
        <div v-if="antrian=='kosong'">
            <h1><span>Sudah tidak ada Antrian </span></h1>
            <button class="btn btn-light btn-lg" type="button"><span class="fa fa-university">&nbsp;</span>Kosong.!</button>
        </div>
        <div v-else>
            <h1 class="display-4 mb-4"><span>Siap siap  </span><b>Nomor Antrian {{ id_antri }} </b> </h1>
            <button class="btn btn-light btn-lg" type="button"><span class="fa fa-university">&nbsp;</span>Di LOKET .?</button>
            <div class="container mt-3">
                <a disable class="btn btn-warning">Waiting..!</a>
            </div>
        </div>
    `
});
console.log("component Next");
