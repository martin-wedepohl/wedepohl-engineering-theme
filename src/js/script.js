const homeMain = document.querySelector( ".home #main" );

function setBackGround() {
	const width = window.innerWidth;
	let url = '';
	if (width <= 600) {
		url = homeMain.dataset.url600;
	} else if (width <= 768) {
		url = homeMain.dataset.url768;
	} else if (width <= 992) {
		url = homeMain.dataset.url992;
	} else if (width <= 1200) {
		url = homeMain.dataset.url1200;
	} else {
		url = homeMain.dataset.url;
	}
	if ( "" !== url ) {
		homeMain.style.backgroundImage = "url('" + url + "')";
	}
}

// Handle the front page which has a cover image
if ( null === homeMain ) {
	// Not on the front page
	const main = document.querySelector( "#main" );
	main.removeAttribute( "data-url'" );
	main.removeAttribute( "data-url1200" );
	main.removeAttribute( "data-url992" );
	main.removeAttribute( "data-url768" );
	main.removeAttribute( "data-url600" );
} else {
	// On the front page
	window.addEventListener( "resize", () => {
		setBackGround();
	});
	setBackGround();
}
