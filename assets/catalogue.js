// import Splide from "@splidejs/splide";
// document.addEventListener("DOMContentLoaded", function () {
//   var secondarySlider = new Splide("#secondary-slider", {
//     fixedWidth: 100,
//     height: 60,
//     gap: 10,
//     cover: true,
//     isNavigation: true,
//     focus: "center",
//     breakpoints: {
//       600: {
//         fixedWidth: 66,
//         height: 40,
//       },
//     },
//   }).mount();

//   var primarySlider = new Splide("#primary-slider", {
//     type: "fade",
//     heightRatio: 0.5,
//     pagination: false,
//     arrows: false,
//     cover: true,
//   });

//   primarySlider.sync(secondarySlider).mount();
// });

// document.addEventListener( 'DOMContentLoaded', function () {
// 	new Splide( '#third-slider', {
//     fixedWidth : 200,
// 		height     : 200,
// 		gap        : 10,
// 		rewind     : true,
// 		cover      : true,
// 		pagination : false,
// 	} ).mount();
// } );
	
			
// document.addEventListener( 'DOMContentLoaded', function () {
// 	new Splide( '#fourth-slider', {
// 		fixedWidth : 200,
// 		height     : 200,
// 		gap        : 10,
// 		rewind     : true,
// 		cover      : true,
// 		pagination : false,
// 	} ).mount();
// } );

 //accordéon

  //Listen for click on the document
 document.addEventListener('click', function (event) {
  
   //Bail if our clicked element doesn't have the class
   if (!event.target.classList.contains('accordion-toggle')) return;
  
   // Get the target content
   var content = document.querySelector(event.target.hash);
   if (!content) return;
  
   // Prevent default link behavior
   event.preventDefault();
  
   // If the content is already expanded, collapse it and quit
   if (content.classList.contains('active')) {
     content.classList.remove('active');
     return;
   }
  
   // Get all open accordion content, loop through it, and close it
   var accordions = document.querySelectorAll('.accordion-content.active');
   for (var i = 0; i < accordions.length; i++) {
     accordions[i].classList.remove('active');
   }
  
   // Toggle our content
   content.classList.toggle('active');
 })