let loket = {};
const vLoket = new Vue({
	el: "#loket-page",
	state: {},
	data: { loket: Object, next: Object, playing: false },
	mounted() {
		setDataGlobal();
	}
});

const vAntrian = new Vue({
	el: "#antrian-page",
	data: { antrians: null, no: 1 },
	mounted() {
		setDataGlobal();
	}
});

function setDataGlobal() {
	getData("api/antrian/getdataloket/" + idLoket).then(res => {
		let { loket, nextAntri, antrians } = res;
		vLoket.loket = loket[0];
		loket = loket[0];
		vLoket.next = nextAntri;
		vAntrian.antrians = antrians;
	});
}

var pusher = new Pusher("f6b62ae006c0b51482f4", {
	cluster: "ap1",
	forceTLS: true
});
var channel = pusher.subscribe("my-channel");
channel.bind("my-event", async function(data) {
	if (data.playing) vLoket.playing = true;
	else vLoket.playing = false;
	if (data.antrianChange) {
		setDataGlobal();
	}
});
