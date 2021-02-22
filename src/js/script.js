const homeMain = document.querySelector( '.home #main' );
if ( null === homeMain ) {
	const main = document.querySelector( '#main' );
	main.removeAttribute('data-url');
} else {
	const url = homeMain.dataset.url;
	homeMain.style.backgroundImage = "url('" + url + "')";
}
