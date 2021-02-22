const menuOpen = document.querySelector( "#primary-mobile-menu .open" );
const menuClose = document.querySelector( "#primary-mobile-menu .close" );
const primaryMenuContainer = document.querySelector( ".primary-menu-container" );
const homeMain = document.querySelector( ".home #main" );

// Handle the primary menu
if ( null !== menuOpen && null !== menuClose ) {
	menuOpen.addEventListener( "click", e => {
		const show = e.target.dataset.show;
		if ( "true" === show ) {
			e.target.dataset.show = "false";
			e.target.style.display = "none";
			menuClose.dataset.show = "true";
			menuClose.style.display = "flex";
			primaryMenuContainer.style.display = "flex";
		}
	});
	menuClose.addEventListener( "click", e => {
		const show = e.target.dataset.show;
		if ( "true" === show ) {
			e.target.dataset.show = "false";
			e.target.style.display = "none";
			menuOpen.dataset.show = "true";
			menuOpen.style.display = "flex";
			primaryMenuContainer.style.display = "none";
		}
	});
}

// Handle the front page which has a cover image
if ( null === homeMain ) {
	// Not on the front page
	const main = document.querySelector( '#main' );
	main.removeAttribute('data-url');
} else {
	// On the front page
	const url = homeMain.dataset.url;
	homeMain.style.backgroundImage = "url('" + url + "')";
}
