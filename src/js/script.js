const hamburgerDiv = document.querySelector( ".hamburger-div" );
const hamburger = document.querySelector( ".hamburger" );
const inputHamburger = document.querySelector( "#input-hamburger" );
const menuWrapper = document.querySelector( ".menu-wrapper" );
const arrows = document.querySelectorAll( ".menu-item-has-children > a" );
const homeMain = document.querySelector( ".home #main" );

hamburgerDiv.addEventListener( "click", event => {
	event.stopPropagation();
	event.preventDefault();
	hamburger.classList.toggle( "close" );
	if ( hamburger.classList.contains( "close" ) ) {
		inputHamburger.checked = true;
		menuWrapper.classList.add( "show-menu" );
	} else {
		inputHamburger.checked = false;
		menuWrapper.classList.remove( "show-menu" );
	}
});

Array.from(arrows).forEach(arrow => {
	arrow.addEventListener( "click", (event) => {
		// event.stopPropagation();
		// event.preventDefault();
		console.log(event);
		console.log(event.target);
	});
});

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
