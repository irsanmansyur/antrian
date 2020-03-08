let dataGlobal = null;
const home = new Vue({
	el: "#home-page",
	data: { data: "" },
	mounted() {
		setDataGlobal();
	}
});
function setDataGlobal() {
	getData("api/antrian/getdataloket").then(res => {
		dataGlobal = res;
		home.data = dataGlobal;
		let arr = res.loket;
		let ab = arr.filter(
			({ status, statusAntrian }) => status == 1 && statusAntrian == 2
		);
		asyncForEach(ab, async loket => {
			await panggil(loket);
		});
	});
}
const audio = document.createElement("AUDIO");
function playAudio(tambahan = 1000) {
	return new Promise(resolve => {
		audio.currentTime = 0;
		audio.play();
		setTimeout(() => {
			time = audio.duration * 1000 + tambahan;
			setTimeout(() => {
				resolve(time);
			}, time);
		}, 1000);
	});
}
let time = 1000;

const panggil = ({ client, id }) => {
	return new Promise(async (res, rej) => {
		audio.currentTime = 0;
		audio.src = baseUrl + "assets/audio/new/in.wav";
		time = await playAudio();
		audio.src = baseUrl + "assets/audio/new/nomor-urut.MP3";
		time = await playAudio(300);
		let next = null;
		let end = null;
		if (client < 10) {
			audio.src = baseUrl + "assets/audio/new/" + client + ".MP3";
		} else if (client == 10) {
			audio.src = baseUrl + "assets/audio/new/sepuluh.MP3";
		} else if (client == 11) {
			audio.src = baseUrl + "assets/audio/new/sebelas.MP3";
		} else if (client < 20) {
			next = baseUrl + "assets/audio/new/belas.MP3";
			let no = client.substr(-1);
			audio.src = baseUrl + "assets/audio/new/" + no + ".MP3";
		} else if (client % 2 == 0) {
			no = client.substr(0, 1);
			next = baseUrl + "assets/audio/new/puluh.MP3";
			audio.src = baseUrl + "assets/audio/new/" + no + ".MP3";
		} else if (client < 100) {
			no = client.substr(0, 1);
			end = client.substr(-1);
			next = baseUrl + "assets/audio/new/puluh.MP3";
			audio.src = baseUrl + "assets/audio/new/" + no + ".MP3";
		}
		time = await playAudio();
		if (next) time = await playAudio(10);
		if (end) time = await playAudio(50);
		audio.src = baseUrl + "assets/audio/new/loket.MP3";
		time = await playAudio(100);
		audio.src = baseUrl + "assets/audio/new/" + id + ".MP3";
		time = await playAudio(200);
		audio.src = baseUrl + "assets/audio/new/out.wav";
		time = await playAudio();
		res(true);
	});
};
async function asyncForEach(array, callback) {
	for (let index = 0; index < array.length; index++) {
		let antrian = array[index];
		await callback(antrian);
	}
	try {
		getData("api/push/PlayFinish").then(res => console.log(res));
	} catch (error) {
		console.log(error);
	}
}

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher("f6b62ae006c0b51482f4", {
	cluster: "ap1",
	forceTLS: true
});
var channel = pusher.subscribe("my-channel");
channel.bind("my-event", async function(data) {
	if (data.playing) {
		setDataGlobal();
	}
	if (data.antrianChange) {
		setDataGlobal();
	}
});
