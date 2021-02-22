const siteTitle = document.querySelector( '.site-title' );
const siteDescription = document.querySelector( '.site-description' );
const projectsButton = document.getElementById( 'projects-button' );

const addCustomizer = () => {

	wp.customize(
		'background_color', 
		value => {
			value.bind(
				newval => {
					document.body.style.backgroundColor = newval;
				}
			);
		}
	);
	
	wp.customize(
		'blogname',
		value => {
			value.bind(
				newval => {
					siteTitle.innerHTML = newval;
				}
			);
		}
	);
	
	wp.customize(
		'blogdescription',
		value => {
			value.bind(
				newval => {
					siteDescription.innerHTML = newval;
				}
			);
		}
	);

	wp.customize(
		'button_text',
		value => {
			value.bind(
				newval => {
					projectsButton.innerHTML = newval;
				}
			);
		}
	);

}

addCustomizer();
