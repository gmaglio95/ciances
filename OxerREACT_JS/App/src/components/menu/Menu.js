import React, { Component } from 'react';

class Menu extends Component {


    render() {
        return (
            <div class="row">

                <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                    <div class="list-group list-group-horizontal-sm">
                        <div class="list-group-item no-border">

                            <a title="Works" href={process.env.PUBLIC_URL + "/works"}>Works</a>

                        </div>
                        <div class="list-group-item no-border">

                            <a title="About" href={process.env.PUBLIC_URL + "/about"}>About</a>

                        </div>
                        <div class="list-group-item no-border">

                            <a title="Contacts" href={process.env.PUBLIC_URL + "/contacts"}>Contacts</a>

                        </div>
                    </div>
                </div>
            </div>


        );


    }
}
export default Menu;