const homeMain = document.querySelector( ".home #main" );
const toTop = document.querySelector( ".to-top" );

/**
 * Change the home page background URL depending on the width.
 */
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

// Handle the front page which has a cover image and no scroll to top
if ( null === homeMain ) {
	// Not on the front page
	const main = document.querySelector( "#main" );

	toTop.addEventListener( "click", () => {
		document.body.scrollTop = 0;
		document.documentElement.scrollTop = 0;
	});

	window.onscroll = function() {
		scrollFunction();
	};
	main.removeAttribute( "data-url" );
	main.removeAttribute( "data-url1200" );
	main.removeAttribute( "data-url992" );
	main.removeAttribute( "data-url768" );
	main.removeAttribute( "data-url600" );
} else {
	// On the front page
	toTop.style.display = "none";
	window.addEventListener( "resize", () => {
		setBackGround();
	});
	setBackGround();
}

/**
 * Called when the window is scrolled.
 *
 * Will enable the scroll to top button if the window has been scrolled more than 20 pixels
 */
const scrollFunction = () => {
	if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
		toTop.style.display = "flex";
	} else {
		toTop.style.display = "none";
	}
}
