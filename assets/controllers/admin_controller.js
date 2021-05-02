import { Controller } from 'stimulus';
// import $ from 'jquery';
var $  = require( 'jquery' );
require('bootstrap');

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    connect() {
        $(".leftArrow").on('click', function () {
            console.log('works')
            const leftPos = $('.show').scrollLeft();
            $(".show").animate({scrollLeft: leftPos - 300}, 100);
          });
          
        $(".rightArrow").on('click', function () {
            const leftPos = $('.show').scrollLeft();
            $('.show').scrollLeft(leftPos + 150);
        });
      
      $('.modalbtn').on('click', function () {
        console.log("modal")
        $('#horairesModal').modal('show')
      });
      $('.backButton').on('click', function () {
        console.log('back');
        window.history.back();
      })

      function replaceClass(el, oldClass, newClass) {
        const element = $(`.${el}`);
        if (element.hasClass(oldClass)) {
          element.removeClass(oldClass)
        }
        element.addClass(newClass)
      }
      

      $('.prev').on('click', function (e) {
        e.preventDefault();
        replaceClass("first-part", "d-none", "d-block")
        replaceClass("second-part", "d-block", "d-none")
        replaceClass("prev", "visible", "invisible")
        $('.next').removeClass('d-none')
        replaceClass("next", "invisible", "visible")
        replaceClass("envoi", 'd-block', 'd-none')
        replaceClass("continue", 'd-block', 'd-none')
      })

      $('.next').on('click', function (e) {
        e.preventDefault();
        replaceClass("first-part", "d-block",  "d-none" )
        replaceClass("second-part", "d-none", "d-block")
        replaceClass("prev", "invisible", "visible")
        replaceClass("next", 'visible', 'invisible')
        if ($('.biblio-select select option:selected').val() == "oui") {
          replaceClass("continue", 'd-none', 'd-block')
          replaceClass("next", 'invisible', 'd-none')
        } else if($('.biblio-select select option:selected').val() == "non") {
          replaceClass("envoi", 'd-none', 'd-block')
          replaceClass("next", 'invisible', 'd-none')
        }
      })
    
   
      $('.biblio-select select').on('change', function () {
        if ($('.biblio-select select option:selected').val() == "oui") {
            replaceClass("continue", 'd-none', 'd-block')
            replaceClass("envoi", 'd-block', 'd-none')
          replaceClass("next", 'invisible', 'd-none')
          
          if ($('#adhesion_form_email').val().length < 1) {
              replaceClass("email-obligatoire", 'd-none', 'd-block')
              $('#adhesion_form_email').addClass('is-invalid').attr("required", "true")
            replaceClass("continue", 'd-block', 'invisible')

              $('#adhesion_form_email').on('change', function () {
                if ($('#adhesion_form_email').val().length > 1) {
                  $('#adhesion_form_email').removeClass('is-invalid')
                  replaceClass("email-obligatoire", 'd-block', 'd-none')
                  replaceClass("continue", 'invisible', 'd-block')
                } else if($('#adhesion_form_email').val().length < 1) {
                  replaceClass("continue", 'd-block', 'invisible')
                  $('#adhesion_form_email').addClass('is-invalid').attr("required", "true")
              replaceClass("email-obligatoire", 'd-none', 'd-block')

                }
              })
            }
            
          } else if($('.biblio-select select option:selected').val() == "non") {
            replaceClass("envoi", 'd-none', 'd-block')
            replaceClass("continue", 'd-block', 'd-none')
            replaceClass("next", 'invisible', 'd-none')
            replaceClass("email-obligatoire", 'd-block', 'd-none')
            $('#adhesion_form_email').removeClass('is-invalid').attr("required", false)
            
          } else {
            replaceClass("next", 'd-none', 'invisible')
            replaceClass("envoi", 'd-block', 'd-none')
            replaceClass("continue", 'd-block', 'd-none')
            replaceClass("continue", 'padding-footer', 's-padding')

          
        } 
  })
  
      $('.proprio-select select').on('change', function () {
        if ($('.proprio-select select option:selected').val() == "assoc") {
          replaceClass("search-adh", 'd-block', 'd-none')
        } else {
          replaceClass("search-adh", 'd-none', 'd-block')

        }
      })

      $('#search-adherent').on('click', function (e) {
        e.preventDefault();
        const searched = $('#search_form_nom').val();
        $.ajax({
          url: 'new/adh',
          type: 'POST',
          data: {'data' : searched},
          dataType : 'json', 
          success : function(json){ 
            console.log('success')
            $.each(json, function (index, value) {
              // if (value.adhesionbibliotheque) {
              //   $('#search-results').append(`<tr><td class='text-center'>${value.nom}</td><td class='text-center'>${value.prenom}</td><td class='text-center'>${value.telephone}</td><td class='text-center'>${value.adhesionbibliotheque.categoriefourmi}</td></tr>`)
              // }

              console.log(value);
             
          });
     
          }
        });
        
      })
    }
}
