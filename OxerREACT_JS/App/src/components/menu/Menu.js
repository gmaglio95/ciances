import React, { Component } from 'react';

class Menu extends Component {


    render() {
        return (
            <nav className="menu-secondary">
                <ul className="clearfix list-unstyled">
                    <li key="Work">
                        <a title="Works" className="btn btn-link transform-scale-h border-0 p-0" href={process.env.PUBLIC_URL + "/works"}>Works</a>
                    </li>
                    <li key="Work">
                        <a title="About" className="btn btn-link transform-scale-h border-0 p-0" href={process.env.PUBLIC_URL + "/about"}>About</a>
                    </li>
                    <li key="Work">
                        <a title="Contacts" className="btn btn-link transform-scale-h border-0 p-0" href={process.env.PUBLIC_URL + "/contacts"}>Contacts</a>
                    </li>
                </ul>
            </nav>
        );


    }
}
export default Menu;