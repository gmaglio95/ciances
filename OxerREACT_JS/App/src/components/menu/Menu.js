import React, { Component } from 'react';

class Menu extends Component {


    render() {
        return (
            <nav className="menu-secondary">
                <ul className="clearfix list-unstyled">
                    <li key="Home">
                        <a title="Home" className="btn btn-link transform-scale-h border-0 p-0" href={process.env.PUBLIC_URL + "/"}>Home</a>
                    </li>
                </ul>
            </nav>
        );


    }
}
export default Menu;