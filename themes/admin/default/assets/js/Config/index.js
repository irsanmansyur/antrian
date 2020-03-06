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
Pusher.logToConsole = true;

// Enable pusher logging - don't include this in production
var pusher = new Pusher("f6b62ae006c0b51482f4", {
	cluster: "ap1",
	forceTLS: true
});
var channel = pusher.subscribe("my-channel");
channel.bind("my-event", async function(data) {
	if ("playing" in data) playing(data.playing);
});

let isPlay = false;
const panggil = document.querySelector("#panggil");
let link = panggil.href;
panggil.addEventListener("click", e => {
	e.preventDefault();
	if (!isPlay) {
		postData(link);
		playing(false);
	}
});

let playing = status => {
	if (status) {
		isPlay = true;
		panggil.disabled = true;
		panggil.removeAttribute("href");
	} else {
		isPlay = false;
		panggil.disabled = false;
		panggil.setAttribute("href", link);
	}
};
