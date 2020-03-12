Vue.component("card-loket", {
	props: ["loket"],
	template: `
            <div class="card card-loket">
                <div class="card-body text-center">
                    <h1 class="card-title text-center display-2"><b>Loket {{ loket.id }}</b></h1>
                    <hr class="white">
                    
                    <button v-if="loket.status==1 && loket.statusAntrian==2" class="btn btn-danger btn-lg d-block w-100" type="button">
                            <h2 class="display-5 text-center">client Antrian {{loket.client}}</h2>
                    </button>    
                    <button v-else-if="loket.status==1" class="btn btn-primary  btn-lg d-block w-100" type="button">
                            <h2 class="text-center">client Antrian {{loket.client}}</h2>
                    </button>    

                    <button v-else-if="loket.status==2" class="btn btn-warning btn-lg d-block w-100" type="button">
                        <h2 class="display-5 text-center">Open</h2>
                    </button>    

                    <button v-else="" class="btn btn-secondary btn-lg d-block w-100" type="button">
                        <h2 class="display-5 text-center">Tutup</h2>
                    </button>
                </div>
            </div>`
});
