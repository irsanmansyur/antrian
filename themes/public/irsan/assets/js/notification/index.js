const elLoket = document.querySelector("#loket");
function changeButton(id) {
	let Btn = elLoket.querySelector(`#btn${id}`);
	Btn.classList.toggle("btn-danger");
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
let waits = new Promise((res, rej) => {});
async function panggil(nomor, loket) {
	waits();
	changeButton(loket);
	audio.currentTime = 0;
	audio.src = baseUrl + "assets/audio/new/in.wav";
	time = await playAudio();
	audio.src = baseUrl + "assets/audio/new/nomor-urut.MP3";
	time = await playAudio(100);
	let next = null;
	let end = null;
	if (nomor < 10) {
		audio.src = baseUrl + "assets/audio/new/" + nomor + ".MP3";
	} else if (nomor == 10) {
		audio.src = baseUrl + "assets/audio/new/sepuluh.MP3";
	} else if (nomor == 11) {
		audio.src = baseUrl + "assets/audio/new/sebelas.MP3";
	} else if (nomor < 20) {
		next = baseUrl + "assets/audio/new/belas.MP3";
		let no = nomor.substr(-1);
		audio.src = baseUrl + "assets/audio/new/" + no + ".MP3";
	} else if (nomor % 2 == 0) {
		no = nomor.substr(0, 1);
		next = baseUrl + "assets/audio/new/puluh.MP3";
		audio.src = baseUrl + "assets/audio/new/" + no + ".MP3";
	} else if (nomor < 100) {
		no = nomor.substr(0, 1);
		end = nomor.substr(-1);
		next = baseUrl + "assets/audio/new/puluh.MP3";
		audio.src = baseUrl + "assets/audio/new/" + no + ".MP3";
	}
	time = await playAudio();
	if (next) time = await playAudio(10);
	if (end) time = await playAudio(50);
	audio.src = baseUrl + "assets/audio/new/loket.MP3";
	time = await playAudio(100);
	audio.src = baseUrl + "assets/audio/new/" + loket + ".MP3";
	time = await playAudio(200);
	audio.src = baseUrl + "assets/audio/new/out.wav";
	time = await playAudio();
	changeButton(loket);
	await postData(baseUrl + "home/setData", { id: nomor }).then(data => {
		console.log(data);
	});
	waits(res => {
		res(true);
	});
}
async function postData(url = "", data = {}) {
	const fd = new FormData();
	for (var i in data) {
		fd.append(i, data[i]);
	}
	const response = await fetch(url, {
		method: "POST",
		mode: "cors",
		body: fd
	});
	return await response.json(); // parses JSON response into native JavaScript objects
}

let ButtonLoket = (status, id) => {
	let html = "";
	if (status == 1) {
		html = `<button id="btn${id}" class="btn btn-primary btn-lg d-block w-100" type="button">
                    <h2 class="display-5 text-center">Nomor Antrian ${id}</h2>
                </button>`;
	} else if (status == 0) {
		html = `<button id="btn${id}" class="btn btn-warning btn-lg d-block w-100" type="button">
                    <h2 class="display-5 text-center">Open</h2>
                </button>`;
	} else {
		html = `<button id="btn${id}" class="btn btn-secondary btn-lg d-block w-100" type="button">
                    <h2 class="display-5 text-center">Tutup</h2>
                </button>`;
	}
	return html;
};
load();

async function load() {
	let data = await fetch(baseUrl + "home/getData")
		.then(res => res.json())
		.then(res => res);

	let html = "";
	data.loket.forEach(({ client, status, id }) => {
		html += `
            <div class="card card-loket">
                <div class="card-body text-center">
                    <h1 class="card-title text-center display-2"><b>Loket ${client}</b></h1>
                    <hr class="white">
                    ${ButtonLoket(status, id)}
                </div>
            </div>`;
	});
	elLoket.innerHTML = html;

	const elAntri = document.querySelector(".next-antri");
	if (data.nextAntri == "kosong") {
		elAntri.innerHTML = `
            <h1><span>Sudah tidak ada Antrian </span></h1>
            <button class="btn btn-light btn-lg" type="button"><span class="fa fa-university">&nbsp;</span>Kosong.!</button>`;
	} else {
		elAntri.setAttribute("next", data.nextAntri.id);
		elAntri.innerHTML = `
            <h1 class="display-4 mb-4">Siap siap  <b>Nomor Antrian ${data.nextAntri.id}</b></h1>
            <button class="btn btn-light btn-lg" type="button"><span class="fa fa-university">&nbsp;</span>Di LOKET .?</button>
            <div class="container mt-3">
                <a href="${baseUrl}admin/antrian/selesai/${data.nextAntri.id}" class="btn btn-warning">Waiting..!</a>
            </div>`;
	}

	data.loket.forEach(loket => {
		let antri = data.content.filter(res => {
			if (res) return res.counter == loket.client;
		});

		if (antri.length > 0)
			if (loket.status == 1 && antri[0].status == 2) {
				console.log("memanggil");
				console.log(antri[0].id);
				console.log(antri[0].counter);
				panggil(antri[0].id, antri[0].counter);
			}
	});
}

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher("f6b62ae006c0b51482f4", {
	cluster: "ap1",
	forceTLS: true
});
var channel = pusher.subscribe("my-channel");

channel.bind("my-event", async function(data) {
	if (data.message === "notif") {
		await awaits();
		load();
	}
});
