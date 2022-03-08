import React, { Component } from 'react';
import emailjs from 'emailjs-com';
import axios from 'axios';

class ContactForm extends Component {
    constructor( props ) {
        super( props );
        emailjs.init("user_2seXrSExGmFvXckjeKIlW");
        
        this.state = {
            values: {
                name: '',
                email: '',
                message: ''
            },
            successMessage: "Sender's message was sent successfully",
            warningMessage: 'Fill up the form, please!',
            errorMessage: 'Something go wrong. Try again later!',
            alertClass: '',
            responseMessage: '',
            alertTimeout: '',
            delay: 5000
        };
    }

    submitForm = async e => {

      
        e.preventDefault();
        
        if ( document.querySelector( '#alert' ) ) {
            document.querySelector( '#alert' ).remove();
        }
        emailjs.send("service_cx3l55n","template_jivjru5",this.state.values).then( response => {
            if ( response.status === 200 ) {
                this.setState( { responseMessage: this.state.successMessage } );
            }else {
                this.setState( { responseMessage: this.state.errorMessage } );
            }

            // if ( response.data.status === 'warning' ) {
            //     this.setState( { responseMessage: this.state.warningMessage } );
            // }
            this.callAlert( this.state.responseMessage, response.status )
        } ).catch( error => {
            this.callAlert( this.state.errorMessage, 'error' )
        } );

        this.setState( { isSubmitting: true } );

        
    };

    removeAlert = () => {
        clearTimeout( this.state.alertTimeout );
        this.setState( {
            alertTimeout: setTimeout( function() {
                    var element = document.querySelector( '#alert' );
                    element.classList.remove( 'fadeIn' );
                    element.classList.add( 'fadeOut' );
                    setTimeout( function() {
                        element.remove()
                    }, 900 )
                }, this.state.delay
            )
        } );
    };

    callAlert = ( message, type ) => {
        if ( ! document.querySelector( '#alert' ) ) {
            if ( type === 'success' ) {
                this.setState( { alertClass: 'success' } )
            }

            if ( type === 'error' ) {
                this.setState( { alertClass: 'danger' } )
            }

            if ( type === 'warning' ) {
                this.setState( { alertClass: 'warning' } )
            }

            var alert = '<div id="alert" class="animated fadeIn alert alert--shadow alert-' + this.state.alertClass + '">' + message + '</div>';

            var element = document.querySelector( '.wpcf7-form' );

            element.insertAdjacentHTML( 'beforeend', alert );

            this.removeAlert();
        }
    };

    handleInputChange = e =>
        this.setState( {
            values: {
                ...this.state.values,
                [e.target.name]: e.target.value
            }
        } );

    render() {
        return (
            <form onSubmit={ this.submitForm } className="wpcf7-form">
                <p className="input-group gutter-width-30">
                    <span className="gutter-width">
                        <input name="name"
                               type="text"
                               value={ this.state.values.name }
                               onChange={ this.handleInputChange }
                               size="30"
                               maxLength="245"
                               required="required"
                               placeholder="Nome *" />
                    </span>

                    <span className="gutter-width">
                        <input name="email"
                               type="email"
                               value={ this.state.values.email }
                               onChange={ this.handleInputChange }
                               size="30"
                               maxLength="100"
                               required="required"
                               placeholder="Email/Cellulare *" />
                    </span>
                </p>

                <p>
                    <textarea name="message"
                              cols="45"
                              rows="8"
                              value={ this.state.values.message }
                              onChange={ this.handleInputChange }
                              maxLength="65525"
                              required="required"
                              placeholder="Messaggio *"></textarea>
                </p>

                <p>
                    <input name="submit" type="submit" className="btn btn-dark border-0 transform-scale-h" defaultValue="Send" />
                </p>
            </form>
        );
    }
}

export default ContactForm;
