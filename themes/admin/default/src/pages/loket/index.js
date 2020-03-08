let dataGlobal = {};
const loket = new Vue({
	el: "#loket-page",
	state: {},
	data: { data: "", state: { ok: "ok" }, loading: false },
	mounted() {
		setDataGlobal();
	}
});

function setDataGlobal() {
	getData("api/antrian/getdataloket/" + idLoket).then(res => {
		dataGlobal = res;
		dataGlobal.loket = res.loket[0];
		loket.data = dataGlobal;
	});
}

var pusher = new Pusher("f6b62ae006c0b51482f4", {
	cluster: "ap1",
	forceTLS: true
});
var channel = pusher.subscribe("my-channel");
channel.bind("my-event", async function(data) {
	if (data.playing) loading = true;
	else loading = false;
	console.log(loading);
	if (data.antrianChange) {
		setDataGlobal();
	}
});
